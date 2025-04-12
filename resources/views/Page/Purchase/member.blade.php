@extends('template')

@section('title', 'Pembayaran Member')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">
            <form method="POST" 
            {{-- action="{{ route('purchases.sale.detail.store', $transaction->id) }} --}}
            ">
                @csrf
                <div class="row">
                    <!-- Tabel Produk -->
                    <div class="col-lg-6 col-md-12">
                        <div class="table table-bordered">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction_details as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ formattedPrice($item->product->price) }}</td>
                                        <td>{{ formattedPrice($item->subtotal) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"><strong>Total Harga</strong></td>
                                        <td><strong>{{ formattedPrice($transaction->total_price) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Total Bayar</strong></td>
                                        <td><strong>{{ formattedPrice($transaction->total_pay) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Kembalian</strong></td>
                                        <td><strong>{{ formattedPrice($transaction->total_return) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Form Member -->
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Nama Member</label>
                            <input type="text" id="name" class="form-control" name="name"
                                value="{{ $transaction->customer->name ?? '-' }}" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="poin" class="form-label">Total Poin</label>
                            <input type="text" id="poin" class="form-control"
                                value="{{ $transaction->customer->total_point ?? 0 }}" readonly>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="Ya" id="check2" name="check_poin"
                                {{ $isMany ? 'disabled' : '' }}>
                            <label class="form-check-label" for="check2">
                                Gunakan poin
                            </label>
                            @if ($isMany)
                            <div><small class="text-danger">Poin tidak bisa digunakan pada transaksi pertama.</small></div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary" type="submit">Selanjutnya</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
