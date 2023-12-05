@extends('admin.layout.app')

@push('css')
    <style type="text/css">
        label::after {
            content: '*';
            color: red;
        }
    </style>
@endpush

@section('app')
    <div class="card">
        <div class="card-header">{{ $name }}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('role.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                class="form-control form-control-sm @error('name')
                            is-invalid
                            @enderror"
                                id="name" name="name" value="{{ old('name') }}" autofocus placeholder="ex: admin">
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('role.index') }}" class="btn btn-sm btn-warning"><i
                                    class="bi bi-skip-backward"></i></a>
                            <button type="submit" class="btn btn-sm btn-success ms-2"><i class="bi bi-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
