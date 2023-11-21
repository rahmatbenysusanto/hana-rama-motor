@extends('layout')
@section('konten')

    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Pengaturan Gudang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Daftar Pengaturan Gudang
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-check form-check-md form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch-md" onchange="sembunyikanBarang(1)" {{ $data[0]->status == 0 ? "" : "checked" }}>
                        <label class="form-check-label" for="switch-md">Tampilkan Barang</label>
                    </div><br>
                    <div class="form-check form-check-md form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch-md">
                        <label class="form-check-label" for="switch-md">Sembunyikan Menu Oli</label>
                    </div><br>
                    <div class="form-check form-check-md form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch-md">
                        <label class="form-check-label" for="switch-md">Sembunyikan Menu Ban</label>
                    </div><br>
                    <div class="form-check form-check-md form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="switch-md">
                        <label class="form-check-label" for="switch-md">Sembunyikan Menu Sparepart</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function sembunyikanBarang(id) {
            $.ajax({
               url: '{{ route('ubah_pengaturan') }}',
               method: 'GET',
                data: {
                   id: id
                },
                success: function (params) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Ubah Pengaturan Sembunyikan Barang berhasil',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                }
            });
        }
    </script>
@endsection
