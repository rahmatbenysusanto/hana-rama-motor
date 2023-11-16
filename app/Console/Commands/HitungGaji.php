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

        // Sales ALIF & WAWAN
        if ($tanggal == 20) {
            Log::channel('gaji')->info('perhitungan gaji tanggal 20');
        }

        // Sales BAGAS & YOGA
        if ($tanggal == 1) {
            Log::channel('gaji')->info('perhitungan gaji tanggal 1');
        }

        // Testing
        Log::channel('gaji')->info('perhitungan gaji testing');
        $pegawai = new PegawaiController();
        $pegawai->hitungGajiPegawai(3);

        $this->info('Hitung Gaji Otomatis');
    }
}
