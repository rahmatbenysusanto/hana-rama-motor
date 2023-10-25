@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Edit Pembelian Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Edit Pembelian Barang
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="fw-bold">PO Number</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $inbound->po_number }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">No Invoice</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $inbound->no_invoice }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Supplier</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $inbound->supplier->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah Barang</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $inbound->jumlah_barang }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">QTY Barang</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $inbound->qty_barang }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Datang</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ tanggal_format($inbound->tanggal_datang) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Diskon Pembelian</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $inbound->diskon_pembelian }}%</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">PPN</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $inbound->ppn }}%</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total Harga</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">@currency($inbound->total_harga)</td>
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
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">SKU</th>
                                <th scope="col">QTY</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Diskon</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inbound->inboundDetail as $detail)
                                <tr>
                                    <td>{{ $detail->barang->nama_barang }}</td>
                                    <td>{{ $detail->barang->sku }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>@currency($detail->harga)</td>
                                    <td>{{ $detail->diskon }}%</td>
                                    <td>@currency($detail->total_harga)</td>
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
