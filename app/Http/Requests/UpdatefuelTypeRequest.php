<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFuelTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the ID from route parameter to ignore during unique check
        $id = $this->route('fuel_type') ?? $this->route('id');

        return [
            'name'       => 'required|string|max:100',
            'code'       => [
                'required',
                'string',
                'max:50',
                Rule::unique('fuel_types')->ignore($id)->whereNull('deleted_at')
            ],
            'unit'       => 'required|string|max:20',
            'density'    => 'nullable|numeric|min:0',
            'color_code' => 'nullable|string|max:20',
            'is_active'  => 'nullable|boolean'
        ];
    }
}