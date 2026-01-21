<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignPumperRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'      => 'required|exists:users,id',
            'pump_id'      => 'required|exists:pumps,id',
            'opening_cash' => 'nullable|numeric|min:0',
        ];
    }
}