@extends('noSidebar')
@section('title', 'Product Created')
@section('content')

    <body>
        <div class="card-body">
            <form class="mx-2 form-horizontal form-material" method="POST" action="{{ route('products.store') }}" 
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Name Product <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control form-control-line" placeholder="Name Product">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Image Product <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="file" name="image" class="form-control form-control-line" placeholder="Image Product">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Price <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="price" id="price" class="form-control form-control-line" placeholder="Price">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Stock <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="number" name="stock" class="form-control form-control-line" placeholder="Stock">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col text-start">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary w-25">Cancel</a>
                    </div>
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary w-25">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </body>


@endsection
