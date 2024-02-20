<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'instrument_id' => ['required', 'integer', 'exists:instruments,id'],
            'group_id' => ['required', 'integer', 'exists:groups,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'criteria_id' => ['required', 'integer', 'exists:criterias,id'],
            'point' => ['required', 'numeric'],
        ];
    }
}
