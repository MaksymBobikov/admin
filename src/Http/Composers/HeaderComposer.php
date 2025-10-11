<?php

namespace Maksb\Admin\Http\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view): void
    {
        $user = Auth::guard('admin')->user();

        $view->with('user', $user);
    }
}
