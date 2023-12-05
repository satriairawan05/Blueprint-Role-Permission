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
                    <form action="{{ route('role.update', $role->id) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"
                                class="form-control form-control-sm @error('name')
                            is-invalid
                            @enderror"
                                id="name" name="name" value="{{ old('name', $role->name) }}" autofocus
                                placeholder="ex: admin">
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
    <div class="card mt-3">
        <div class="card-header">Role Permission</div>
        <div class="card-body">
            @if ($role->permissions)
                <div class="d-flex justify-content-between align-items-baseline">
                    @foreach ($role->permissions as $role_permission)
                        <form
                            action="{{ route('role.permission.revoke', ['role' => $role->id, 'permission' => $role_permission->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">{{ $role_permission->name }}</button>
                        </form>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('role.permission.store', $role->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="permission" class="form-label">Permission</label>
                    <select class="form-select" name="permission" aria-label="Default select example">
                        @foreach ($permission as $perm)
                            @if (old('permission') == $perm->name)
                                <option value="{{ $perm->name }}" selected>{{ $perm->name }}</option>
                            @else
                                <option value="{{ $perm->name }}">{{ $perm->name }}</option>
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
