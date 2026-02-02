<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTankRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the tank ID from the route to ignore it during unique check
        $tankId = $this->route('tank') ?? $this->route('id');

        return [
            'tank_name'     => 'required|string|max:255',
            'tank_number'   => [
                'required',
                'string',
                'max:50',
                // Check unique but ignore THIS tank's ID and scope to station
                Rule::unique('tanks')->ignore($tankId)->where(function ($query) {
                    return $query->where('station_id', \Illuminate\Support\Facades\Auth::user()->station_id)
                        ->whereNull('deleted_at');
                })
            ],
            'station_id'    => 'nullable|exists:stations,id',
            'fuel_type_id'  => 'required|exists:fuel_types,id',
            'capacity'      => 'required|numeric|min:0',

            // Stock is usually updated via AdjustStock, but if allowed here:
            'current_stock' => 'nullable|numeric|min:0|lte:capacity',

            'reorder_level' => 'nullable|numeric|min:0',
            'minimum_level' => 'nullable|numeric|min:0',
            'maximum_level' => 'nullable|numeric|min:0',
            'status'        => 'required|in:active,inactive,maintenance,offline',
        ];
    }
}
