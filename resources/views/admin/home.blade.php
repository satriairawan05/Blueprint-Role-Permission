@extends('admin.layout.app')

@section('app')

    <div class="card">
        <div class="card-body">
            <h1 class="fw-bold fs-3 text-center">Hello, {{ auth()->user()->name }}!</h1>
        </div>
    </div>
@endsection
