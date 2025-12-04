<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'action',
        'timestamp',
        'notes',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function attendance()
    {
        return $this->belongsTo(EmployeeAttendance::class, 'attendance_id');
    }
}
