@extends('noSidebar')
@section('title', 'User Update')
@section('content')

    <div class="card-body">
        <form class="mx-2 form-horizontal form-material" method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Email <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="email" name="email" class="form-control form-control-line "
                            value="{{ $user->email }}"
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Nama <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="text" name="name" class="form-control form-control-line "
                            value="{{ $user->name }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-12">Role <span class="text-danger">*</span></label>
                        <div class="col-md-12" 
                        value="{{ $user->role }}"
                        >
                            <select name="role" class="shadow-none form-select form-control-line" >
                                <option value="admin">Admin</option>
                                <option value="penjaga">penjaga</option>
                            </select>
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
@endsection
