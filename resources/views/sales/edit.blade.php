@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Edit Sales</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Data Sales
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-6">
                        <form action="{{ route('edit_sales') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $sales->id }}">
                            <div class="mb-3">
                                <label class="form-label">Nama Sales</label>
                                <input type="text" name="nama" class="form-control" value="{{ $sales->nama }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="number" name="no_hp" class="form-control" value="{{ $sales->no_hp }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-control" name="type">
                                    <option value="{{ $sales->type }}" selected>{{ $sales->type }}</option>
                                    <option value="bagi hasil">Bagi Hasil</option>
                                    <option value="persen jual">Persen Jual</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nonimal</label>
                                <input type="number" name="nominal" class="form-control" value="{{ $sales->nominal }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Target Penjualan</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Rp. </span>
                                    <input type="number" class="form-control" placeholder="Target Penjualan" value="{{ $sales->target }}" name="target">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Edit Sales</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
