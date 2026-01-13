<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdjustTankStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'required|numeric|min:0.01',
            'type'     => 'required|in:add,subtract', // Strict type checking
            'reason'   => 'required|string|max:255',
        ];
    }
}