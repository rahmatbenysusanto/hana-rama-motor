@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Barang Rusak</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Daftar Barang Rusak
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
                                <th>Supplier</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($barangRusak as $b)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $b->barang->nama_barang }}</td>
                                    <td>{{ $b->barang->sku }}</td>
                                    <td>{{ $b->stok }}</td>
                                    <td>{{ $b->supplier->nama }}</td>
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
