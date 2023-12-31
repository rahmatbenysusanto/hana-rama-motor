@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Daftar List Return Penjualan Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Return Penjualan Barang
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Invoice</th>
                                <th>Sales</th>
                                <th>Pelanggan</th>
                                <th>Pembayaran</th>
                                <th>Jumlah Barang</th>
                                <th>Total QTY</th>
                                <th>Total Harga</th>
                                <th>Tanggal Penjualan</th>
                                <th>Tanggal Tempo</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaksi as $tra)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tra->no_invoice }}</td>
                                    <td>{{ $tra->sales->nama }}</td>
                                    <td>{{ $tra->pelanggan->nama }}</td>
                                    <td>{{ $tra->pembayaran->nama }}</td>
                                    <td>{{ $tra->jumlah_barang }}</td>
                                    <td>{{ $tra->qty }}</td>
                                    <td>@currency($tra->total_harga)</td>
                                    <td>{{ tanggal_format($tra->tanggal_penjualan) }}</td>
                                    <td>
                                        @if($tra->tanggal_tempo != null)
                                            {{ tanggal_format($tra->tanggal_tempo) }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/proses-return-transaksi/{{ $tra->id }}" class="btn btn-primary btn-sm">Return Penjualan</a>
                                    </td>
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
