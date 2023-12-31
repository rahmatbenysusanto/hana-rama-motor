@extends('layout')
@section('konten')
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Daftar List Penjualan Barang</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        List Penjualan Barang
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable-basic" class="table table-bordered text-nowrap w-100">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Invoice</th>
                                <th>Sales</th>
                                <th>Pelanggan</th>
                                <th>Pembayaran</th>
                                <th>Jumlah Barang</th>
                                <th>Total QTY</th>
                                <th>Total Harga</th>
                                <th>Cicilan</th>
                                <th>Status</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Penjualan</th>
                                <th>Tanggal Tempo</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $tra)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $tra->no_invoice }}</td>
                                        <td>{{ $tra->sales->nama }}</td>
                                        <td>{{ $tra->pelanggan->nama }}</td>
                                        <td>{{ $tra->pembayaran->nama }}</td>
                                        <td>{{ $tra->jumlah_barang }}</td>
                                        <td>{{ $tra->qty }}</td>
                                        <td>@currency($tra->total_harga)</td>
                                        <td>@currency($tra->cicilan)</td>
                                        <td>
                                            @if($tra->status == "penjualan")
                                                <span class="badge bg-success-transparent">Normal</span>
                                            @else
                                                <span class="badge bg-danger-transparent">Return</span>
                                            @endif

                                            @if($tra->tanggal_tempo != null)
                                                    <span class="badge bg-danger-transparent">Tempo</span>
                                            @endif

                                            @if($tra->cicilan != null)
                                                    <br><span class="badge bg-warning-transparent mt-1">Cicilan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($tra->status_pembayaran == "Lunas")
                                                <span class="badge bg-success-transparent">Lunas</span>
                                            @elseif($tra->cicilan != null)
                                                <span class="badge bg-warning-transparent">Cicilan</span>
                                            @else
                                                <span class="badge bg-danger-transparent">Belum Bayar</span>
                                            @endif
                                        </td>
                                        <td>{{ tanggal_format($tra->tanggal_penjualan) }}</td>
                                        <td>
                                            @if($tra->tanggal_tempo != null)
                                                {{ tanggal_format($tra->tanggal_tempo) }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm" style="border-radius: 0.25rem" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Pilih
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="/detail-transaksi/{{ $tra->id }}">Lihat Detail</a></li>
                                                    <li><a class="dropdown-item" href="/edit-transaksi/{{ $tra->id }}">Edit</a></li>
                                                    @if($tra->status_pembayaran == "Belum DiBayar")
                                                        <li><a class="dropdown-item" onclick="bayarTransaksi('{{ $tra->id }}')">Bayar Transaksi</a></li>
                                                    @endif
                                                    @if($tra->status_pembayaran == "Belum DiBayar" || $tra->cicilan != null)
                                                        <li><a class="dropdown-item" onclick="bayarCicil('{{ $tra->id }}', '{{ $tra->no_invoice }}')">Bayar Cicil</a></li>
                                                    @endif
                                                    <li><a class="dropdown-item" target="_blank" href="/cetak-nota-transaksi/{{ $tra->id }}">Cetak Nota</a></li>
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

    <div class="modal fade" id="bayar_cicil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('bayar_cicilan') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title" id="bayar_cicil_title"></h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="transaksi_id" id="transaksi_id">
                        <div class="mb-3">
                            <label class="form-label">Nominal</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp. </span>
                                <input type="number" class="form-control" name="jumlah" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function bayarTransaksi(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success ms-2',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Apakah kamu yakin?',
                text: "Ingin Konfirmasi Pembayaran Transaksi?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lanjutkan Proses',
                cancelButtonText: 'Tidak, Batalkan',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('proses_pembayaran') }}',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: '{{csrf_token()}}'
                        },
                        success: function (params) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Pembayaran transaksi berhasil',
                            }).then((res) => {
                                if (res.isConfirmed) {
                                    location.reload();
                                }
                            });
                        }
                    });
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Batal',
                        'Pembayaran tidak diproses',
                        'error'
                    )
                }
            });
        }

        function bayarCicil(transaksi_id, noInvoice) {
            document.getElementById('bayar_cicil_title').innerText = "Pembayaran Cicilan " + noInvoice;
            document.getElementById('transaksi_id').value = transaksi_id;
            $("#bayar_cicil").modal('show');
        }
    </script>
@endsection
