@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Detail Penjualan Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Detail Penjualan Barang
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="fw-bold">No Invoice</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksi->no_invoice }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Pelanggan</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksi->pelanggan->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Sales</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksi->sales->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Pembayaran</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksi->pembayaran->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah Barang</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksi->jumlah_barang }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">QTY</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksi->qty }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Diskon</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksi->diskon }}%</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Nominal Diskon</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">@currency($transaksi->harga_diskon)</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total Harga</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">@currency($transaksi->total_harga)</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Penjualan</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ tanggal_format($transaksi->tanggal_penjualan) }}</td>
                        </tr>
                        @if($transaksi->pembayaran_id == 3)
                            <tr>
                                <td class="fw-bold">Tanggal Tempo</td>
                                <td class="fw-bold ps-2">:</td>
                                <td class="ps-2">{{ tanggal_format($transaksi->tanggal_tempo) }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Daftar Barang
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">SKU</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Diskon</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaksiDetail as $detail)
                                <tr>
                                    <td>{{ $detail->barang->nama_barang }}</td>
                                    <td>{{ $detail->barang->sku }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>@currency($detail->harga)</td>
                                    <td>{{ $detail->diskon_barang }}%</td>
                                    <td>@currency($detail->total_harga)</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
