@extends('noSidebar')
@section('title', 'Product Created')
@section('content')

    <body>
        <div class="card-body">
            <form class="mx-2 form-horizontal form-material" method="POST" action="{{ route('products.store') }}" 
                enctype="multipart/form-data" onsubmit="cleanPrice()">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Nama Product <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="name" class="form-control form-control-line" placeholder="Nama Product">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Gambar Product <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="file" name="image" class="form-control form-control-line" placeholder="Gambar Product">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-12">Harga <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="price" id="price" class="form-control form-control-line" placeholder="Harga" oninput="formatPrice(this)">
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
                        <a href="{{ route('products.index') }}" class="btn btn-secondary w-25">Kembali</a>
                    </div>
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary w-25">Kirim</button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function formatPrice(input) {
                let value = input.value.replace(/[^\d]/g, "");  // Menghapus karakter non-numerik
                if (value) {
                    value = 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");  // Format dengan titik pemisah ribuan
                }
                input.value = value;  // Update nilai input
            }

            function cleanPrice() {
                let priceInput = document.getElementById('price');
                // Menghapus simbol 'Rp' dan titik sebelum mengirim form
                priceInput.value = priceInput.value.replace(/[^\d]/g, "");
            }
        </script>
    </body>

@endsection
