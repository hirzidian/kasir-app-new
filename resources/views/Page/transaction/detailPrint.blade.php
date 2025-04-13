@extends('template')

@section('title', 'Penjualan')
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card p-4">
                    <div class="card-body p-0">
                        <div class="invoice-container">
                            <div class="invoice-header">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="custom-actions-btns mb-5">
                                            <a href="{{ route('pdf.print', $transaction->id) }}" class="btn btn-primary">Unduh (.pdf)</a>
                                            <a href="{{ route('transactions.index') }}"
                                                class="btn btn-secondary">
                                                <i class="mdi mdi-arrow-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            <address>
                                                @if ($customer)
                                                    <b>{{ $customer->no_hp }}</b><br>
                                                    MEMBER SEJAK :
                                                    {{ dateDmy($customer->created_at) }}
                                                    <br>
                                                    MEMBER POIN : {{ $customer->total_point }}
                                                @endif
                                            </address>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            <div class="invoice-num">
                                                <div>Invoice - #{{ $transaction->id }}</div>
                                                <div>{{ dateDmy($transaction->created_at) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                            <div class="invoice-body">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table custom-table m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($transaction_details as $transaction_detail)
                                                        <tr class="service">
                                                            <td class="tableitem">
                                                                <p class="itemtext">{{ $transaction_detail->product->name }}
                                                                </p>
                                                            </td>
                                                            <td class="tableitem">
                                                                <p class="itemtext">
                                                                    {{ formattedPrice($transaction_detail->product->price) }}
                                                                </p>
                                                            </td>
                                                            <td class="tableitem">
                                                                <p class="itemtext">{{ $transaction_detail->quantity }}</p>
                                                            </td>
                                                            <td class="tableitem">
                                                                <p class="itemtext">
                                                                    {{ formattedPrice($transaction_detail->sub_total) }}
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                            <div class="invoice-price">
                                <div class="invoice-price-left">
                                    <div class="invoice-price-row">
                                        <div class="sub-price">
                                            <small>POIN DIGUNAKAN</small>
                                            <span class="text-inverse">{{ $transaction->used_point }}</span>
                                        </div>
                                        <div class="sub-price">
                                            <small>KASIR</small>
                                            <span class="text-inverse">{{ $transaction->user->name }}</span>
                                        </div>
                                        <div class="sub-price">
                                            <small>KEMBALIAN</small>
                                            <span class="text-inverse">{{ formattedPrice($transaction->total_return) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="invoice-price-right">
                                    <small>TOTAL</small>
                                    @if ($transaction->used_point != 0)
                                        <span class="font-20" style="text-decoration: line-through;">{{ formattedPrice($transaction->total_price) }}</span><br>
                                        <span class="f-w-600" style="text-decoration: none;">{{ formattedPrice($transaction->total_price - $transaction->used_point) }}</span>
                                    @else
                                        <span class="f-w-600" style="text-decoration: none;">{{ formattedPrice($transaction->total_price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
