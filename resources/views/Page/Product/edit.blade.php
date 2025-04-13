@extends('noSidebar')
@section('title', 'Edit Product')
@section('content')

    <body>
        <div class="card-body">
            <form class="mx-2 form-horizontal form-material" method="POST" 
                action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" onsubmit="cleanPrice()">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Nama Produk <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control form-control-line " value="{{ $product->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Gambar Produk <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="file" name="image" class="form-control form-control-line ">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Harga <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="price" id="price" class="form-control form-control-line "
                                    value="{{ $product->price }}" oninput="formatPrice(this)">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Stok <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="number" name="stock" class="form-control form-control-line " 
                                    value="{{ $product->stock }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col text-start">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary w-25">Kembali</a>
                    </div>
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary w-25">Kirim</button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            // Format input value with "Rp" and thousand separators
            function formatPrice(input) {
                let value = input.value.replace(/[^\d]/g, "");  // Remove non-numeric characters
                if (value) {
                    value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");  // Format with thousands separator
                }
                input.value = value;  // Update the input field value
            }

            // Clean price before form submission: remove "Rp" and thousand separators
            function cleanPrice() {
                let priceInput = document.getElementById('price');
                // Remove "Rp" and thousand separators before sending to the server
                priceInput.value = priceInput.value.replace(/[^\d]/g, "");
            }
        </script>
    </body>

@endsection
