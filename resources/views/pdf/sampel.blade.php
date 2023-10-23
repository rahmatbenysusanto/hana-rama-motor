<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Sampel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <h3 class="text-center">NOTA BARANG SAMPEL</h3><br>
    <table>
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
                    <p style="margin-bottom: 0">No Sampel : {{ $sampel->no_sampel }}</p>
                    <p style="margin-bottom: 0">Jumlah Barang : {{ $sampel->jumlah_barang }}</p>
                    <p style="margin-bottom: 0">Jumlah QTY : {{ $sampel->qty }}</p>
                    <p>Tanggal : {{ tanggal_format($sampel->tanggal_sampel) }}</p>
                </td>
            </tr>
        </tbody>
    </table>

    <br>
    <p style="margin-bottom: 0">Sales : {{ $sampel->sales->nama }}</p>
    <p style="margin-bottom: 0">No Hp : {{ $sampel->sales->no_hp }}</p>
    <br>

    <h6>DAFTAR BARANG</h6>
    <table>
        <thead>
            <tr style="border-top: 1px solid black; border-bottom: 1px solid black">
                <th style="width: 30px" class="text-center">#</th>
                <th style="width: 400px">Nama Barang</th>
                <th style="width: 150px">SKU</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sampelDetail as $detail)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $detail->barang->nama_barang }}</td>
                    <td>{{ $detail->barang->sku }}</td>
                    <td class="text-center">{{ $detail->qty }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="border-top: 1px solid black; width: 640px"></div>

    <table class="mt-3">
        <thead>
            <tr>
                <th width="400px"></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding-left: 17px">Hormat Kami</td>
                <td class="text-center">Tanda Terima</td>
            </tr>
        </tbody>
    </table>
    <br><br>
    <table class="mt-5">
        <thead>
        <tr>
            <th width="400px"></th>
            <th class="text-center"></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>( Admin Gudang )</td>
            <td class="text-center">( {{ $sampel->sales->nama }} )</td>
        </tr>
        </tbody>
    </table>
</body>
</html>
