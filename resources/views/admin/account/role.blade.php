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
                    <form action="{{ route('user.role.destroy', ['user' => $user->id, 'role' => $user_role->id]) }}"
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
                            <option value="{{ $r->name }}" {{ old('role') == $r->name ? 'selected' : '' }}>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-sm btn-success ms-2">Assign</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-5 mt-3">
        <div class="card-header">Permission</div>
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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permission_distinct as $d)
                                <tr>
                                    <td>{{ $d }}</td>
                                    <td>
                                        @foreach ($permission as $p)
                                            @php
                                                $isChecked = in_array($p->name, $user->permissions->pluck('name')->toArray()) ? 'checked' : '';
                                            @endphp
                                            <input type="checkbox" name="{{ $p->id }}"
                                                id="{{ $p->name . '.' . $p->id }}" class="form-check-input"
                                                {{ $isChecked }}>
                                            {{ str_replace('user.', '', $p->name) }}
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-sm btn-success ms-2">Assign</button>
                </div>
            </form>
        </div>
    </div>
@endsection
