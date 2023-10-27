<?php

function tanggal_format($date): string
{
    $tanggal = substr($date, 8, 2);
    $bulan = substr($date, 5, 2);
    $jam = substr($date, 11, 2);
    $menit = substr($date, 14, 2);
    $detik = substr($date, 17, 2);
    if ($bulan == '01') {
        $bulan = 'Januari';
    } elseif ($bulan == '02') {
        $bulan = 'Februari';
    } elseif ($bulan == '03') {
        $bulan = 'Maret';
    } elseif ($bulan == '04') {
        $bulan = 'April';
    } elseif ($bulan == '05') {
        $bulan = 'Mei';
    } elseif ($bulan == '06') {
        $bulan = 'Juni';
    } elseif ($bulan == '07') {
        $bulan = 'Juli';
    } elseif ($bulan == '08') {
        $bulan = 'Agustus';
    } elseif ($bulan == '09') {
        $bulan = 'September';
    } elseif ($bulan == '10') {
        $bulan = 'Oktober';
    } elseif ($bulan == '11') {
        $bulan = 'November';
    } elseif ($bulan == '12') {
        $bulan = 'Desember';
    }
    $tahun = substr($date, 0, 4);

    return $tanggal . ' ' . $bulan . ' ' . $tahun;
}

function getBulan() {
    $bulan = date('m', time());
    if ($bulan == '01') {
        $bulan = 'Januari';
    } elseif ($bulan == '02') {
        $bulan = 'Februari';
    } elseif ($bulan == '03') {
        $bulan = 'Maret';
    } elseif ($bulan == '04') {
        $bulan = 'April';
    } elseif ($bulan == '05') {
        $bulan = 'Mei';
    } elseif ($bulan == '06') {
        $bulan = 'Juni';
    } elseif ($bulan == '07') {
        $bulan = 'Juli';
    } elseif ($bulan == '08') {
        $bulan = 'Agustus';
    } elseif ($bulan == '09') {
        $bulan = 'September';
    } elseif ($bulan == '10') {
        $bulan = 'Oktober';
    } elseif ($bulan == '11') {
        $bulan = 'November';
    } elseif ($bulan == '12') {
        $bulan = 'Desember';
    }

    return $bulan;
}
