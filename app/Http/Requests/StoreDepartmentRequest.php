<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',

            'code' => [
                'required',
                'string',
                Rule::unique('departments', 'code')
                    ->ignore($this->department),
            ],

            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            // Name
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be valid text.',
            'name.max' => 'Name cannot exceed 255 characters.',

            // Code
            'code.required' => 'Code is required.',
            'code.string' => 'Code must be valid text.',
            'code.max' => 'Code cannot exceed 50 characters.',
            'code.unique' => 'This code already exists.',

            // Description
            'description.string' => 'Description must be valid text.',
            'description.max' => 'Description cannot exceed 1000 characters.',
        ];
    }
}
