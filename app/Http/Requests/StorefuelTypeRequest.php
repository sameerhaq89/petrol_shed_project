<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFuelTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:100',
            'code'       => [
                'required', 
                'string', 
                'max:50', 
                Rule::unique('fuel_types')->whereNull('deleted_at')
            ],
            'unit'       => 'required|string|max:20', // e.g., Liters
            'density'    => 'nullable|numeric|min:0',
            'color_code' => 'nullable|string|max:20', // e.g., #FF5733
            'is_active'  => 'nullable|boolean'
        ];
    }
}