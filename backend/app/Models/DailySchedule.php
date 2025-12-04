<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'shift_id',
        'date',
        'is_off',
    ];

    protected $casts = [
        'date' => 'date',
        'is_off' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift()
    {
        return $this->belongsTo(WorkShift::class, 'shift_id');
    }
}
