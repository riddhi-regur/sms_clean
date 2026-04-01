<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(
                    Student::find($this->student)?->user_id
                ),
            ],

            'password' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'min:6',
             ],

            'name' => ['required', 'string', 'max:255'],

            'phone' => ['nullable', 'string', 'max:15'],

            'address' => ['nullable', 'string'],

            'roll_no' => [
                'required',
                Rule::unique('students', 'roll_no')->ignore($this->student),
             ],

            'course_id' => ['required', 'exists:courses,id'],

            'classroom_id' => ['required', 'exists:classrooms,id'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',

            'name.required' => 'Name is required.',

            'roll_no.required' => 'Roll number is required.',

            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course is invalid.',

            'classroom_id.required' => 'Classroom is required.',
            'classroom_id.exists' => 'Selected classroom is invalid.',

            'image.image' => 'File must be an image.',
            'image.mimes' => 'Only JPG, JPEG, PNG formats allowed.',
            'image.max' => 'Image size must be less than 2MB.',
        ];
    }
}
