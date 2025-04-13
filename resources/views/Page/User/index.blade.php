
@extends('template')
@section('title', 'User')
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a 
                href="{{ route('users.create') }}" 
                class="mb-3 btn btn-info">Buat User</a>
                <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control me-2" 
                        placeholder="Cari User..." 
                        value="{{ request('search') }}">
                    <button type="
                    " class="btn btn-secondary">Cari</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <div class="d-flex justify-content-around">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                                        <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this user?')"
                                                class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
