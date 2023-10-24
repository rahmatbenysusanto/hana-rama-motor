<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/login', 'login')->name('login');
});

Route::group(['middleware' => 'ceklogin'], function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    Route::controller(\App\Http\Controllers\BarangController::class)->group(function () {
        Route::get('/barang/oli', 'oli')->name('oli');
        Route::get('/barang/ban', 'ban')->name('ban');
        Route::get('/barang/sparepart', 'sparepart')->name('sparepart');
        Route::get('/barang-rusak', 'barang_rusak')->name('barang_rusak');
        Route::get('/barang', 'find')->name('findBarang');
        Route::get('/find-barang-rusak', 'findBarangRusak')->name('findBarangRusak');
        Route::get('/download-list-barang/{kategori}', 'download_list_barang');
        Route::get('/detail-barang/{id}', 'detail_barang');
        Route::get('/edit-barang/{id}', 'edit_barang');
        Route::post('/edit-barang', 'edit_barang_post')->name('edit_barang_post');
    });

    Route::controller(\App\Http\Controllers\InboundController::class)->group(function () {
        Route::get('/tambah-barang-baru', 'tambah_barang_baru')->name('tambah_barang_baru');
        Route::post('/tambah-barang-baru', 'tambah_barang_baru_post')->name('tambah_barang_baru_post');
        Route::get('/tambah-pembelian-barang', 'tambah_pembelian_barang')->name('tambah_pembelian_barang');
        Route::post('/tambah-pembelian-barang', 'tambah_pembelian_barang_post')->name('tambah_pembelian_barang_post');
        Route::get('/daftar-pembelian', 'daftar_pembelian')->name('daftar_pembelian');
        Route::get('/detail-pembelian/{id}', 'detail_pembelian')->name('detail_pembelian');
        Route::get('/tambah-pembelian-return', 'return_pembelian')->name('return_pembelian');
        Route::post('/tambah-pembelian-return', 'return_pembelian_post')->name('return_pembelian_post');
        Route::get('/list-return-pembelian', 'list_return_pembelian')->name('list_return_pembelian');
        Route::get('/detail-return-pembelian/{id}', 'detail_return_pembelian');
    });

    Route::controller(\App\Http\Controllers\SupplierController::class)->group(function () {
        Route::get('/supplier', 'index')->name('supplier');
        Route::post('/supplier', 'tambah_supplier')->name('tambah_supplier');
        Route::get('/edit-supplier/{id}', 'edit');
        Route::post('/edit-supplier', 'edit_supplier')->name('edit_supplier');
        Route::get('/hapus-supplier/{id}', 'hapus');
    });

    Route::controller(\App\Http\Controllers\PelangganController::class)->group(function () {
        Route::get('/pelanggan', 'index')->name('pelanggan');
        Route::post('/pelanggan', 'tambah_pelanggan')->name('tambah_pelanggan');
        Route::get('/edit-pelanggan/{id}', 'edit');
        Route::post('/edit-pelanggan', 'edit_pelanggan')->name('edit_pelanggan');
        Route::get('/hapus-pelanggan/{id}', 'hapus');
    });

    Route::controller(\App\Http\Controllers\SalesController::class)->group(function () {
        Route::get('/sales', 'index')->name('sales');
        Route::post('/sales', 'tambah_sales')->name('tambah_sales');
        Route::get('/edit-sales/{id}', 'edit');
        Route::post('/edit-sales', 'edit_sales')->name('edit_sales');
        Route::get('/hapus-sales/{id}', 'hapus');
    });

    Route::controller(\App\Http\Controllers\TransaksiController::class)->group(function () {
        Route::get('/tambah-transaksi', 'buat_transaksi')->name('buat_transaksi');
        Route::post('/tambah-transaksi', 'buat_transaksi_post')->name('buat_transaksi_post');
        Route::get('/daftar-transaksi', 'daftar_transaksi')->name('daftar_transaksi');
        Route::get('/detail-transaksi/{id}', 'detail_transaksi');
        Route::get('/edit-transaksi/{id}', 'edit_transaksi');
        Route::get('/cetak-nota-transaksi/{id}', 'cetak_nota_transaksi');

        Route::get('/return-transaksi', 'return_transaksi')->name('return_transaksi');
        Route::get('/proses-return-transaksi/{id}', 'proses_return_transaksi')->name('proses_return_transaksi');
        Route::post('/proses-return-transaksi', 'proses_return_transaksi_post')->name('proses_return_transaksi_post');

        Route::get('/buat-sampel-sales', 'buat_sampel_sales')->name('buat_sampel_sales');
        Route::post('/buat-sample-sales', 'buat_sampel_sales_post')->name('buat_sampel_sales_post');
        Route::get('/list-sampel', 'list_sampel')->name('list_sampel');
        Route::get('/detail-sampel/{id}', 'detail_sampel');
        Route::get('/cetak-nota-sampel/{id}', 'cetak_nota_sampel');
        Route::get('/return-sampel', 'return_sampel')->name('return_sampel');
        Route::get('/proses-return-sampel/{id}', 'proses_return_sampel');
        Route::post('/proses-return-sampel', 'proses_return_sampel_post')->name('proses_return_sampel_post');

        Route::get('/transaksi-khusus-pengambilan-barang', 'pengambilan_barang')->name('pengambilan_barang');
        Route::post('/transaksi-khusus-pengambilan-barang', 'pengambilan_barang_post')->name('pengambilan_barang_post');
        Route::get('/transaksi-khusus-sisa-barang', 'sisa_barang')->name('sisa_barang');
        Route::get('/proses-pengembalian-barang/{id}', 'proses_pengembalian_barang')->name('proses_pengembalian_barang');
        Route::post('/proses-pengembalian-barang', 'proses_pengembalian_barang_post')->name('proses_pengembalian_barang_post');
    });
});

