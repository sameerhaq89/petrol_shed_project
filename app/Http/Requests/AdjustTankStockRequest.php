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
            'quantity' => 'required|numeric|min:0',
            'type'     => 'required|in:refill,dip,correction',
            'reason'   => 'nullable|string|max:255'
        ];
    }
}