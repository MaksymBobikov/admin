@extends('maksb/admin::layout.app')
@section('content')
    <div class="d-flex">
        <sidebar></sidebar>
        <div class="flex-grow-1 p-3">
            @yield('page-content')
        </div>
    </div>
@endsection
