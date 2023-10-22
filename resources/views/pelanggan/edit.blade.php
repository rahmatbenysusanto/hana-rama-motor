@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Edit Pelanggan</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Data Pelanggan
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-6">
                        <form action="{{ route('edit_pelanggan') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $pelanggan->id }}">
                            <div class="mb-3">
                                <label class="form-label">Nama Supplier</label>
                                <input type="text" name="nama" class="form-control" value="{{ $pelanggan->nama }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="number" name="no_hp" class="form-control" value="{{ $pelanggan->no_hp }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" cols="30" rows="10">{{ $pelanggan->alamat }}</textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Edit Pelanggan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
