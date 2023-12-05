@extends('admin.layout.app')

@section('app')
    <div class="card">
        <div class="card-header">{{ $name }}</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 d-flex justify-content-end align-items-end">
                    <a href="{{ route('role.create') }}" class="btn btn-sm btn-success"><i class="bi bi-plus-circle"></i></a>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($role as $r)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $r->name }}</td>
                                    <td>
                                        <a href="{{ route('role.edit', $r->id) }}" class="btn btn-warning btn-sm"><i
                                                class="bi bi-pen"></i></a>
                                        <form action="{{ route('role.destroy', $r->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
