@extends('noSidebar')
@section('title', 'Create User')
@section('content')

<div class="card-body">
    <form class="mx-2 form-horizontal form-material" method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12">Email <span class="text-danger">*</span></label>
                    <div class="col-md-12">
                        <input type="email" name="email" class="form-control form-control-line" placeholder="Email" value="{{ old('email') }}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12">Nama <span class="text-danger">*</span></label>
                    <div class="col-md-12">
                        <input type="text" name="name" class="form-control form-control-line" placeholder="Nama" value="{{ old('name') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12">Role <span class="text-danger">*</span></label>
                    <div class="col-md-12">
                        <select name="role" class="shadow-none form-select form-control-line">
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        </select>
                    </div>
                </div>
            </div>                
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-12">Password <span class="text-danger">*</span></label>
                    <div class="col-md-12">
                        <input type="password" name="password" class="form-control form-control-line" placeholder="Password">
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col text-start">
                <a href="{{ route('users.index') }}" class="btn btn-secondary w-25">Cancel</a>
            </div>
            <div class="col text-end">
                <button type="submit" class="btn btn-primary w-25">Submit</button>
            </div>
        </div>            
    </form>
</div>
@endsection
