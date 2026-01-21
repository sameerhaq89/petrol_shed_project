<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'tank_name'     => 'required|string|max:255',
            'tank_number'   => [
                'required', 
                'string', 
                'max:50', 
                // Ensure uniqueness but ignore deleted records
                Rule::unique('tanks')->whereNull('deleted_at')
            ],
            'station_id'    => 'nullable|exists:stations,id', // Service handles auto-assignment if null
            'fuel_type_id'  => 'required|exists:fuel_types,id',
            'capacity'      => 'required|numeric|min:0',
            'current_stock' => 'nullable|numeric|min:0|lte:capacity',
            
            // Added from your old file
            'reorder_level' => 'nullable|numeric|min:0',
            'minimum_level' => 'nullable|numeric|min:0',
            'maximum_level' => 'nullable|numeric|min:0',
            'status'        => 'required|in:active,inactive,maintenance,offline',
        ];
    }
}