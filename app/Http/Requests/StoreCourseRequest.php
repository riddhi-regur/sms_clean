<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
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
                'max:50',
                Rule::unique('courses', 'code')->ignore($this->route('course')),
            ],

            'duration' => 'required|string|max:50',

            'fees' => 'required|numeric|min:0',

            'department_id' => 'required|exists:departments,id',

            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            // Name
            'name.required' => 'Course name is required.',
            'name.string' => 'Course name must be valid text.',
            'name.max' => 'Course name cannot exceed 255 characters.',

            // Code
            'code.required' => 'Course code is required.',
            'code.string' => 'Course code must be valid text.',
            'code.max' => 'Course code cannot exceed 50 characters.',
            'code.unique' => 'This course code already exists.',

            // Duration
            'duration.required' => 'Duration is required.',
            'duration.string' => 'Duration must be valid text.',
            'duration.max' => 'Duration cannot exceed 50 characters.',

            // Fees
            'fees.required' => 'Fees is required.',
            'fees.numeric' => 'Fees must be a number.',
            'fees.min' => 'Fees cannot be negative.',

            // Department
            'department_id.required' => 'Department is required.',
            'department_id.exists' => 'Selected department is invalid.',

            // Description
            'description.string' => 'Description must be valid text.',
            'description.max' => 'Description cannot exceed 1000 characters.',
        ];
    }
}
