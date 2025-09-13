<?php

namespace Maksb\Admin\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
        ];
    }
}
