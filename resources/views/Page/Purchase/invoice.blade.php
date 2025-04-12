@extends('template')

@section('title', 'Invoice')

@section('content')

<div class="card p-4">
    <div class="card-body p-0">
        <div class="invoice-container">

            {{-- Header --}}
            <div class="invoice-header mb-4">
                <div class="row gutters align-items-center">
                    <div class="col-md-9">
                        <h4 class="mb-0">Invoice - #{{ $purchase->id }}</h4>
                        <p>{{ $purchase->sale_date }}</p>
                        @if ($customer)
                            <p>Pelanggan: {{ $customer->name }} ({{ $customer->no_hp ?? '-' }})</p>
                        @else
                            <p>Pelanggan: Non Member</p>
                        @endif
                    </div>
                    <div class="col-md-3 text-end">
                        <div class="custom-actions-btns">
                            <a href="{{ route('purchases.index') }}" class="btn btn-secondary mb-2">
                                <i class="icon-arrow-left"></i> Kembali
                            </a>
                            <a href="#" class="btn btn-primary">
                                <i class="icon-download"></i> Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Produk --}}
            <div class="invoice-body">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Quantity</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_details as $detail)
                                <tr>
                                    <td>{{ $detail->product->name ?? '-' }}</td>
                                    <td>Rp. {{ number_format($detail->product->price ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $detail->amount }}</td>
                                    <td>Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Total dan Info Tambahan --}}
            <div class="invoice-price d-flex justify-content-between align-items-center mt-4 border-top pt-3">
                <div class="invoice-price-left">
                    <div class="d-flex flex-column">
                        <div class="mb-2">
                            <small>POIN DIGUNAKAN</small><br>
                            <strong>{{ $purchase->point ?? 0 }}</strong>
                        </div>
                        <div class="mb-2">
                            <small>KASIR</small><br>
                            <strong>{{ $purchase->user->name ?? '-' }}</strong>
                        </div>
                        <div class="mb-2">
                            <small>KEMBALIAN</small><br>
                            <strong>Rp. {{ number_format($purchase->total_return ?? 0, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                </div>
                <div class="invoice-price-right text-end">
                    <small>TOTAL</small><br>
                    <span class="fs-5 fw-bold">Rp. {{ number_format($purchase->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
