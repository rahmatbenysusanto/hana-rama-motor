@extends('layout');
@section('konten')
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Dashboard Oli</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard Oli</li>
                </ol>
            </nav>
        </div>
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
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0" id="totalPenjualan"></span>
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
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0" id="pendapatanBersih"></span>
                                <span class="d-block fs-10 fw-semibold text-muted">Pendapatan Bulan {{ getBulan() }}</span>
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
                                <span class="fs-16">Total Pendapatan Kotor</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0" id="pendapatanKotor"></span>
                                <span class="d-block fs-10 fw-semibold text-muted">Pendapatan Bulan {{ getBulan() }}</span>
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
                                <span class="fs-16">Total Piutang</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0" id="totalPiutang"></span>
                                <span class="d-block fs-10 fw-semibold text-muted">Piutang Bulan {{ getBulan() }}</span>
                            </p>
                            <a href="javascript:void(0);" class="fs-12 mb-0 text-primary">Lihat Detail Piutang<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3 col-xl-12">
            <div class="card custom-card recent-transactions-card overflow-hidden">
                <div class="card-header justify-content-between">
                    <div class="card-title">Stok Barang Akan Habis </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group">
                        @foreach($stokMinimal as $m)
                            <a href="javascript:void(0);" class="border-0">
                                <div class="list-group-item border-0">
                                    <div class="d-flex align-items-start">
                                        @if($m->kategori_id == 1)
                                            <span class="tansaction-icon bg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-white" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/><path d="M18,6h-2c0-2.21-1.79-4-4-4S8,3.79,8,6H6C4.9,6,4,6.9,4,8v12c0,1.1,0.9,2,2,2h12c1.1,0,2-0.9,2-2V8C20,6.9,19.1,6,18,6z M12,4c1.1,0,2,0.9,2,2h-4C10,4.9,10.9,4,12,4z M18,20H6V8h2v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8h4v2c0,0.55,0.45,1,1,1s1-0.45,1-1V8 h2V20z"/></g></svg>
                                            </span>
                                        @elseif($m->kategori_id == 2)
                                            <span class="tansaction-icon bg-info">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-white" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><g><rect fill="none" height="24" width="24"/></g><g><g><path d="M20,2H4C3,2,2,2.9,2,4v3.01C2,7.73,2.43,8.35,3,8.7V20c0,1.1,1.1,2,2,2h14c0.9,0,2-0.9,2-2V8.7c0.57-0.35,1-0.97,1-1.69V4 C22,2.9,21,2,20,2z M19,20H5V9h14V20z M20,7H4V4h16V7z"/><rect height="2" width="6" x="9" y="12"/></g></g></svg>
                                            </span>
                                        @else
                                            <span class="tansaction-icon bg-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="svg-white" height="24px" viewBox="0 0 24 24" width="24px" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2zm-1.45-5c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6z"/></svg>
                                            </span>
                                        @endif
                                        <div class="w-100">
                                            <div class="d-flex align-items-top justify-content-between">
                                                <div class="mt-0">
                                                    <p class="mb-0 fw-semibold"><span class="me-3">{{ $m->nama_barang }}</span></p>
                                                    <span class="mb-0 fs-12 text-muted">SKU {{ $m->sku }}</span>
                                                </div>
                                                <div class="text-muted fs-12 text-center"></div>
                                                <span class="ms-auto">
                                                <span class="text-end fw-semibold d-block">
                                                    {{ $m->stok }} Pcs
                                                </span>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="col-lg-6 col-sm-12 col-md-6 col-xxl-6 col-xl-8">--}}
{{--            <div class="row">--}}
{{--                <div class="col-6">--}}
{{--                    <div class="card custom-card">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-12 pe-0">--}}
{{--                                    <p class="mb-2">--}}
{{--                                        <span class="fs-16">Jumlah Pembelian Barang</span>--}}
{{--                                    </p>--}}
{{--                                    <p class="mb-2 fs-12">--}}
{{--                                        <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">{{ number_format($jumlahPembelian) }} Pcs</span>--}}
{{--                                        <span class="d-block fs-10 fw-semibold text-muted">Jumlah Pembelian Bulan {{ getBulan() }}</span>--}}
{{--                                    </p>--}}
{{--                                    <a href="{{ route('daftar_transaksi') }}" class="fs-12 mb-0 text-primary">Lihat Detail<i class="ti ti-chevron-right ms-1"></i></a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-6">--}}
{{--                    <div class="card custom-card">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-12 pe-0">--}}
{{--                                    <p class="mb-2">--}}
{{--                                        <span class="fs-16">Total Pembelian Barang</span>--}}
{{--                                    </p>--}}
{{--                                    <p class="mb-2 fs-12">--}}
{{--                                        <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">@currency($totalPembelian)</span>--}}
{{--                                        <span class="d-block fs-10 fw-semibold text-muted">Jumlah Pembelian Bulan {{ getBulan() }}</span>--}}
{{--                                    </p>--}}
{{--                                    <a href="{{ route('daftar_transaksi') }}" class="fs-12 mb-0 text-primary">Lihat Detail<i class="ti ti-chevron-right ms-1"></i></a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card custom-card">--}}
{{--                <div class="card-header">--}}
{{--                    <div class="card-title">--}}
{{--                        Penjualan Tahun {{ date('Y', time()) }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div id="chartPenjualan"></div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-6 col-sm-12 col-md-6 col-xxl-3 col-xl-4">--}}
{{--            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">--}}
{{--                <div class="card custom-card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-12 pe-0">--}}
{{--                                <p class="mb-2">--}}
{{--                                    <span class="fs-16">Jumlah Penjualan</span>--}}
{{--                                </p>--}}
{{--                                <p class="mb-2 fs-12">--}}
{{--                                    <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">{{ $jumlahPenjualan }}</span>--}}
{{--                                    <span class="d-block fs-10 fw-semibold text-muted">Jumlah Penjualan Bulan {{ getBulan() }}</span>--}}
{{--                                </p>--}}
{{--                                <a href="{{ route('daftar_transaksi') }}" class="fs-12 mb-0 text-primary">Lihat Detail<i class="ti ti-chevron-right ms-1"></i></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">--}}
{{--                <div class="card custom-card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-12 pe-0">--}}
{{--                                <p class="mb-2">--}}
{{--                                    <span class="fs-16">Jumlah Pembayaran Tempo</span>--}}
{{--                                </p>--}}
{{--                                <p class="mb-2 fs-12">--}}
{{--                                    <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">{{ $totalTempo }}</span>--}}
{{--                                    <span class="d-block fs-10 fw-semibold text-muted">Jumlah Penjualan Bulan {{ getBulan() }}</span>--}}
{{--                                </p>--}}
{{--                                <a href="{{ route('daftar_transaksi') }}" class="fs-12 mb-0 text-primary">Lihat Detail<i class="ti ti-chevron-right ms-1"></i></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">--}}
{{--                <div class="card custom-card">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-12 pe-0">--}}
{{--                                <p class="mb-2">--}}
{{--                                    <span class="fs-16">Pembayaran Belum Lunas</span>--}}
{{--                                </p>--}}
{{--                                <p class="mb-2 fs-12">--}}
{{--                                    <span class="fs-25 fw-semibold lh-1 vertical-bottom mb-0">{{ $totalBelumDiBayar }}</span>--}}
{{--                                    <span class="d-block fs-10 fw-semibold text-muted">Jumlah Penjualan Bulan {{ getBulan() }}</span>--}}
{{--                                </p>--}}
{{--                                <a href="{{ route('daftar_transaksi') }}" class="fs-12 mb-0 text-primary">Lihat Detail<i class="ti ti-chevron-right ms-1"></i></a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection

@section('js')
    <script>
        const rupiah = (number)=>{
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }

        $.ajax({
           url: '{{ route('getDataOli') }}',
           method: 'GET',
           success: function (res) {
                document.getElementById('totalPenjualan').innerText = rupiah(res.total_penjualan);
               document.getElementById('pendapatanBersih').innerText = rupiah(res.penjualan_bersih);
               document.getElementById('pendapatanKotor').innerText = rupiah(res.penjualan_kotor);
               document.getElementById('totalPiutang').innerText = rupiah(res.penjualan_tempo);
           }
        });
    </script>
@endsection
