<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashDropRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Update this if you have specific permissions
    }

    public function rules(): array
    {
        return [
            'station_id' => 'required|exists:stations,id',
            'amount'     => 'required|numeric|min:0.01',
            'notes'      => 'nullable|string|max:255',
        ];
    }
}