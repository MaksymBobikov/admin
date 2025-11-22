<?php

namespace Maksb\Admin\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Maksb\Admin\Domain\Auth\PermissionsEnum;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows(PermissionsEnum::ADMINS_INDEX);
    }
}
