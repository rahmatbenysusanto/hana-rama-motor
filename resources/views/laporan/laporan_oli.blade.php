@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Laporan Transaksi Oli</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Total Penjualan</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPenjualan)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Total Penjualan</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Detail Pendapatan<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Total Pendapatan Bersih</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPendapatanBersih)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Total Penjualan Bersih</span>
                            </p>
                            <a href="{{ route('daftar_transaksi') }}" class="fs-12 mb-0 text-primary">Lihat Detail<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Total Penjualan DiBayar</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPenjualanKotor)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Total Penjualan DiBayar</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Detail Piutang<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Total Penjualan Tempo</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPenjualanTempo)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Total Penjualan Tempo</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Detail Piutang<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        List Penjualan Oli
                    </div>
                    <div class="d-flex">
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubahTanggal">Ubah Tanggal Laporan</a>
                        <a class="btn btn-secondary ms-3">Download Laporan</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Invoice</th>
                                <th>Nama Barang</th>
                                <th>SKU</th>
                                <th>Sales</th>
                                <th>Pelanggan</th>
                                <th>Total QTY</th>
                                <th>Total Harga</th>
                                <th>Tanggal Penjualan</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listTransaksi as $tra)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tra['no_invoice'] }}</td>
                                    <td>{{ $tra['nama_barang'] }}</td>
                                    <td>{{ $tra['sku'] }}</td>
                                    <td>{{ $tra['sales'] }}</td>
                                    <td>{{ $tra['pelanggan'] }}</td>
                                    <td>{{ $tra['qty'] }}</td>
                                    <td>@currency($tra['harga'])</td>
                                    <td>{{ tanggal_format($tra['tanggal']) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ubahTanggal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel1">Tanggal Laporan</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('laporanOliTanggal') }}" method="GET">
                    <div class="modal-body">
                        <input type="hidden" value="1" name="kategori_id">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" name="awal" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="akhir" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('laporanOli') }}" type="button" class="btn btn-secondary">Reset Tanggal</a>
                        <button type="submit" class="btn btn-primary">Cari Data Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
