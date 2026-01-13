<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTankRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Set to true to allow the request
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tank_name'       => 'required|string|max:255',
            'tank_number'     => 'required|string|max:50|unique:tanks,tank_number',
            'station_id'      => 'required|exists:stations,id',
            'fuel_type_id'    => 'required|integer', // or exists:fuel_types,id if you have that table
            'capacity'        => 'required|numeric|min:0',
            'current_stock'   => 'nullable|numeric|min:0|lte:capacity', // Stock cannot be more than capacity
            'reorder_level'   => 'nullable|numeric|min:0',
            'minimum_level'   => 'nullable|numeric|min:0',
            'maximum_level'   => 'nullable|numeric|min:0',
            'status'          => 'required|in:active,inactive,maintenance',
        ];
    }
}