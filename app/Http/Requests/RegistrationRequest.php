<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return $this->get('user') ?: [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|alpha_num|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'can\'t be blank',
            'username.alpha_num' => 'is invalid',
            'username.unique' => 'is already taken.',
            'email.required' => 'can\'t be blank',
            'email.alpha_num' => 'is invalid',
            'email.unique' => 'is already taken.',
        ];
    }
}
