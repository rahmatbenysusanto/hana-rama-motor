@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Detail Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Detail Barang
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="fw-bold">Nama Barang</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $barang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">SKU</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $barang->sku }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kategori</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $barang->kategori->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Stok</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $barang->inventory->stok }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Harga Umum</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">@currency($barang->harga_umum)</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Harga Sales</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">@currency($barang->harga_sales)</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
