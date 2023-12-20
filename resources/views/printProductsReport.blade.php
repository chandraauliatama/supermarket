<!DOCTYPE html>
<html>

<head>
    <title>Data Seluruh Produk</title>
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
    <h1>Data Seluruh Produk</h1>

    {{-- @foreach ($salesGroupedByDate as $transaction => $salesInTransaction) --}}
    {{-- <h2>Transaksi {{ $transaction }}</h2> --}}
    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Nama Barang</th>
                <th style="width: 10%;">Stok</th>
                <th style="width: 20%;">Harga Modal</th>
                <th style="width: 20%;">Harga Jual</th>
                <th style="width: 20%;">Barcode Produk</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>Rp. {{ $product->capital_price }}</td>
                    <td>Rp. {{ $product->sell_price }}</td>
                    <td>
                        <img src="data:image/png;base64, {!! base64_encode(
                            \QrCode::format('svg')->size(150)->errorCorrection('H')->generate($product->id),
                        ) !!}">
                    </td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @endforeach --}}
</body>

</html>
