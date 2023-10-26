@extends('layout')
@section('konten')
    <div class="row mt-3">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        Buat Sampel
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
                                    <label class="form-label">Tanggal Pembuatan</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="tanggal_pembuatan">
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
                        <a class="btn btn-secondary" onclick="prosesPembelianBarang()">Proses Sampel Barang</a>
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
                                        <th>Harga</th>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="tambahBarang()">Tambah Barang</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hitungSampel" tabindex="-1" aria-labelledby="exampleModalSmLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalSmLabel">Hitung Sampel</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="listHitungSampel"></div>
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
                        let dataBarang = JSON.parse(localStorage.getItem('barangSampel')) ?? [];
                        dataBarang.push({
                            'id'        : params.id,
                            'nama'      : params.nama_barang,
                            'sku'       : params.sku,
                            'qty'       : qty,
                            'harga'     : params.harga_sales,
                            'total'     : parseInt(qty) * parseInt(params.harga_sales),
                            'type'      : "harga sales"
                        });
                        localStorage.setItem('barangSampel', JSON.stringify(dataBarang));
                        viewListBarang();
                        document.getElementById('qty').value = "";
                        $("#tambahBarang").modal("hide");
                    }
                });
            }
        }

        function viewListBarang() {
            let barang = JSON.parse(localStorage.getItem('barangSampel')) ?? [];

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
            let barang = JSON.parse(localStorage.getItem('barangSampel')) ?? [];

            let dataBarang = [];
            barang.forEach(function (params) {
                if (params.sku !== sku) {
                    dataBarang.push({
                        'id'        : params.id,
                        'nama'      : params.nama,
                        'sku'       : params.sku,
                        'qty'       : params.qty,
                        'harga'     : params.harga,
                        'total'     : params.total
                    });
                }
            });
            localStorage.setItem('barangSampel', JSON.stringify(dataBarang));
            viewListBarang();
        }

        function prosesPembelianBarang() {
            let sales = document.getElementById('sales').value;
            let tanggal_pembuatan = document.getElementById('tanggal_pembuatan').value;

            let barang = JSON.parse(localStorage.getItem('barangSampel'));

            let check = 0;
            if (sales === "") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Sales tidak boleh kosong!',
                });
            }

            if (tanggal_pembuatan === "") {
                check = check  + 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Tanggal Pembuatan tidak boleh kosong!',
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
                let html = `
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>SKU</th>
                                <th>QTY</th>
                                <th>Harga</th>
                                <th>Total Harga</th>
                            </tr>
                            </thead>
                            <tbody>`

                const rupiah = (number)=>{
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }).format(number);
                }
                let no = 1;
                let totalHargaBarang = 0;
                barang.forEach(function (params) {
                    html += `
                                <tr>
                                    <td>${no++}</td>
                                    <td>${params.nama}</td>
                                    <td>${params.sku}</td>
                                    <td>${params.qty}</td>
                                    <td>${rupiah(params.harga)}</td>
                                    <td>${rupiah(params.total)}</td>
                                </tr>
                        `;
                    totalHargaBarang += parseInt(params.total)
                });

                html += `
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <table>
                            <tr>
                                <td class="fw-bold">Total Harga</td>
                                <td class="fw-bold ps-3">${rupiah(totalHargaBarang)}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-primary mt-4" onclick="proses()">Proses Sampel</a>
                    </div>
                `;

                document.getElementById('listHitungSampel').innerHTML = html;

                $('#hitungSampel').modal('show');
            }
        }

        function proses() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success ms-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah kamu yakin?',
                text: "Ingin memproses Sampel barang",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan Proses',
                cancelButtonText: 'Tidak, Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proses Pembalian
                    let sales = document.getElementById('sales').value;
                    let tanggal_pembuatan = document.getElementById('tanggal_pembuatan').value;

                    let barang = JSON.parse(localStorage.getItem('barangSampel'));

                    let check = 0;
                    if (sales === "") {
                        check = check  + 1;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Sales tidak boleh kosong!',
                        });
                    }

                    if (tanggal_pembuatan === "") {
                        check = check  + 1;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Tanggal Pembuatan tidak boleh kosong!',
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
                            url: "{{ route('buat_sampel_sales_post') }}",
                            method: "POST",
                            data: {
                                sales: sales,
                                tanggal_pembuatan: tanggal_pembuatan,
                                barang: barang,
                                _token: '{{csrf_token()}}'
                            },
                            success: function (params) {
                                if (params.status) {
                                    localStorage.setItem('barangSampel', JSON.stringify([]));
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Pembuatan Sampel Berhasil diProses!',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Pembuatan Sampel Gagal diProses!',
                                    });
                                }
                            }
                        });
                    }
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Batal',
                        'Sampel tidak diproses',
                        'error'
                    )
                }
            });
        }

        viewListBarang()
    </script>
@endsection
