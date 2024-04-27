<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Employee_Update_Request extends FormRequest
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
            'first_name'               => 'nullable|string|between:2,10',
            'last_name'                => 'nullable|string|between:2,10',
            'email'                    => 'nullable|string|email',
            'position'                 => 'nullable|string',
        ];
    }
}
