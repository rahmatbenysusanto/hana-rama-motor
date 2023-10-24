<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <h2 class="text-center">LIST DAFTAR {{ $title }}</h2>
    <table class="mt-5">
        <thead>
        <tr>
            <th style="width: 400px"></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <h4 style="margin-bottom: 0">HANA RAMA MOTOR (HRM)</h4>
                <p style="margin-bottom: 0">Pundung Rejo RT 003/001</p>
                <p style="margin-bottom: 0">Jati Jaten Karanganyar Jawa Tengah ( 57731 )</p>
            </td>
            <td>
                <p>Tanggal : {{ date('d M Y', time()) }}</p>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="mt-5">
        <thead>
            <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <th style="width: 25px" class="text-center">#</th>
                <th style="width: 300px">Nama Barang</th>
                <th style="width: 100px">SKU</th>
                <th style="width: 50px" class="text-center">Stok</th>
                <th style="width: 110px">Harga Umum</th>
                <th style="width: 110px">Harga Sales</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_stok = 0;
            @endphp
            @foreach($barang as $b)
                <tr style="border-bottom: 1px solid rgb(0,0,0, 0.5)">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->sku }}</td>
                    <td class="text-center">{{ $b->inventory->stok }}</td>
                    <td>@currency($b->harga_umum)</td>
                    <td>@currency($b->harga_sales)</td>
                </tr>
                @php
                    $total_stok += $b->inventory->stok;
                @endphp
            @endforeach
        </tbody>
    </table>
    <h6 class="mt-3">Total Stok = {{ $total_stok }}</h6>
</body>
</html>
