<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|min:10',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'leave_type_id.required' => 'Tipe cuti harus dipilih',
            'leave_type_id.exists' => 'Tipe cuti tidak valid',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'start_date.date' => 'Format tanggal mulai tidak valid',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.date' => 'Format tanggal selesai tidak valid',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh kurang dari tanggal mulai',
            'reason.required' => 'Alasan harus diisi',
            'reason.min' => 'Alasan minimal 10 karakter',
            'attachment.file' => 'Lampiran harus berupa file',
            'attachment.mimes' => 'Format lampiran harus pdf, jpg, jpeg, atau png',
            'attachment.max' => 'Ukuran lampiran maksimal 2MB',
        ];
    }
}
