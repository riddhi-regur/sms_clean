<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClassroomRequest extends FormRequest
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

            'section' => 'required|string|max:50',

            'year' => 'required|integer|min:1|max:10',

            'course_id' => 'required|exists:courses,id',

            'department_id' => 'required|exists:departments,id',
        ];
    }

    public function messages()
    {
        return [
            // Name
            'name.required' => 'Classroom name is required.',
            'name.string' => 'Classroom name must be valid text.',
            'name.max' => 'Classroom name cannot exceed 255 characters.',

            // Section
            'section.required' => 'Section is required.',
            'section.string' => 'Section must be valid text.',
            'section.max' => 'Section cannot exceed 50 characters.',

            // Year
            'year.required' => 'Year is required.',
            'year.integer' => 'Year must be a number.',
            'year.min' => 'Year must be at least 1.',
            'year.max' => 'Year cannot exceed 10.',

            // Course
            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course is invalid.',

            // Department
            'department_id.required' => 'Department is required.',
            'department_id.exists' => 'Selected department is invalid.',
        ];
    }
}
