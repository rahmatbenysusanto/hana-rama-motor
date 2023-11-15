@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Sales</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Daftar Sales
                    </div>
                </div>
                <div class="card-body">
                    <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambah_supplier">Tambah Sales</a>
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Type</th>
                                <td>Nominal</td>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sales as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->nama }}</td>
                                    <td>{{ $s->no_hp }}</td>
                                    <td>{{ $s->type }}</td>
                                    <td>
                                        @if($s->nominal != null)
                                            {{ $s->nominal }} %
                                        @endif
                                    </td>
                                    <td>@currency($s->target)</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" style="border-radius: 0.25rem" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilih
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="javascript:void(0);">Lihat Detail</a></li>
                                                <li><a class="dropdown-item" href="/edit-sales/{{ $s->id }}">Edit Sales</a></li>
                                                <li><a class="dropdown-item" href="/hapus-sales/{{ $s->id }}">Hapus Sales</a></li>
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

    <div class="modal fade" id="tambah_supplier" tabindex="-1" aria-labelledby="exampleModalScrollable2" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('tambah_sales') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel2">Tambah Sales</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Sales</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="number" name="no_hp" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-control" name="type">
                                <option value="bagi hasil">Bagi Hasil</option>
                                <option value="persen jual">Persen Jual</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nominal</label>
                            <input type="number" name="nominal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Penjualan</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp. </span>
                                <input type="number" class="form-control" placeholder="Target Penjualan" name="target">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gaji Pokok</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp. </span>
                                <input type="number" class="form-control" placeholder="Target Penjualan" name="gaji">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Uang Bensin</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp. </span>
                                <input type="number" class="form-control" placeholder="Target Penjualan" name="uang_bensin">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Uang Makan</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp. </span>
                                <input type="number" class="form-control" placeholder="Target Penjualan" name="uang_makan">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Uang Kendaraan</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp. </span>
                                <input type="number" class="form-control" placeholder="Target Penjualan" name="sewa_kendaraan">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
