<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashDropRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust if you have permission logic
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric|min:0.01',
            'notes'   => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Please select a pumper.',
            'amount.min' => 'The amount must be greater than 0.',
        ];
    }
}