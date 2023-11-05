@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Lihat Absen</h1>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Absen
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($absen as $a)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($a->absen == "masuk")
                                                <span class="badge bg-success-transparent">Masuk</span>
                                            @else
                                                <span class="badge bg-danger-transparent">Tidak Masuk</span>
                                            @endif
                                        </td>
                                        <td>{{ tanggal_format($a->tanggal_absen) }}</td>
                                        <td>{{ $a->keterangan }}</td>
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
