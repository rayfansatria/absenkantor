<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'total_days',
        'present_days',
        'late_days',
        'absent_days',
        'leave_days',
        'total_work_hours',
        'total_overtime_hours',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'total_days' => 'integer',
        'present_days' => 'integer',
        'late_days' => 'integer',
        'absent_days' => 'integer',
        'leave_days' => 'integer',
        'total_work_hours' => 'decimal:2',
        'total_overtime_hours' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
