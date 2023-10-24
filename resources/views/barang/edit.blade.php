@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Edit Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Edit Barang
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('edit_barang_post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="nama_barang" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ $barang->nama_barang }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="sku" class="form-label">SKU / Barcode</label>
                                <input type="text" class="form-control" id="sku" name="sku" value="{{ $barang->sku }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori Barang</label>
                                <select class="form-select" aria-label="Pilih Kategori Barang" name="kategori" required>
                                    <option selected value="{{ $barang->kategori->id }}">{{ $barang->kategori->nama }}</option>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Umum</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Rp. </span>
                                    <input type="number" class="form-control" placeholder="Harga Umum" name="harga_umum" value="{{ $barang->harga_umum }}" aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga Sales</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Rp. </span>
                                    <input type="number" class="form-control" placeholder="Harga Sales" name="harga_sales" value="{{ $barang->harga_sales }}" aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Edit Barang</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

