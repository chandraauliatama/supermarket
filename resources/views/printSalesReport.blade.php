<!DOCTYPE html>
<html>

<head>
    <title>Data Seluruh Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Data Seluruh Penjualan</h1>

    @foreach ($salesGroupedByDate as $transaction => $salesInTransaction)
        <h2>Transaksi {{ $transaction }}</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 30%;">Nama Barang</th>
                    <th style="width: 10%;">Quantity</th>
                    <th style="width: 30%;">Harga Satuan</th>
                    <th style="width: 30%;">Total</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($salesInTransaction as $sale)
                    <tr>
                        <td>{{ $sale->name }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>Rp. {{ $sale->sell_price }}</td>
                        <td>Rp. {{ $sale->sell_price * $sale->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
