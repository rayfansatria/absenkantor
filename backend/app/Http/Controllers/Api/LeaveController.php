<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest as Leave;
use App\Models\LeaveType;
use App\Models\EmployeeLeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * Get leave requests list
     */
    public function index(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $leaves = Leave::where('employee_id', $employee->id)
                ->with(['leaveType', 'approvals'])
                ->orderBy('created_at', 'desc')
                ->paginate($request->input('per_page', 15));
            
            return response()->json([
                'success' => true,
                'data' => $leaves,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data cuti',
            ], 500);
        }
    }

    /**
     * Create new leave request
     */
    public function store(\App\Http\Requests\LeaveRequest $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $totalDays = $startDate->diffInDays($endDate) + 1;
            
            // Check leave balance
            $balance = EmployeeLeaveBalance::where('employee_id', $employee->id)
                ->where('leave_type_id', $request->leave_type_id)
                ->where('year', now()->year)
                ->first();
            
            if ($balance && $balance->remaining_days < $totalDays) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sisa cuti tidak mencukupi',
                ], 400);
            }
            
            // Store attachment if provided
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('leaves', 'public');
            }
            
            // Create leave request
            $leave = Leave::create([
                'employee_id' => $employee->id,
                'leave_type_id' => $request->leave_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_days' => $totalDays,
                'reason' => $request->reason,
                'status' => 'pending',
                'attachment' => $attachmentPath,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan cuti berhasil',
                'data' => $leave,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengajukan cuti: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get leave detail
     */
    public function show($id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $leave = Leave::where('id', $id)
                ->where('employee_id', $employee->id)
                ->with(['leaveType', 'approvals.approver'])
                ->firstOrFail();
            
            return response()->json([
                'success' => true,
                'data' => $leave,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data cuti tidak ditemukan',
            ], 404);
        }
    }

    /**
     * Cancel leave request
     */
    public function destroy($id)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $leave = Leave::where('id', $id)
                ->where('employee_id', $employee->id)
                ->firstOrFail();
            
            if ($leave->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya cuti dengan status pending yang dapat dibatalkan',
                ], 400);
            }
            
            $leave->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Pengajuan cuti berhasil dibatalkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan cuti',
            ], 500);
        }
    }

    /**
     * Get leave types
     */
    public function types()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $types = LeaveType::where('institution_id', $employee->institution_id)
                ->where('is_active', true)
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $types,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tipe cuti',
            ], 500);
        }
    }

    /**
     * Get leave balance
     */
    public function balance()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $balances = EmployeeLeaveBalance::where('employee_id', $employee->id)
                ->where('year', now()->year)
                ->with('leaveType')
                ->get();
            
            return response()->json([
                'success' => true,
                'data' => $balances,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil saldo cuti',
            ], 500);
        }
    }
}
