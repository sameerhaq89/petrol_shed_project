<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePumpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the pump ID from the route to ignore it during the unique check
        $pumpId = $this->route('pump') ? $this->route('pump') : $this->route('id');

        return [
            'pump_name'          => 'required|string|max:255',
            // Unique check ignores the current pump's ID
            'pump_number'        => 'required|string|max:50|unique:pumps,pump_number,' . $pumpId,
            'tank_id'            => 'required|exists:tanks,id',
            'status'             => 'required|in:active,maintenance,offline',
            'last_meter_reading' => 'nullable|numeric|min:0',
            'notes'              => 'nullable|string|max:500',
        ];
    }
}