<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'month',
        'year',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class, 'payroll_period_id');
    }
}
