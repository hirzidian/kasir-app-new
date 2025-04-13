@extends('template')

@section('title', 'Pembayaran')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('transactions.sale.detail.store',$transaction->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="table table-bordered">
                                <table>
                                    <tbody>
                                        <tr class="tabletitle">
                                            <th class="item">
                                                Nama Produk
                                            </th>
                                            <th class="item">
                                                Qty
                                            </th>
                                            <th class="item">
                                                Harga
                                            </th>
                                            <th class="item">
                                                Sub Total
                                            </th>
                                        </tr>
                                        @foreach ($transaction_details as $transaction_detail)
                                            <tr class="service">
                                                <td class="tableitem">
                                                    <p class="itemtext">{{ $transaction_detail->product['name'] }}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">{{ $transaction_detail->quantity }}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">{{formattedPrice($transaction_detail->product['price'])}}</p>
                                                </td>
                                                <td class="tableitem">
                                                    <p class="itemtext">{{ $transaction_detail->sub_total }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="tabletitle">
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <h4>Total Harga</h4>
                                            </td>
                                            <td>
                                                <h4>{{ formattedPrice($transaction->total_price) }}</h4>
                                            </td>
                                        </tr>
                                        <tr class="tabletitle">
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <h4>Total Bayar</h4>
                                            </td>
                                            <td>
                                                <h4>{{ formattedPrice($transaction->total_payment) }}</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                                <input type="hidden" name="sale_id" value="247">
                                <input type="hidden" name="customer_id" value="32">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Member (identitas)</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $transaction->customer->name ? $transaction->customer->name : ''}}" required=""
                                        value="">
                                </div>
                                <div class="form-group">
                                    <label for="poin" class="form-label">Poin</label>
                                    <input type="text" name="poin" id="poin" value="{{ $transaction->customer->total_point }}" disabled=""
                                        class="form-control">
                                </div>
                                <div class="form-check ms-4">
                                    <input class="form-check-input" type="checkbox" value="Ya" id="check2" {{ $isMany ? 'disabled=""': '' }}
                                        name="check_poin">
                                    <label class="form-check-label" style="font-size: 16px" for="check2">
                                        Gunakan poin
                                    </label>
                                    @if ($isMany)
                                        <small class="text-danger">Poin tidak dapat digunakan <br>pada pembelanjaan pertama.</small>
                                    @endif
                                </div>
                            </div>
                            <div class="row text-end">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" type="submit">Selanjutnya</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
