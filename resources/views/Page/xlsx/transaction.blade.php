<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Pelanggan</th>
            <th>No HP Pelanggan</th>
            <th>Poin Pelanggan</th>
            <th>Produk</th>
            <th>Total Harga</th>
            <th>Total Bayar</th>
            <th>Total Diskon</th>
            <th>Total Kembalian</th>
            <th>Tanggal Pembelian</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transactions as $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                @if ($transaction->customer)
                    <td>{{ $transaction->customer->name }}</td>
                    <td>{{ $transaction->customer->no_hp }}</td>
                    <td>{{ $transaction->customer->total_point }}</td>
                @else
                    <td>NON-MEMBER</td>
                    <td>-</td>
                    <td>-</td>
                @endif
                <td>
                    @foreach ($transaction->transaction_details as $transaction_detail)
                        {{ $transaction_detail->product->name . ' ( '. $transaction_detail->quantity  . ' : ' . formattedPrice($transaction_detail->sub_total) . ' )' }}<br>
                    @endforeach
                </td>
                <td>{{ formattedPrice($transaction->total_price) }}</td>
                <td>{{ formattedPrice($transaction->total_payment) }}</td>
                <td>{{ formattedPrice($transaction->used_point) ? formattedPrice($transaction->used_point) : formattedPrice(0) }}</td>
                <td>{{ formattedPrice($transaction->total_return) ? formattedPrice($transaction->total_return) : formattedPrice(0) }}</td>
                <td>{{ dateDmy($transaction->created_at) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
