<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayslipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'payroll_period_id' => $this->payroll_period_id,
            'slip_number' => $this->slip_number,
            'payment_date' => $this->payment_date,
            'base_salary' => $this->base_salary,
            'total_earnings' => $this->total_earnings,
            'total_deductions' => $this->total_deductions,
            'net_salary' => $this->net_salary,
            'payment_status' => $this->payment_status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employee' => $this->whenLoaded('employee', function () {
                return [
                    'id' => $this->employee->id,
                    'employee_number' => $this->employee->employee_number,
                    'full_name' => $this->employee->full_name,
                ];
            }),
            'payroll_period' => $this->whenLoaded('payrollPeriod', function () {
                return [
                    'id' => $this->payrollPeriod->id,
                    'period_name' => $this->payrollPeriod->period_name,
                    'start_date' => $this->payrollPeriod->start_date,
                    'end_date' => $this->payrollPeriod->end_date,
                ];
            }),
            'details' => $this->whenLoaded('details', function () {
                return $this->details->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'component_type' => $detail->component_type,
                        'component_name' => $detail->component_name,
                        'amount' => $detail->amount,
                        'description' => $detail->description,
                    ];
                });
            }),
        ];
    }
}
