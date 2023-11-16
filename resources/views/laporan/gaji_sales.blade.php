@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Laporan Transaksi Sales {{ $sales->nama }}</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 pe-0">
                            <p class="mb-2">
                                <span class="fs-16">Target Penjualan</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($sales->target)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Target Penjualan Bulanan</span>
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
                                <span class="fs-16">Total Penjualan</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPenjualan)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Total Penjualan Bulan {{ getBulan() }}</span>
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
                                <span class="fs-16">Total Piutang</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($piutang)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Piutang Bulan {{ getBulan() }}</span>
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
                                <span class="fs-16">Jumlah Transaksi</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">{{ $jumlahTransaksi }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Transaksi Bulan {{ getBulan() }}</span>
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
                        List Gaji Sales {{ $sales->nama }}
                    </div>
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubahTanggal">Hitung Gaji Sales</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Gaji Pokok</th>
                                    <th>Uang Makan</th>
                                    <th>Uang Bensin</th>
                                    <th>Sewa Kendaraan</th>
                                    <th>Operasional</th>
                                    <th>Kas Bon</th>
                                    <th>Potongan</th>
                                    <th>Total Penjualan</th>
                                    <th>Bonus Penjualan</th>
                                    <th>Gaji Bersih</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rekapGaji as $gaji)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>@currency($gaji->gaji_pokok)</td>
                                        <td>@currency($gaji->uang_bensin)</td>
                                        <td>@currency($gaji->uang_makan)</td>
                                        <td>@currency($gaji->sewa_kendaraan)</td>
                                        <td>@currency($gaji->operasional)</td>
                                        <td>@currency($gaji->kas_bon)</td>
                                        <td>@currency($gaji->potongan)</td>
                                        <td>@currency($gaji->total_penjualan)</td>
                                        <td>@currency($gaji->bonus_penjualan)</td>
                                        <td>@currency($gaji->gaji_bersih)</td>
                                        <td>{{ $gaji->keterangan }}</td>
                                        <td>{{ tanggal_format($gaji->tanggal) }}</td>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form action="{{ route('laporan_sales_tanggal') }}" method="GET">
                    <div class="modal-body">
                        <input type="hidden" value="{{ $sales->id }}" name="sales_id">
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
                        <a href="/laporan-sales/{{ $sales->id }}" type="button" class="btn btn-secondary">Reset Tanggal</a>
                        <button type="submit" class="btn btn-primary">Cari Data Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
