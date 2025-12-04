<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClockInRequest;
use App\Http\Requests\ClockOutRequest;
use App\Models\AttendanceLocation;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Clock in with GPS location and photo
     */
    public function clockIn(ClockInRequest $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data karyawan tidak ditemukan',
                ], 404);
            }
            
            // Check if already clocked in today
            $today = Carbon::today();
            $existingAttendance = EmployeeAttendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();
            
            if ($existingAttendance && $existingAttendance->clock_in_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan clock in hari ini',
                ], 400);
            }
            
            // Validate GPS location
            $isValidLocation = $this->validateLocation(
                $request->latitude,
                $request->longitude,
                $employee->institution_id
            );
            
            if (!$isValidLocation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi Anda tidak sesuai dengan area absensi yang diizinkan',
                ], 400);
            }
            
            // Store photo
            $photoPath = $request->file('photo')->store('attendance/clock-in', 'public');
            
            // Create or update attendance record
            $attendance = EmployeeAttendance::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'date' => $today,
                ],
                [
                    'clock_in_time' => now(),
                    'clock_in_location' => $request->location,
                    'clock_in_latitude' => $request->latitude,
                    'clock_in_longitude' => $request->longitude,
                    'clock_in_photo' => $photoPath,
                    'status' => 'present',
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Clock in berhasil',
                'data' => [
                    'id' => $attendance->id,
                    'date' => $attendance->date,
                    'clock_in_time' => $attendance->clock_in_time,
                    'location' => $attendance->clock_in_location,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Clock in gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Clock out with GPS location and photo
     */
    public function clockOut(ClockOutRequest $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data karyawan tidak ditemukan',
                ], 404);
            }
            
            // Find today's attendance
            $today = Carbon::today();
            $attendance = EmployeeAttendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();
            
            if (!$attendance || !$attendance->clock_in_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum melakukan clock in hari ini',
                ], 400);
            }
            
            if ($attendance->clock_out_time) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan clock out hari ini',
                ], 400);
            }
            
            // Validate GPS location
            $isValidLocation = $this->validateLocation(
                $request->latitude,
                $request->longitude,
                $employee->institution_id
            );
            
            if (!$isValidLocation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lokasi Anda tidak sesuai dengan area absensi yang diizinkan',
                ], 400);
            }
            
            // Store photo
            $photoPath = $request->file('photo')->store('attendance/clock-out', 'public');
            
            // Calculate work duration
            $clockInTime = Carbon::parse($attendance->clock_in_time);
            $clockOutTime = now();
            $workDuration = $clockInTime->diffInMinutes($clockOutTime);
            
            // Update attendance record
            $attendance->update([
                'clock_out_time' => $clockOutTime,
                'clock_out_location' => $request->location,
                'clock_out_latitude' => $request->latitude,
                'clock_out_longitude' => $request->longitude,
                'clock_out_photo' => $photoPath,
                'work_duration' => $workDuration,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Clock out berhasil',
                'data' => [
                    'id' => $attendance->id,
                    'date' => $attendance->date,
                    'clock_in_time' => $attendance->clock_in_time,
                    'clock_out_time' => $attendance->clock_out_time,
                    'work_duration' => $workDuration . ' menit',
                    'location' => $attendance->clock_out_location,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Clock out gagal: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get today's attendance status
     */
    public function today()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $today = Carbon::today();
            $attendance = EmployeeAttendance::where('employee_id', $employee->id)
                ->whereDate('date', $today)
                ->first();
            
            return response()->json([
                'success' => true,
                'data' => $attendance ? [
                    'id' => $attendance->id,
                    'date' => $attendance->date,
                    'clock_in_time' => $attendance->clock_in_time,
                    'clock_out_time' => $attendance->clock_out_time,
                    'work_duration' => $attendance->work_duration,
                    'status' => $attendance->status,
                    'has_clocked_in' => !is_null($attendance->clock_in_time),
                    'has_clocked_out' => !is_null($attendance->clock_out_time),
                ] : [
                    'has_clocked_in' => false,
                    'has_clocked_out' => false,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data absensi',
            ], 500);
        }
    }

    /**
     * Get attendance history
     */
    public function history(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $query = EmployeeAttendance::where('employee_id', $employee->id)
                ->orderBy('date', 'desc');
            
            // Filter by month and year if provided
            if ($request->has('month') && $request->has('year')) {
                $query->whereMonth('date', $request->month)
                    ->whereYear('date', $request->year);
            }
            
            $attendances = $query->paginate($request->input('per_page', 15));
            
            return response()->json([
                'success' => true,
                'data' => $attendances,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat absensi',
            ], 500);
        }
    }

    /**
     * Get monthly attendance summary
     */
    public function summary(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $month = $request->input('month', now()->month);
            $year = $request->input('year', now()->year);
            
            $attendances = EmployeeAttendance::where('employee_id', $employee->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get();
            
            $summary = [
                'month' => $month,
                'year' => $year,
                'total_days' => $attendances->count(),
                'present_days' => $attendances->where('status', 'present')->count(),
                'late_days' => $attendances->where('status', 'late')->count(),
                'absent_days' => $attendances->where('status', 'absent')->count(),
                'total_work_hours' => round($attendances->sum('work_duration') / 60, 2),
            ];
            
            return response()->json([
                'success' => true,
                'data' => $summary,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil ringkasan absensi',
            ], 500);
        }
    }

    /**
     * Get valid attendance locations
     */
    public function locations()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $locations = AttendanceLocation::where('institution_id', $employee->institution_id)
                ->where('is_active', true)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $locations,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil lokasi absensi',
            ], 500);
        }
    }

    /**
     * Validate if user location is within allowed radius
     */
    private function validateLocation($latitude, $longitude, $institutionId)
    {
        $locations = AttendanceLocation::where('institution_id', $institutionId)
            ->where('is_active', true)
            ->get();
        
        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $location->latitude,
                $location->longitude
            );
            
            if ($distance <= $location->radius) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }
}
