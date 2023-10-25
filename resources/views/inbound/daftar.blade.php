@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Daftar List Pembelian Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Pembelian Barang
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>PO Number</th>
                                <th>No Invoice</th>
                                <th>Supplier</th>
                                <th>Type</th>
                                <th>Jumlah Barang</th>
                                <th>QTY Barang</th>
                                <th>Tanggal Datang</th>
                                <th>Diskon Pembelian</th>
                                <th>PPN</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($inbound as $in)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $in->po_number }}</td>
                                        <td>{{ $in->no_invoice }}</td>
                                        <td>{{ $in->supplier->nama }}</td>
                                        <td class="text-center">
                                            @if($in->type == "pembelian")
                                                <span class="badge bg-success-transparent">Pembelian</span>
                                            @else
                                                <span class="badge bg-danger-transparent">Return</span>
                                            @endif
                                        </td>
                                        <td>{{ $in->jumlah_barang }}</td>
                                        <td>{{ $in->qty_barang }}</td>
                                        <td>{{ tanggal_format($in->tanggal_datang) }}</td>
                                        <td>{{ $in->diskon_pembelian }}%</td>
                                        <td>{{ $in->ppn }}%</td>
                                        <td>@currency($in->total_harga)</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm" style="border-radius: 0.25rem" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Pilih
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="/detail-pembelian/{{ $in->id }}">Lihat Detail</a></li>
                                                    <li><a class="dropdown-item" href="/edit-pembelian/{{ $in->id }}">Edit</a></li>
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
