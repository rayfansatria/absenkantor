<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\DailySchedule;
use App\Models\WorkShift;
use Carbon\Carbon;

class AttendanceService
{
    /**
     * Check if employee is late for clock in
     * 
     * @param Employee $employee
     * @param string $clockInTime Time in H:i:s format
     * @param string $date Date in Y-m-d format
     * @return array Late status and duration
     */
    public function checkLateStatus(Employee $employee, $clockInTime, $date): array
    {
        // Get employee's schedule for the day
        $schedule = DailySchedule::where('employee_id', $employee->id)
            ->whereDate('schedule_date', $date)
            ->first();

        if (!$schedule || !$schedule->workShift) {
            return [
                'is_late' => false,
                'late_duration_minutes' => 0,
                'scheduled_time' => null
            ];
        }

        $shift = $schedule->workShift;
        $scheduledTime = Carbon::parse($date . ' ' . $shift->clock_in_time);
        $actualTime = Carbon::parse($date . ' ' . $clockInTime);
        
        // Add tolerance
        $scheduledTimeWithTolerance = $scheduledTime->copy()->addMinutes($shift->late_tolerance_minutes ?? 0);

        if ($actualTime->greaterThan($scheduledTimeWithTolerance)) {
            $lateDuration = $scheduledTimeWithTolerance->diffInMinutes($actualTime);
            
            return [
                'is_late' => true,
                'late_duration_minutes' => $lateDuration,
                'scheduled_time' => $scheduledTime->format('H:i:s'),
                'tolerance_minutes' => $shift->late_tolerance_minutes ?? 0
            ];
        }

        return [
            'is_late' => false,
            'late_duration_minutes' => 0,
            'scheduled_time' => $scheduledTime->format('H:i:s'),
            'tolerance_minutes' => $shift->late_tolerance_minutes ?? 0
        ];
    }

    /**
     * Check if employee left early
     * 
     * @param Employee $employee
     * @param string $clockOutTime Time in H:i:s format
     * @param string $date Date in Y-m-d format
     * @return array Early leave status and duration
     */
    public function checkEarlyLeave(Employee $employee, $clockOutTime, $date): array
    {
        // Get employee's schedule for the day
        $schedule = DailySchedule::where('employee_id', $employee->id)
            ->whereDate('schedule_date', $date)
            ->first();

        if (!$schedule || !$schedule->workShift) {
            return [
                'is_early' => false,
                'early_duration_minutes' => 0,
                'scheduled_time' => null
            ];
        }

        $shift = $schedule->workShift;
        $scheduledTime = Carbon::parse($date . ' ' . $shift->clock_out_time);
        $actualTime = Carbon::parse($date . ' ' . $clockOutTime);

        if ($actualTime->lessThan($scheduledTime)) {
            $earlyDuration = $actualTime->diffInMinutes($scheduledTime);
            
            return [
                'is_early' => true,
                'early_duration_minutes' => $earlyDuration,
                'scheduled_time' => $scheduledTime->format('H:i:s')
            ];
        }

        return [
            'is_early' => false,
            'early_duration_minutes' => 0,
            'scheduled_time' => $scheduledTime->format('H:i:s')
        ];
    }

    /**
     * Calculate working hours between clock in and clock out
     * 
     * @param string $clockInTime
     * @param string $clockOutTime
     * @return float Working hours
     */
    public function calculateWorkingHours($clockInTime, $clockOutTime): float
    {
        $clockIn = Carbon::parse($clockInTime);
        $clockOut = Carbon::parse($clockOutTime);
        
        return round($clockIn->diffInMinutes($clockOut) / 60, 2);
    }

    /**
     * Get attendance status based on attendance data
     * 
     * @param EmployeeAttendance|null $attendance
     * @return string Status: present, absent, late, leave, etc.
     */
    public function getAttendanceStatus($attendance): string
    {
        if (!$attendance) {
            return 'absent';
        }

        if ($attendance->attendance_status) {
            return $attendance->attendance_status;
        }

        if ($attendance->clock_in_time && $attendance->clock_out_time) {
            return $attendance->is_late ? 'late' : 'present';
        }

        if ($attendance->clock_in_time) {
            return $attendance->is_late ? 'late' : 'present';
        }

        return 'absent';
    }
}
