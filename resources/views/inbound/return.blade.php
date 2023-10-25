@extends('layout')
@section('konten')
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Buat Barang Return
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Supplier</label>
                                    <select class="form-control" id="supplier">
                                        <option value="0">Pilih Supplier</option>
                                        @foreach($supplier as $s)
                                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Return</label>
                                    <input type="date" class="form-control" id="tanggal_return" name="tanggal_return">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title">
                        Daftar Barang
                    </div>
                    <div>
                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarang">Tambah Barang</a>
                        <a class="btn btn-secondary ms-3" onclick="prosesPembelianBarang()">Proses Barang Return</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table text-nowrap table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>SKU</th>
                                        <th>QTY</th>
                                        <th>Pilihan</th>
                                    </tr>
                                    </thead>
                                    <tbody id="listBarang"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahBarang" tabindex="-1" aria-labelledby="exampleModalScrollable2" data-bs-keyboard="false" aria-hidden="true">
        <!-- Scrollable modal -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="staticBackdropLabel2">Tambah Barang</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">List Barang</label>
                        <select class="form-control" id="barang">
                            <option value="0">Pilih Barang</option>
                            @foreach($barang as $b)
                                <option value="{{ $b->barang_id }}">{{ $b->barang->kategori->nama }} | {{ $b->barang->sku }} | {{ $b->barang->nama_barang }} | {{ $b->stok }} Pcs</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">QTY</label>
                        <input type="number" class="form-control" id="qty" placeholder="Masukan QTY">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="tambahBarang()">Tambah Barang</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $('#barang').select2({
            dropdownParent: $('#tambahBarang'),
        });

        $('#supplier').select2();

        function tambahBarang() {
            let barang = document.getElementById('barang').value;
            let qty = document.getElementById('qty').value;

            let check = 0;
            if (barang === "") {
                check = check + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Barang tidak boleh kosong!',
                });
            }

            if (qty === "") {
                check = check + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'QTY tidak boleh kosong!',
                });
            }

            if (check === 0) {
                $.ajax({
                    url: "{{ route('findBarangRusak') }}",
                    method: "GET",
                    data: {
                        barang_id: barang
                    },
                    success: function (params) {
                        console.log(params)
                        let dataBarang = JSON.parse(localStorage.getItem('barangPembelianReturn')) ?? [];
                        dataBarang.push({
                            'id'        : params.barang.id,
                            'nama'      : params.barang.nama_barang,
                            'sku'       : params.barang.sku,
                            'qty'       : qty,
                        });
                        localStorage.setItem('barangPembelianReturn', JSON.stringify(dataBarang));
                        viewListBarang();
                        document.getElementById('qty').value = "";
                        $("#tambahBarang").modal("hide");
                    }
                });
            }
        }

        function viewListBarang() {
            let barang = JSON.parse(localStorage.getItem('barangPembelianReturn')) ?? [];

            let html = '';
            barang.forEach(function (params) {
                html += `
                    <tr>
                        <td>${params.nama}</td>
                        <td>${params.sku}</td>
                        <td>${params.qty}</td>
                        <td>
                            <a class="btn btn-danger btn-sm" onclick="hapusBarang('${params.sku}')">Hapus</a>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('listBarang').innerHTML = html;
        }

        function hapusBarang(sku) {
            let barang = JSON.parse(localStorage.getItem('barangPembelianReturn')) ?? [];

            let dataBarang = [];
            barang.forEach(function (params) {
                if (params.sku !== sku) {
                    dataBarang.push({
                        'id'        : params.id,
                        'nama'      : params.nama,
                        'sku'       : params.sku,
                        'qty'       : params.qty,
                    });
                }
            });
            localStorage.setItem('barangPembelianReturn', JSON.stringify(dataBarang));
            viewListBarang();
        }

        function prosesPembelianBarang() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success ms-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah kamu yakin?',
                text: "Ingin memproses Return Pembelian barang",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan Proses',
                cancelButtonText: 'Tidak, Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proses Pembalian
                    proses();
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Batal',
                        'Return Pembelian tidak diproses',
                        'error'
                    )
                }
            });
        }

        function proses() {
            let supplier = document.getElementById('supplier').value;
            let tanggal_return = document.getElementById('tanggal_return').value;
            let barang = JSON.parse(localStorage.getItem('barangPembelianReturn'));

            let check = 0;
            if (supplier === "0") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Supplier tidak boleh kosong!',
                });
            }

            if (tanggal_return === "") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tanggal Return tidak boleh kosong!',
                });
            }

            if (barang.length === 0) {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Barang tidak boleh kosong!',
                });
            }

            if (check === 0) {
                $.ajax({
                    url: "{{ route('return_pembelian_post') }}",
                    method: "POST",
                    data: {
                        supplier: supplier,
                        tanggal_return: tanggal_return,
                        barang: barang,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (params) {
                        if (params.status) {
                            localStorage.setItem('barangPembelianReturn', JSON.stringify([]));
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Return Pembelian Barang Berhasil diProses!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Return Pembelian Barang Gagal diProses!',
                            });
                        }
                    }
                });
            }
        }

        viewListBarang()
    </script>
@endsection
