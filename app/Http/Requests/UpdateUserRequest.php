<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') ?? $this->route('id');

        return [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $userId,
            'role_id'    => 'required|exists:roles,id',
            'station_id' => 'required_if:role_id,!=,1|nullable|exists:stations,id',
            'password'   => 'nullable|string|min:8',
            'phone'      => 'nullable|string|max:20'
        ];
    }
}