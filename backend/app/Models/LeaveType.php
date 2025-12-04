<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id',
        'name',
        'code',
        'max_days',
        'requires_approval',
        'is_paid',
        'is_active',
    ];

    protected $casts = [
        'max_days' => 'integer',
        'requires_approval' => 'boolean',
        'is_paid' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'leave_type_id');
    }
}
