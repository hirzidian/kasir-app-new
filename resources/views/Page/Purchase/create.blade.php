@extends('template')

@section('title', 'Create Product')

@section('content')
<div class="row">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('purchases.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <h2>Produk yang dipilih</h2>
                        <table style="width: 100%;">
                            <tbody>
                                @foreach ($pembelians as $product)
                                    <input type="hidden" name="shop[]" value="{{ $product['id'].';'.$product['name'].';'.$product['price'].';'.$product['qty'].';'.$product['subtotal'] }}">
                                    <tr>
                                        <td>
                                            {{ $product['name'] }}<br>
                                            <small>{{ formattedPrice($product['price']) }} x {{ $product['qty'] }}</small>

                                            @if (!empty($product['is_double']))
                                                <br><small class="text-warning">⚠️ Produk ini dipesan lebih dari satu kali</small>
                                            @endif
                                        </td>
                                        <td><b>{{ formattedPrice($product['subtotal']) }}</b></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="padding-top: 20px; font-size: 20px;"><b>Total</b></td>
                                    <td class="text-end" style="padding-top: 20px; font-size: 20px;"><b>{{ formattedPrice($total) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="total_price" id="total" value="{{ $total }}">
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="row">
                            <div class="form-group">
                                <label for="member" class="form-label">Member Status</label>
                                <small class="text-danger">Dapat juga membuat member</small>
                                <select name="member" id="member" class="form-select" onchange="memberDetect()">
                                    <option value="Bukan Member">Bukan Member</option>
                                    <option value="Member">Member</option>
                                </select>
                            </div>
                        </div>

                        <div id="member-wrap" class="d-none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-12">No Telepon
                                            <small class="text-danger">(daftar/gunakan member)</small></label>
                                        <div class="col-md-12">
                                            <input type="number" name="no_hp" class="form-control"
                                                onkeypress="if(this.value.length==13) return false;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group">
                                <label for="total_pay" class="form-label">Total Bayar</label>
                                <input type="number`" name="total_pay" id="total_pay" class="form-control"
                                    oninput="checkTotalPay()" required>
                                <small id="error-message" class="text-danger d-none">Jumlah bayar belum mencukupi.</small>
                            </div>
                        </div>

                        <div class="row text-end">
                            <div class="col-md-12">
                                <button class="btn btn-primary" id="submit-button" type="submit" disabled>Pesan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function checkTotalPay() {
        const total = parseInt(document.getElementById('total').value);
        const bayarInput = document.getElementById('total_pay');
        const bayar = convertToNumber(bayarInput.value);
        const errorMsg = document.getElementById('error-message');
        const submitBtn = document.getElementById('submit-button');

        if (isNaN(bayar) || bayar < total) {
            errorMsg.classList.remove('d-none');
            submitBtn.disabled = true;
        } else {
            errorMsg.classList.add('d-none');
            submitBtn.disabled = false;
        }
    }

    function convertToNumber(rp) {
        // Hilangkan semua karakter selain angka
        return parseInt(rp.replace(/[^\d]/g, '')) || 0;
    }

    function memberDetect() {
        const memberStatus = document.getElementById('member').value;
        const wrap = document.getElementById('member-wrap');
        if (memberStatus === 'Member') {
            wrap.classList.remove('d-none');
        } else {
            wrap.classList.add('d-none');
        }
    }
</script>
@endsection
