<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DailySchedule;
use App\Models\WorkShift;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ScheduleController extends Controller
{
    /**
     * Get work schedules
     */
    public function index(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $query = DailySchedule::where('employee_id', $employee->id)
                ->with('shift')
                ->orderBy('date', 'desc');
            
            if ($request->has('month') && $request->has('year')) {
                $query->whereMonth('date', $request->month)
                    ->whereYear('date', $request->year);
            }
            
            $schedules = $query->paginate($request->input('per_page', 30));
            
            return response()->json([
                'success' => true,
                'data' => $schedules,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil jadwal kerja',
            ], 500);
        }
    }

    /**
     * Get available shifts
     */
    public function shifts()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $shifts = WorkShift::where('institution_id', $employee->institution_id)
                ->where('is_active', true)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $shifts,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data shift',
            ], 500);
        }
    }

    /**
     * Get holidays
     */
    public function holidays(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $query = Holiday::where('institution_id', $employee->institution_id);
            
            if ($request->has('year')) {
                $query->whereYear('date', $request->year);
            }
            
            $holidays = $query->orderBy('date', 'asc')->get();
            
            return response()->json([
                'success' => true,
                'data' => $holidays,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data libur',
            ], 500);
        }
    }
}
