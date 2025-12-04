<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OvertimeRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class OvertimeController extends Controller
{
    /**
     * Get overtime requests list
     */
    public function index(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $overtimes = OvertimeRequest::where('employee_id', $employee->id)
                ->with('approver')
                ->orderBy('date', 'desc')
                ->paginate($request->input('per_page', 15));
            
            return response()->json([
                'success' => true,
                'data' => $overtimes,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data lembur',
            ], 500);
        }
    }

    /**
     * Create new overtime request
     */
    public function store(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $request->validate([
                'date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required',
                'reason' => 'required|string|min:10',
            ]);
            
            $startTime = Carbon::parse($request->date . ' ' . $request->start_time);
            $endTime = Carbon::parse($request->date . ' ' . $request->end_time);
            $durationHours = $startTime->diffInHours($endTime, true);
            
            $overtime = OvertimeRequest::create([
                'employee_id' => $employee->id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'duration_hours' => $durationHours,
                'reason' => $request->reason,
                'status' => 'pending',
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan lembur berhasil',
                'data' => $overtime,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan lembur: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get overtime detail
     */
    public function show($id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $overtime = OvertimeRequest::where('id', $id)
                ->where('employee_id', $employee->id)
                ->with('approver')
                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $overtime,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data lembur tidak ditemukan',
            ], 404);
        }
    }
}
