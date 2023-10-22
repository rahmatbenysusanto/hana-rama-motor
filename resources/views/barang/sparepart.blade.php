@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Sparepart</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Daftar Sparepart
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
                                                    <li><a class="dropdown-item" href="javascript:void(0);">Lihat Detail</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);">Edit Barang</a></li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);">Hapus Barang</a></li>
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
