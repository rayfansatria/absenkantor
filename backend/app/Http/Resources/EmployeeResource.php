<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'user_id' => $this->user_id,
            'institution_id' => $this->institution_id,
            'employee_number' => $this->employee_number,
            'full_name' => $this->full_name,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'department_id' => $this->department_id,
            'position_id' => $this->position_id,
            'join_date' => $this->join_date,
            'employee_status' => $this->employee_status,
            'photo_url' => $this->photo_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'department' => $this->whenLoaded('department', function () {
                return [
                    'id' => $this->department->id,
                    'name' => $this->department->name,
                    'code' => $this->department->code,
                ];
            }),
            'position' => $this->whenLoaded('position', function () {
                return [
                    'id' => $this->position->id,
                    'name' => $this->position->name,
                    'code' => $this->position->code,
                ];
            }),
            'institution' => $this->whenLoaded('institution', function () {
                return [
                    'id' => $this->institution->id,
                    'code' => $this->institution->code,
                    'name' => $this->institution->name,
                ];
            }),
        ];
    }
}
