<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the ID of the tank being updated to ignore it in unique checks
        $tankId = $this->route('tank') ? $this->route('tank') : $this->route('id');

        return [
            'tank_name'       => 'required|string|max:255',
            // Unique check ignores the current tank's ID
            'tank_number'     => 'required|string|max:50|unique:tanks,tank_number,' . $tankId, 
            'station_id'      => 'required|exists:stations,id',
            'fuel_type_id'    => 'required|integer',
            'capacity'        => 'required|numeric|min:0',
            'reorder_level'   => 'nullable|numeric|min:0',
            'minimum_level'   => 'nullable|numeric|min:0',
            'maximum_level'   => 'nullable|numeric|min:0',
            'status'          => 'required|in:active,inactive,maintenance',
        ];
    }
}