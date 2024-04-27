<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Department_Update_Request extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                       => 'nullable|string|between:2,10',
            'description'                => 'nullable|string',
        ];
    }
}
