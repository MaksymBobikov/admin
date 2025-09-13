<?php

namespace Maksb\Admin\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required','email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }
}
