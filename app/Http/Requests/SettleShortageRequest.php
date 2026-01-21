<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettleShortageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'settle_amount' => 'required|numeric|min:0.01',
        ];
    }
}