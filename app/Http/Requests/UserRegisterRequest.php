<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'fname' => 'required|string|max:100',
            'lname' => 'required|string|max:100',
            'username' => 'required|string|max:20|alpha_dash|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => ['required','confirmed', Password::min(8)],
        ];
    }

    public function messages(): array
    {
        return [
            'fname.required' => 'The First Name field is required',
            'lname.required' => 'The Last Name field is required',
            'password.min' => 'Password must be 8 character',
        ];
    }
}
