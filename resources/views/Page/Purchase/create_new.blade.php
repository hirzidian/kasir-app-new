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
                                <thead>

                                </thead>
                                <tbody>
                                    @foreach ($pembelians as $product)
                                        <input type="hidden" name="shop[]" value="{{ $product['id'].';'.$product['name'].';'.$product['price'].';'.$product['product_total'].';'.$product['sub_total']}}" hidden="">
                                        <tr>
                                            <td>{{ $product['name'] }}<br> <small>{{ formattedPrice($product['price'])}} X
                                                    {{ $product['product_total'] }}</small></td>
                                            <td><b>{{ formattedPrice($product['sub_total']) }}</b>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td style="padding-top: 20px; font-size: 20px;"><b>Total</b></td>
                                            <td class="tex-end" style="padding-top: 20px; font-size: 20px;"><b>{{formattedPrice($total_price)}}</b></td>
                                        </tr>
                                </tbody>
                            </table>
                            <input type="text" name="total_price" id="total" value="{{ $total_price }}" hidden>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <label for="member" class="form-label">Member Status</label>
                                    <small class="text-danger">Dapat juga membuat member</small>
                                    <select name="member" id="member" class="form-select" onchange="memberDetect()">
                                        <option value="Bukan Member">Bukan Member</option>
                                        <option value="Member">
                                            Member</option>
                                    </select>
                                </div>
                            </div>

                            <div id="member-wrap" class="d-none">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">No Telepon <small class="text-danger">(daftar/gunakan
                                                    member)</small></label>
                                            <div class="col-md-12">
                                                <input type="number" name="no_hp" class="form-control form-control-line "
                                                    onkeypress="if(this.value.length==13) return false;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="total_pay" class="form-label">Total Bayar</label>
                                    <input type="text" name="total_payment" id="total_pay" class="form-control"
                                        oninput="formatRupiah(this);checkTotalPay();" required>
                                    <small id="error-message" class="text-danger d-none">Jumlah bayar
                                        kurang.</small>
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
            const total = {!! json_encode($total_price) !!};
            const totalPay = document.getElementById('total_pay').value;
            const errorMessage = document.getElementById('error-message');
            const buttonSubmit = document.getElementById('submit-button');
            const pay = convertToNumber(totalPay);

            if (pay < total) {
                errorMessage.classList.remove('d-none');
                buttonSubmit.disabled = true;
            } else {
                errorMessage.classList.add('d-none');
                buttonSubmit.disabled = false;
            }
        }

        function memberDetect() {
            const memberStatus = document.getElementById('member').value;
            if (memberStatus == 'Member') {
                document.getElementById('member-wrap').classList.remove('d-none');
            } else {
                document.getElementById('member-wrap').classList.add('d-none');
            }
        }
    </script>
@endsection
