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
        <div class="card-header">User</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text"
                            class="form-control form-control-sm @error('name')
                            is-invalid
                            @enderror"
                            id="name" name="name" value="{{ old('name', $user->name) }}" autofocus
                            placeholder="ex: admin" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text"
                            class="form-control form-control-sm @error('email')
                            is-invalid
                            @enderror"
                            id="email" name="email" value="{{ old('email', $user->email) }}" autofocus
                            placeholder="ex: name@mail.com" readonly>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary"><i
                                class="bi bi-skip-backward"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header">Roles</div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
                    @foreach ($user->roles as $user_role)
                        <form
                            action="{{ route('user.role.destroy', ['user' => $user->id, 'role' => $user_role->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">{{ $user_role->name }}</button>
                        </form>
                    @endforeach
            </div>
            <form action="{{ route('user.role', $user->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="role" class="form-label">Roles</label>
                    <select class="form-select" name="role" aria-label="Default select example">
                        @foreach ($role as $r)
                            @if (old('role') == $r)
                                <option value="{{ $r->name }}" selected>
                                    {{ $r->name }}</option>
                            @else
                                <option value="{{ $r->name }}">
                                    {{ $r->name }}</option>
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
    <div class="card mt-3">
        <div class="card-header">Permissions</div>
        <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    @foreach ($user->permissions as $user_permission)
                        <form
                            action="{{ route('user.permission.destroy', ['user' => $user->id, 'permission' => $user_permission->id]) }}"
                            method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-danger">{{ $user_permission->name }}</button>
                        </form>
                    @endforeach
                </div>
            <form action="{{ route('user.permission', $user->id) }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="permission" class="form-label">Permissions</label>
                    <select class="form-select" name="permission" aria-label="Default select example">
                        @foreach ($permission as $perm)
                            @if (old('permission') == $perm)
                                <option value="{{ $perm->name }}" selected>
                                    {{ $perm->name }}</option>
                            @else
                                <option value="{{ $perm->name }}">
                                    {{ $perm->name }}</option>
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
