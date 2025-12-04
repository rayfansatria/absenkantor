<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'attendance_date' => $this->attendance_date,
            'clock_in_time' => $this->clock_in_time,
            'clock_out_time' => $this->clock_out_time,
            'clock_in_latitude' => $this->clock_in_latitude,
            'clock_in_longitude' => $this->clock_in_longitude,
            'clock_out_latitude' => $this->clock_out_latitude,
            'clock_out_longitude' => $this->clock_out_longitude,
            'clock_in_photo_url' => $this->clock_in_photo_url,
            'clock_out_photo_url' => $this->clock_out_photo_url,
            'clock_in_address' => $this->clock_in_address,
            'clock_out_address' => $this->clock_out_address,
            'work_duration_minutes' => $this->work_duration_minutes,
            'attendance_status' => $this->attendance_status,
            'is_late' => $this->is_late,
            'late_duration_minutes' => $this->late_duration_minutes,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employee' => $this->whenLoaded('employee', function () {
                return [
                    'id' => $this->employee->id,
                    'employee_number' => $this->employee->employee_number,
                    'full_name' => $this->employee->full_name,
                    'photo_url' => $this->employee->photo_url,
                ];
            }),
        ];
    }
}
