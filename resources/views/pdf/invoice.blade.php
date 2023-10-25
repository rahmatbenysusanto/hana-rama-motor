<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            font-size: 18px;
            font-family: monospace;
        }

        body.continuous_form .sheet {
            width: 138mm;
            height: 218mm;
        }

        body.continuous_form.landscape .sheet {
            width: 218mm;
            height: 138mm;
        }

        p {
            margin-bottom: 5px;
        }

        .td-25{
            width: 25%;
        }
        .td-50{
            width: 50%;
        }
        .td-100{
            width: 100%;
        }

        @page  {
           margin: 10px;
        }

    </style>
</head>
<body class="continuous_form landscape">
    <div style="padding: 5px">
        <h2 class="text-center mt-4">INVOICE</h2>
        <table>
            <tbody>
                <tr>
                    <td style="width: 420px">
                        <p style="font-family:'LED Dot-Matrix';font-weight:normal;">HANA RAMA MOTOR (HRM)</p>
                        <p>Pundung Rejo RT 03/01 Jati</p>
                        <p>Jaten Karanganyar Jawa Tengah (57731)</p>
                        <p>Phone : 081917110590</p>
                    </td>
                    <td style="width: 200px; display: flex">
                        <h2></h2>
                    </td>
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Number</td>
                                    <td class="ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->no_invoice }}</td>
                                </tr>
                                <tr>
                                    <td>Inv Date</td>
                                    <td class="ps-2">:</td>
                                    <td class="ps-2">{{ tanggal_format($transaksi->tanggal_penjualan) }}</td>
                                </tr>
                                <tr>
                                    <td>Payment</td>
                                    <td class="ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->pembayaran->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Sales</td>
                                    <td class="ps-2">:</td>
                                    <td class="ps-2">{{ $transaksi->sales->nama }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="mt-3">
            <tbody>
                <tr>
                    <td class="d-flex">Customer   : </td>
                    <td class="ps-2">
                        <p>{{ $transaksi->pelanggan->nama }}</p>
                        <p>{{ $transaksi->pelanggan->no_hp }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="mt-3 table">
            <thead>
            <tr style="border-top: 1px dashed black;border-bottom: 1px dashed black;">
                <th style="width: 30px" class="text-center">NO</th>
                <th style="width: 330px">Nama Barang</th>
                <th style="width: 100px" class="text-center">Jumlah</th>
                <th style="width: 100px" class="text-center">Harga</th>
                <th style="width: 50px" class="text-center">Diskon</th>
                <th style="width: 120px" class="text-center">Total Harga</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr><div style="height: 10px"></div>
                @php
                    $total_harga = 0;
                    $diskon_barang = 0;
                @endphp
                @foreach($barang as $detail)
                    @php
                        $total_harga += $detail->total_harga;
                        $diskon_barang += $detail->total_diskon;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td class="text-center">{{ $detail->qty }}</td>
                        <td class="text-center">@currency($detail->harga)</td>
                        <td class="text-center">{{ $detail->diskon_barang }}%</td>
                        <td class="text-center">@currency($detail->total_harga)</td>
                    </tr><div style="height: 10px"></div>
                @endforeach
            </tbody>
        </table>
        <div style="border-top: 1px dashed black"></div>
        @if($transaksi->tanggal_tempo != null)
            <p class="mt-1">Tanggal Tempo : {{ tanggal_format($transaksi->tanggal_tempo) }}</p>
        @endif
        <table class="mb-5">
            <tr>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 320px" class="text-center">Tanda Terima</th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 150px">Total Harga</th>
                <th style="width: 180px" class="text-end">@currency($total_harga)</th>
            </tr>
            <tr>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 320px"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 180px"></th>
                <th style="width: 150px" class="text-end"></th>
            </tr>
            <tr>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 320px"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 180px">Diskon Transaksi</th>
                <th style="width: 150px" class="text-end">@currency($transaksi->harga_diskon)</th>
            </tr>
            <tr>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 320px"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 180px"><div style="border-top: 1px dashed black"></div></th>
                <th style="width: 150px" class="text-end"><div style="border-top: 1px dashed black"></div></th>
            </tr>
            <tr>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 320px"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 180px">Total Tagihan</th>
                <th style="width: 150px" class="text-end">@currency($transaksi->total_harga)</th>
            </tr>
            <tr>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 320px"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 180px"></th>
                <th style="width: 150px" class="text-end"></th>
            </tr>
            <tr>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 320px" class="text-center">( {{ $transaksi->pelanggan->nama }}  )</th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 100px" class="text-center"></th>
                <th style="width: 50px" class="text-center"></th>
                <th style="width: 180px"></th>
                <th style="width: 150px" class="text-end"></th>
            </tr>
        </table>
    </div>
</body>
</html>
