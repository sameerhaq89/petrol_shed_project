<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePumpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the pump ID from the route to ignore it during unique check
        $pumpId = $this->route('pump') ?? $this->route('id');

        return [
            'pump_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('pumps')->ignore($pumpId)->where(function ($query) {
                    return $query->where('station_id', \Illuminate\Support\Facades\Auth::user()->station_id)
                        ->whereNull('deleted_at');
                })
            ],
            'pump_name'          => 'required|string|max:255',
            'tank_id'            => 'required|exists:tanks,id',
            'status'             => 'required|in:active,maintenance,offline',
            'last_meter_reading' => 'nullable|numeric|min:0' // Optional if editing opening reading is allowed
        ];
    }
}
