<?php

namespace App\Console\Commands;

use App\Http\Controllers\PegawaiController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class HitungGaji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hitung-gaji';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hitung Gaji Otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Perhitungan Gaji Otomatis
        $tanggal = date('d', time());
        $tanggalAkhir = date('t', time());

        $pegawai = new PegawaiController();

        // Sales ALIF & WAWAN
        if ($tanggal == 20) {
            Log::channel('gaji')->info('perhitungan gaji tanggal 20');
            $pegawai->hitungGajiPegawai(2);
            $pegawai->hitungGajiPegawai(16);
        }

        // Sales BAGAS & YOGA & RAFIKA
        if ($tanggal == $tanggalAkhir) {
            Log::channel('gaji')->info('perhitungan gaji tanggal 1');
            $pegawai->hitungGajiPegawai(3);
            $pegawai->hitungGajiPegawai(17);
            $pegawai->hitungGajiPegawai(18);
        }

        Log::channel('gaji')->notice('Cron Job dijalankan '.date('d M Y H:i:s', time()));

        $this->info('Hitung Gaji Otomatis');
    }
}
