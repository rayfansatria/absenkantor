<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\EmployeeLeaveBalance;
use Carbon\Carbon;

class LeaveService
{
    /**
     * Check if employee has sufficient leave balance
     * 
     * @param int $employeeId
     * @param int $leaveTypeId
     * @param int $days
     * @param int $year
     * @return array Balance check result
     */
    public function checkLeaveBalance($employeeId, $leaveTypeId, $days, $year = null): array
    {
        $year = $year ?? now()->year;

        $balance = EmployeeLeaveBalance::where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', $year)
            ->first();

        if (!$balance) {
            // If no balance record exists, check if we should create one with default quota
            $leaveType = LeaveType::find($leaveTypeId);
            
            if ($leaveType && $leaveType->default_quota_days > 0) {
                $balance = EmployeeLeaveBalance::create([
                    'employee_id' => $employeeId,
                    'leave_type_id' => $leaveTypeId,
                    'year' => $year,
                    'initial_balance' => $leaveType->default_quota_days,
                    'used_balance' => 0,
                    'remaining_balance' => $leaveType->default_quota_days
                ]);
            } else {
                return [
                    'has_balance' => false,
                    'message' => 'Tidak memiliki kuota cuti untuk tipe ini',
                    'remaining' => 0,
                    'requested' => $days
                ];
            }
        }

        $remaining = $balance->remaining_balance ?? 0;

        if ($remaining >= $days) {
            return [
                'has_balance' => true,
                'message' => 'Kuota cuti mencukupi',
                'remaining' => $remaining,
                'requested' => $days,
                'after_request' => $remaining - $days
            ];
        }

        return [
            'has_balance' => false,
            'message' => 'Kuota cuti tidak mencukupi',
            'remaining' => $remaining,
            'requested' => $days,
            'shortage' => $days - $remaining
        ];
    }

    /**
     * Calculate total days for leave request (excluding weekends)
     * 
     * @param string $startDate
     * @param string $endDate
     * @param bool $excludeWeekends
     * @return int Total days
     */
    public function calculateLeaveDays($startDate, $endDate, $excludeWeekends = true): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        if (!$excludeWeekends) {
            return $start->diffInDays($end) + 1;
        }

        $totalDays = 0;
        $current = $start->copy();

        while ($current->lte($end)) {
            // Skip weekends (Saturday = 6, Sunday = 0)
            if (!in_array($current->dayOfWeek, [0, 6])) {
                $totalDays++;
            }
            $current->addDay();
        }

        return $totalDays;
    }

    /**
     * Deduct leave balance after approval
     * 
     * @param int $employeeId
     * @param int $leaveTypeId
     * @param int $days
     * @param int $year
     * @return bool Success status
     */
    public function deductLeaveBalance($employeeId, $leaveTypeId, $days, $year = null): bool
    {
        $year = $year ?? now()->year;

        $balance = EmployeeLeaveBalance::where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', $year)
            ->first();

        if (!$balance || $balance->remaining_balance < $days) {
            return false;
        }

        $balance->used_balance += $days;
        $balance->remaining_balance -= $days;
        $balance->save();

        return true;
    }

    /**
     * Restore leave balance after rejection or cancellation
     * 
     * @param int $employeeId
     * @param int $leaveTypeId
     * @param int $days
     * @param int $year
     * @return bool Success status
     */
    public function restoreLeaveBalance($employeeId, $leaveTypeId, $days, $year = null): bool
    {
        $year = $year ?? now()->year;

        $balance = EmployeeLeaveBalance::where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', $year)
            ->first();

        if (!$balance) {
            return false;
        }

        $balance->used_balance = max(0, $balance->used_balance - $days);
        $balance->remaining_balance = $balance->initial_balance - $balance->used_balance;
        $balance->save();

        return true;
    }

    /**
     * Check for overlapping leave requests
     * 
     * @param int $employeeId
     * @param string $startDate
     * @param string $endDate
     * @param int|null $excludeLeaveId
     * @return bool Has overlap
     */
    public function hasOverlappingLeave($employeeId, $startDate, $endDate, $excludeLeaveId = null): bool
    {
        $query = LeaveRequest::where('employee_id', $employeeId)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function($q2) use ($startDate, $endDate) {
                      $q2->where('start_date', '<=', $startDate)
                         ->where('end_date', '>=', $endDate);
                  });
            });

        if ($excludeLeaveId) {
            $query->where('id', '!=', $excludeLeaveId);
        }

        return $query->exists();
    }
}
