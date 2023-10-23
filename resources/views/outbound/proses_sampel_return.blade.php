@extends('layout')
@section('konten')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Proses Barang Sampel</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Detail Sampel
                    </div>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <td class="fw-bold">No Invoice</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $sampel->no_sampel }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Sales</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $sampel->sales->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah Barang</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $sampel->jumlah_barang }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">QTY</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ $sampel->qty }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal</td>
                            <td class="fw-bold ps-2">:</td>
                            <td class="ps-2">{{ tanggal_format($sampel->tanggal_sampel) }}</td>
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
                        <form action="{{ route('proses_return_sampel_post') }}" method="POST">
                            @csrf
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">QTY</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Total Harga</th>
                                    <th scope="col">Pilihan</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sampelDetail as $detail)
                                    <input type="hidden" name="sampel_detail_id[]" value="{{ $detail->id }}">
                                    <tr>
                                        <td>{{ $detail->barang->nama_barang }}</td>
                                        <td>{{ $detail->barang->sku }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>@currency($detail->harga)</td>
                                        <td>@currency($detail->total_harga)</td>
                                        <td>
                                            @if($detail->status == "2")
                                                <span class="badge bg-danger-transparent">Barang Rusak</span>
                                            @elseif($detail->status == "3")
                                                <span class="badge bg-success-transparent">Barang Sudah Kembali</span>
                                            @else
                                                <select class="form-control" name="status[]">
                                                    <option value="1">Belum Balik</option>
                                                    <option value="2">Barang Rusak</option>
                                                    <option value="3">Barang Kembali</option>
                                                </select>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Proses</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
