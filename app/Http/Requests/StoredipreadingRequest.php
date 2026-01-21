<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDipReadingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tank_id'       => 'required|exists:tanks,id',
            'reading_date'  => 'required|date',
            'dip_level_cm'  => 'required|numeric|min:0',
            'volume_liters' => 'required|numeric|min:0',
            'temperature'   => 'nullable|numeric',
            'notes'         => 'nullable|string|max:255'
        ];
    }
}