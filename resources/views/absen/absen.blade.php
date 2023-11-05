@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Absen</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Absen Karyawan Bulan {{ getBulan() }}
                    </div>
                </div>
                <div class="card-body">
                    <a class="btn btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#tambah_pegawai">Tambah Pegawai</a>
                    <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#buat_absen">Buat Absen</a>
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Jumlah Masuk</th>
                                <th>Jumlah Tidak masuk</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s['nama'] }}</td>
                                    <td>{{ $s['no_hp'] }}</td>
                                    <td>{{ $s['masuk'] }}</td>
                                    <td>{{ $s['tidak'] }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm" style="border-radius: 0.25rem" data-bs-toggle="dropdown" aria-expanded="false">
                                                Pilih
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="/lihat-absen/{{ $s['id'] }}">Lihat Absen</a></li>
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

    <div class="modal fade" id="buat_absen" tabindex="-1" aria-labelledby="exampleModalScrollable2" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('buat_absen') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel2">Buat Absen</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Karyawan</label>
                            <select class="form-control" name="pegawai_id" required>
                                <option>Pilih Karyawan</option>
                                @foreach($data as $s)
                                    <option value="{{ $s['id'] }}">{{ $s['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Absen</label>
                            <select class="form-control" name="jenis" required>
                                <option value="masuk">Masuk Kerja</option>
                                <option value="tidak masuk">Tidak Masuk</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan Absen</label>
                            <textarea class="form-control" name="keterangan"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Absen</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah Absen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambah_pegawai" tabindex="-1" aria-labelledby="exampleModalScrollable2" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('tambah_pegawai') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title" id="staticBackdropLabel2">Tambah Pegawai</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="number" class="form-control" name="no_hp">
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
