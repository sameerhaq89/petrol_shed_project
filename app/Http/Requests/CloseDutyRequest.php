<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CloseDutyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the assignment ID from the route to validate reading logic
        $assignmentId = $this->route('id');
        $assignment = \App\Models\PumpOperatorAssignment::find($assignmentId);
        $minReading = $assignment ? $assignment->opening_reading : 0;

        return [
            'closing_reading'       => 'required|numeric|gte:' . $minReading,
            'closing_cash_received' => 'required|numeric|min:0',
        ];
    }
}