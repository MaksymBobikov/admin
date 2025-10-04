<?php

namespace Maksb\Admin\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Maksb\Admin\Domain\Auth\PermissionsEnum;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows(PermissionsEnum::SHOW_DASHBOARD);
    }
}
