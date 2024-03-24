<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:50|unique:users',
            'name' => 'nullable|string|max:25',
            'surname' => 'nullable|string|max:35',
            'email' => 'required|string|email|max:30|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => ['nullable', Rule::in(['m', 'f'])],
            'birthday' => 'nullable|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'A username is required.',
            'username.unique' => 'The username has already been taken.',
            'email.required' => 'An email is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'A password is required.',
            'password.confirmed' => 'Passwords do not match.',
            'gender.in' => 'The selected gender is invalid. Allowed values are male (m) or female (f).',
            'birthday.date' => 'The birthday must be a valid date.'
        ];
    }
}
