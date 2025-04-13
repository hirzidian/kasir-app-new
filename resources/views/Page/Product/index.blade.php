@extends('template')

@section('title', 'Product')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="table-responsive">
            <div class="card-header d-flex justify-content-between align-items-center">
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('products.create') }}" class="btn btn-info">Buat Product</a>
                @endif
            {{-- Search --}}
                <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control me-2" 
                        placeholder="Cari product..." 
                        value="{{ request('search') }}">
                    <button type="
                    " class="btn btn-secondary">Cari</button>
                </form>
            </div>
            {{-- Table --}}
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        @if (Auth::user()->role == 'admin')
                        <th scope="col">Action</th>
                        @endif
                    </tr>
                </thead>
                {{-- Memanggil data yang ada di data base --}}
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="100"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product['price'], 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        @if (Auth::user()->role == 'admin')    
                        <td>
                            <div class="d-flex justify-content-around">
                                <a 
                                href="{{ route('products.edit', $product->id) }}" 
                                class="btn btn-warning">Edit</a>
                                <form 
                                action="{{ route('products.destroy', $product->id) }}" 
                                method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="confirm('YAKIN BROO')" class="btn btn-danger">Hapus</button>
                            </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
