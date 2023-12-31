@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Ban</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        List Daftar Ban
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="/download-list-barang/ban" target="_blank" class="btn btn-primary btn-sm">Download List Barang</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>SKU</th>
                                <th>Stok</th>
                                <th>Harga Umum</th>
                                <th>Harga Sales</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($barang as $b)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $b->nama_barang }}</td>
                                        <td>{{ $b->sku }}</td>
                                        <td>{{ $b->inventory->stok }}</td>
                                        <td>@currency($b->harga_umum)</td>
                                        <td>@currency($b->harga_sales)</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm" style="border-radius: 0.25rem" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Pilih
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="/detail-barang/{{ $b->id }}">Lihat Detail</a></li>
                                                    <li><a class="dropdown-item" href="/edit-barang/{{ $b->id }}">Edit Barang</a></li>
                                                    <li><a class="dropdown-item" href="/hapus-barang/{{ $b->id }}">Hapus Barang</a></li>
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
