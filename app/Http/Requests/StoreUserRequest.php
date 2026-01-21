<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'role_id'    => 'required|exists:roles,id',
            // Station is required UNLESS role is Super Admin (ID 1)
            'station_id' => 'required_if:role_id,!=,1|nullable|exists:stations,id',
            'password'   => 'required|string|min:8',
            'phone'      => 'nullable|string|max:20'
        ];
    }
}