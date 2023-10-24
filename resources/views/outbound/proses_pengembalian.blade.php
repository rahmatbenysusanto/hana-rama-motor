@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Proses Pengembalian Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Proses Pengembalian Barang
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="fw-bold">No Transaksi Khusus</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksiKhusus->no_transaksi_khusus }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Sales</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksiKhusus->sales->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah Barang</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksiKhusus->jumlah_barang }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">QTY</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $transaksiKhusus->qty }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Pengambilan</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ tanggal_format($transaksiKhusus->tanggal_pengambilan) }}</td>
                        </tr>
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
                        <form action="{{ route('proses_pengembalian_barang_post') }}" method="POST">
                            @csrf
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">QTY</th>
                                    <th scope="col">QTY Kembali</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transaksiKhususDetail as $detail)
                                    <input type="hidden" name="id[]" value="{{ $detail->id }}">
                                    <tr>
                                        <td>{{ $detail->barang->nama_barang }}</td>
                                        <td>{{ $detail->barang->sku }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>
                                            <input type="number" class="form-control form-check-sm" name="qty[]" required>
                                        </td>
                                        <td>
                                            QTY Kembali : {{ $detail->qty_kembali }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Proses</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
