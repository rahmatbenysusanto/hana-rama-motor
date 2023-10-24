@extends('layout')
@section('konten')
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Ambil Barang
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Sales</label>
                                    <select class="form-control" id="sales">
                                        <option value="0">Pilih Sales</option>
                                        @foreach($sales as $s)
                                            <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal Pengambilan</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="tanggal_pengambilan">
                                    </div>
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
                        <a class="btn btn-primary" onclick="modalBarang()">Tambah Barang</a>
                        <a class="btn btn-secondary" onclick="prosesPembelianBarang()">Proses Barang</a>
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
                                <option value="{{ $b->id }}">{{ $b->kategori->nama }} | {{ $b->sku }} | {{ $b->nama_barang }}</option>
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

        $('#sales').select2();

        function modalBarang() {
            let sales = document.getElementById('sales').value;
            if (sales === "0") {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Silahkan pilih sales terlebih dahulu',
                });
            } else {
                if (sales === "1") {
                    localStorage.setItem('typeSales', 'umum');
                } else {
                    localStorage.setItem('typeSales', 'sales');
                }
                $("#tambahBarang").modal("show");
            }
        }

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
                    url: "{{ route('findBarang') }}",
                    method: "GET",
                    data: {
                        barang_id: barang
                    },
                    success: function (params) {
                        let dataBarang = JSON.parse(localStorage.getItem('barangTransaksiKhususAmbil')) ?? [];
                        dataBarang.push({
                            'id'        : params.id,
                            'nama'      : params.nama_barang,
                            'sku'       : params.sku,
                            'qty'       : qty,
                        });
                        localStorage.setItem('barangTransaksiKhususAmbil', JSON.stringify(dataBarang));
                        viewListBarang();
                        document.getElementById('qty').value = "";
                        $("#tambahBarang").modal("hide");
                    }
                });
            }
        }

        function viewListBarang() {
            let barang = JSON.parse(localStorage.getItem('barangTransaksiKhususAmbil')) ?? [];

            let html = '';
            const rupiah = (number)=>{
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(number);
            }
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
            let barang = JSON.parse(localStorage.getItem('barangTransaksiKhususAmbil')) ?? [];

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
            localStorage.setItem('barangTransaksiKhususAmbil', JSON.stringify(dataBarang));
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
                text: "Ingin memproses Pengambilan Barang",
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
                        'Ambil Barang tidak diproses',
                        'error'
                    )
                }
            });
        }

        function proses() {
            let sales = document.getElementById('sales').value;
            let tanggal_pengambilan = document.getElementById('tanggal_pengambilan').value;
            let barang = JSON.parse(localStorage.getItem('barangTransaksiKhususAmbil'));

            console.log(tanggal_pengambilan);

            let check = 0;
            if (sales === "") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Sales tidak boleh kosong!',
                });
            }

            if (tanggal_pengambilan === "") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tanggal Pengambilan tidak boleh kosong!',
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
                    url: "{{ route('pengambilan_barang_post') }}",
                    method: "POST",
                    data: {
                        sales: sales,
                        tanggal_pengambilan: tanggal_pengambilan,
                        barang: barang,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (params) {
                        if (params.status) {
                            localStorage.setItem('barangTransaksiKhususAmbil', JSON.stringify([]));
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Pengambilan Barang Berhasil diProses!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Pengambilan Barang Gagal diProses!',
                            });
                        }
                    }
                });
            }
        }

        viewListBarang()
    </script>
@endsection
