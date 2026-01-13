<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePumpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pump_name'          => 'required|string|max:255',
            'pump_number'        => 'required|string|max:50|unique:pumps,pump_number',
            'tank_id'            => 'required|exists:tanks,id',
            'status'             => 'required|in:active,maintenance,offline',
            'last_meter_reading' => 'nullable|numeric|min:0',
            'notes'              => 'nullable|string|max:500',
        ];
    }
}