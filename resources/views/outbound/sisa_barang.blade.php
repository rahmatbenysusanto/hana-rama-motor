@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Daftar List Pengambilan Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Pengambilan Barang
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Transaksi Khusus</th>
                                <th>Sales</th>
                                <th>Jumlah Barang</th>
                                <th>Total QTY</th>
                                <th>Tanggal Pengambilan</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksiKhusus as $detail)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $detail->no_transaksi_khusus }}</td>
                                        <td>{{ $detail->sales->nama }}</td>
                                        <td>{{ $detail->jumlah_barang }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>{{ tanggal_format($detail->tanggal_pengambilan) }}</td>
                                        <td>
                                            <a href="/proses-pengembalian-barang/{{ $detail->id }}" class="btn btn-primary btn-sm">Pengembalian Barang</a>
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
