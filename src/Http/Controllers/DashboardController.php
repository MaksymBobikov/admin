<?php

namespace Maksb\Admin\Http\Controllers;

use Maksb\Admin\Http\Requests\Dashboard\IndexRequest;

class DashboardController extends Controller
{
    public function index(IndexRequest $request)
    {
        return view('maksb/admin::dashboard.index');
    }
}
