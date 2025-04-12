@extends('template')

@section('title', 'Invoice Penjualan')

@section('style')
    <style>
        .invoice-price {
            background: #f0f3f4;
            display: table;
            width: 100%
        }

        .invoice-price .invoice-price-left,
        .invoice-price .invoice-price-right {
            display: table-cell;
            padding: 20px;
            font-size: 20px;
            font-weight: 600;
            width: 75%;
            position: relative;
            vertical-align: middle
        }

        .invoice-price .invoice-price-left .sub-price {
            display: table-cell;
            vertical-align: middle;
            padding: 0 20px
        }

        .invoice-price small {
            font-size: 12px;
            font-weight: 400;
            display: block
        }

        .invoice-price .invoice-price-row {
            display: table;
            float: left
        }

        .invoice-price .invoice-price-right {
            width: 25%;
            background: #2d353c;
            color: #fff;
            font-size: 28px;
            text-align: right;
            vertical-align: bottom;
            font-weight: 300
        }

        .invoice-price .invoice-price-right small {
            display: block;
            opacity: .6;
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 12px
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row bg-light px-3 py-4 gutters">
            <div class="col-12">
                <div class="card p-4">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <div class="row gutters mb-4">
                                    <div class="col-12 d-flex justify-content-between">
                                        <div>
                                            <a class="btn btn-primary" href="#">
                                                <i class="mdi mdi-download"></i> Unduh (.pdf)
                                            </a>
                                        </div>
                                        <div>
                                            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">
                                                <i class="mdi mdi-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row gutters mb-3">
                                    <div class="col-md-9">
                                        @if ($customer)
                                            <address>
                                                <strong>{{ $customer->no_hp }}</strong><br>
                                                MEMBER SEJAK: {{ dateDmy($customer->created_at) }}<br>
                                                MEMBER POIN: {{ $customer->total_point }}
                                            </address>
                                        @else
                                            <address>
                                                <strong>Bukan Member</strong><br>
                                            </address>
                                        @endif
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div>
                                            <strong>Invoice - #{{ $purchase->id }}</strong><br>
                                            {{ dateDmy($purchase->created_at) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Harga</th>
                                                    <th>Jumlah</th>
                                                    <th>Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($purchase_details as $detail)
                                                    <tr>
                                                        <td>{{ $detail->product->name }}</td>
                                                        <td>{{ formattedPrice($detail->product->price) }}</td>
                                                        <td>{{ $detail->amount }}</td>
                                                        <td>{{ formattedPrice($detail->subtotal) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="invoice-price mt-4">
                                <div class="invoice-price-left">
                                    <div class="invoice-price-row">
                                        <div class="sub-price">
                                            <small>POIN</small>
                                            <span class="text-inverse">{{ $purchase->point }}</span>
                                        </div>
                                        <div class="sub-price">
                                            <small>KASIR</small>
                                            <span class="text-inverse">{{ $purchase->user->name }}</span>
                                        </div>
                                        <div class="sub-price">
                                            <small>KEMBALIAN</small>
                                            <span class="text-inverse">{{ formattedPrice($purchase->total_return) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-price-right">
                                    <small>TOTAL</small>
                                    <span class="f-w-600">{{ formattedPrice($purchase->total_price) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
