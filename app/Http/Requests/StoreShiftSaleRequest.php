<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShiftSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shift_id'    => 'required|exists:shifts,id',
            'pump_id'     => 'required|exists:pumps,id',
            'end_reading' => 'required|numeric|gt:start_reading', 
        ];
    }


    protected function prepareForValidation()
    {
        $pump = \App\Models\Pump::find($this->pump_id);
        if ($pump) {
            $this->merge(['start_reading' => $pump->current_reading]);
        }
    }
}