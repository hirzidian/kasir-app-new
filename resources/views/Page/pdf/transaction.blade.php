<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .card {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 20px;
        }
        .card-header {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">Detail Transaksi</div>
            <p><b>Member Status:</b> {{ $transaction->customer ? 'Member' : 'NON-MEMBER' }}</p>
            <p><b>No. HP:</b> {{ $transaction->customer ? $transaction->customer->no_hp : '-' }}</p>
            <p><b>Bergabung Sejak:</b> {{ $transaction->customer ? dateDmy($transaction->created_at) : '-' }}</p>
            <p><b>Poin Member:</b> {{ $transaction->customer ? $transaction->customer->total_point : '-' }}</p>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Sub total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction_details as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ formattedPrice($item->product->price) }}</td>
                            <td>{{ formattedPrice($item->sub_total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-right"><b>Total Harga</b></td>
                        <td><b>{{ formattedPrice($transaction->total_price) }}</b></td>
                    </tr>
                    <tr>
                        <td colspan=""><b>Poin Digunakan</b></td>
                        <td class="text-right"><b>{{ formattedPrice($transaction->used_point ? $transaction->used_point : 0) }}</b></td>
                        <td class="text-right"><b>Harga Setelah Poin</b></td>
                        <td><b>{{ formattedPrice($transaction->total_price - $transaction->used_point) }}</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td class="text-right"><b>Total Kembalian</b></td>
                        <td><b>{{ formattedPrice($transaction->total_return) }}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>

</html>
