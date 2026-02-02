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
            'tank_name' => 'required|string|max:255',
            'tank_number' => [
                'required',
                'string',
                'max:50',
                // Ensure uniqueness scoped to the active station
                Rule::unique('tanks')->where(function ($query) {
                    return $query->where('station_id', \Illuminate\Support\Facades\Auth::user()->station_id)
                        ->whereNull('deleted_at');
                })
            ],
            // 'station_id' is auto-assigned by Service/Controller logic, no need to validate generic user input.
            'fuel_type_id' => 'required|exists:fuel_types,id',
            'capacity' => 'required|numeric|min:0',
            'current_stock' => 'nullable|numeric|min:0|lte:capacity',

            // Stock Control
            'reorder_level' => 'nullable|numeric|min:0|lte:capacity',
            'minimum_level' => 'nullable|numeric|min:0|lte:capacity',
            'maximum_level' => 'nullable|numeric|min:0|lte:capacity',

            // Technical Details
            'tank_type' => 'nullable|string|in:underground,aboveground',
            'manufacturer' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',

            // Dates
            'installation_date' => 'nullable|date|before_or_equal:today',
            'last_cleaned_date' => 'nullable|date|before_or_equal:today',

            // Other
            'notes' => 'nullable|string|max:1000',



        ];
    }
}
