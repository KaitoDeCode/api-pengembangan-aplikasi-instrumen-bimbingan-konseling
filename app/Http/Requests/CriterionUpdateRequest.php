<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriterionUpdateRequest extends FormRequest
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
            'text' => ['required', 'string'],
            'minimum' => ['required', 'numeric'],
            'maximum' => ['required', 'numeric'],
        ];
    }
}
