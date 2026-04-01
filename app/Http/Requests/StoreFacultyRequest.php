<?php

namespace App\Http\Requests;

use App\Models\Faculty;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFacultyRequest extends FormRequest
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
                    Faculty::find($this->faculty)?->user_id
                ),
            ],

            'password' => [
                $this->isMethod('post') ? 'required' : 'nullable',
                'min:6',
            ],

            'name' => ['required', 'string', 'max:255'],

            'phone' => ['nullable', 'string', 'max:15'],

            'address' => ['nullable', 'string'],

            'designation' => ['required', 'string', 'max:255'],

            'department_id' => ['required', 'exists:departments,id'],

            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
