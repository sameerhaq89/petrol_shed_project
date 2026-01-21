<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShiftRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'station_id'   => 'required|exists:stations,id',
            'opening_cash' => 'required|numeric|min:0'
        ];
    }
}