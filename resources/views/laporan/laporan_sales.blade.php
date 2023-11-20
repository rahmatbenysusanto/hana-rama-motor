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
                                <span class="fs-16">Total Pendapatan Bersih</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPendapatanBersih)</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Pendapatan Bersih Bulan {{ getBulan() }}</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Pendapatan Bersih<i class="ti ti-chevron-right ms-1"></i></a>
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
                        List Penjualan Barang ( {{ $waktu }} )
                    </div>
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ubahTanggal">Ubah Tanggal Laporan</a>
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
                                <th>Cicilan</th>
                                <th>Status</th>
                                <th>Status Pembayaran</th>
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
                                    <td>@currency($tra->cicilan)</td>
                                    <td>
                                        @if($tra->status == "penjualan")
                                            <span class="badge bg-success-transparent">Normal</span>
                                        @else
                                            <span class="badge bg-danger-transparent">Return</span>
                                        @endif

                                        @if($tra->tanggal_tempo != null)
                                            <span class="badge bg-danger-transparent">Tempo</span>
                                        @endif

                                        @if($tra->cicilan != null)
                                            <br><span class="badge bg-warning-transparent mt-1">Cicilan</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($tra->status_pembayaran == "Lunas")
                                            <span class="badge bg-success-transparent">Lunas</span>
                                        @elseif($tra->cicilan != null)
                                            <span class="badge bg-warning-transparent">Cicilan</span>
                                        @else
                                            <span class="badge bg-danger-transparent">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td>{{ tanggal_format($tra->tanggal_penjualan) }}</td>
                                    <td>
                                        @if($tra->tanggal_tempo != null)
                                            {{ tanggal_format($tra->tanggal_tempo) }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" style="border-radius: 0.25rem" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilih
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/detail-transaksi/{{ $tra->id }}">Lihat Detail</a></li>
                                            </ul>
                                        </div>
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
