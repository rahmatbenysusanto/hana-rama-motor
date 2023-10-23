@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Daftar List Sampel</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Sampel
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Sampel</th>
                                <th>Sales</th>
                                <th>Jumlah Barang</th>
                                <th>Total QTY</th>
                                <th>Total Harga</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($sampel as $sam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sam->no_sampel }}</td>
                                        <td>{{ $sam->sales->nama }}</td>
                                        <td>{{ $sam->jumlah_barang }}</td>
                                        <td>{{ $sam->qty }}</td>
                                        <td>@currency($sam->total_harga)</td>
                                        <td>{{ tanggal_format($sam->tanggal_sampel) }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm" style="border-radius: 0.25rem" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Pilih
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="/detail-sampel/{{ $sam->id }}">Lihat Detail</a></li>
                                                    <li><a class="dropdown-item" target="_blank" href="/cetak-nota-sampel/{{ $sam->id }}">Cetak Nota</a></li>
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

@endsection
