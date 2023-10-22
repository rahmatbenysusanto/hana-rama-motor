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
                                    <label class="form-label">Tanggal Datang</label>
                                    <input type="date" class="form-control" id="tanggal_datang" name="tanggal_datang">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No Invoice</label>
                                    <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Masukan No Invoice">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="form-label">Diskon Pembelian</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="diskon_pembelian" placeholder="Masukan Diskon">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label">PPN</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="ppn" placeholder="Masukan PPN">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-secondary" onclick="prosesPembelianBarang()">Proses Barang Return</a>
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
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahBarang">Tambah Barang</a>
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
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Total Harga</th>
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
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" placeholder="Masukan Harga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Diskon</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="diskon" placeholder="Masukan Diskon">
                            <span class="input-group-text">%</span>
                        </div>
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
        $('#cari_barang').select2({
            dropdownParent: $('#tambahBarang'),
        });

        $('#supplier').select2();

        function tambahBarang() {
            let barang = document.getElementById('barang').value;
            let qty = document.getElementById('qty').value;
            let harga = document.getElementById('harga').value;
            let diskon = document.getElementById('diskon').value;

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

            if (harga === "") {
                check = check + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Harga tidak boleh kosong!',
                });
            }

            if (diskon === "") {
                check = check + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Diskon tidak boleh kosong!',
                });
            }

            let total = parseInt(qty) * parseInt(harga);
            let nominal = total * (diskon / 100);

            if (check === 0) {
                $.ajax({
                    url: "{{ route('findBarang') }}",
                    method: "GET",
                    data: {
                        barang_id: barang
                    },
                    success: function (params) {
                        let dataBarang = JSON.parse(localStorage.getItem('barang')) ?? [];
                        dataBarang.push({
                            'id'        : params.id,
                            'nama'      : params.nama_barang,
                            'sku'       : params.sku,
                            'qty'       : qty,
                            'harga'     : harga,
                            'diskon'    : diskon,
                            'total'     : total - nominal
                        });
                        localStorage.setItem('barang', JSON.stringify(dataBarang));
                        viewListBarang();
                        $("#tambahBarang").modal("hide");
                    }
                });
            }
        }

        function viewListBarang() {
            let barang = JSON.parse(localStorage.getItem('barang')) ?? [];

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
                        <td>${rupiah(params.harga)}</td>
                        <td>${params.diskon}%</td>
                        <td>${rupiah(params.total)}</td>
                        <td>
                            <a class="btn btn-danger btn-sm" onclick="hapusBarang('${params.sku}')">Hapus</a>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('listBarang').innerHTML = html;
        }

        function hapusBarang(sku) {
            let barang = JSON.parse(localStorage.getItem('barang')) ?? [];

            let dataBarang = [];
            barang.forEach(function (params) {
                if (params.sku !== sku) {
                    dataBarang.push({
                        'id'        : params.id,
                        'nama'      : params.nama,
                        'sku'       : params.sku,
                        'qty'       : params.qty,
                        'harga'     : params.harga,
                        'diskon'    : params.diskon,
                        'total'     : params.total
                    });
                }
            });
            localStorage.setItem('barang', JSON.stringify(dataBarang));
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
                text: "Ingin memproses pembelian barang",
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
                        'Pembelian tidak diproses',
                        'error'
                    )
                }
            });
        }

        function proses() {
            let supplier = document.getElementById('supplier').value;
            let tanggal_datang = document.getElementById('tanggal_datang').value;
            let invoice = document.getElementById('invoice').value;
            let diskon_pembelian = document.getElementById('diskon_pembelian').value;
            let ppn = document.getElementById('ppn').value;
            let barang = JSON.parse(localStorage.getItem('barang'));

            let check = 0;
            if (supplier === "0") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Supplier tidak boleh kosong!',
                });
            }

            if (tanggal_datang === "") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tanggal Datang tidak boleh kosong!',
                });
            }

            if (invoice === "") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Invoice tidak boleh kosong!',
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
                        tanggal_datang: tanggal_datang,
                        invoice: invoice,
                        diskon_pembelian: diskon_pembelian,
                        ppn: ppn,
                        barang: barang,
                        _token: '{{csrf_token()}}'
                    },
                    success: function (params) {
                        if (params.status) {
                            localStorage.setItem('barang', JSON.stringify([]));
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
