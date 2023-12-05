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
                    <form action="{{ route('permission.update', $permission) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                class="form-control form-control-sm @error('name')
                            is-invalid
                            @enderror"
                                id="name" name="name" value="{{ old('name', $permission->name) }}" autofocus
                                placeholder="ex: read dashboard">
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('permission.index') }}" class="btn btn-sm btn-warning"><i
                                    class="bi bi-skip-backward"></i></a>
                            <button type="submit" class="btn btn-sm btn-success ms-2"><i class="bi bi-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">Roles</div>
        <div class="card-body">
            @if ($permission->roles)
                <div class="d-flex justify-content-between align-items-baseline">
                    @foreach ($permission->roles as $permission_role)
                        <form
                            action="{{ route('permission.role.remove', ['permission' => $permission->id, 'role' => $permission_role->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">{{ $permission_role->name }}</button>
                        </form>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('permission.role.store', $permission->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="role" class="form-label">Roles</label>
                    <select class="form-select" name="role" aria-label="Default select example">
                        @foreach ($role as $r)
                            @if (old('role') == $r->name)
                                <option value="{{ $r->name }}" selected>{{ $r->name }}</option>
                            @else
                                <option value="{{ $r->name }}">{{ $r->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-sm btn-success ms-2">Assign</button>
                </div>
            </form>
        </div>
    </div>
@endsection
