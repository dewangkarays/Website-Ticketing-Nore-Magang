<?php

namespace App\Http\Controllers;

use App\Model\Presensi;
use App\Model\Cuti;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class KalendarController extends Controller
{
    public function index() {
        return view('kalendar');
    }

    public function getkalender() {
        $presensi = Presensi::where('status', '!=', '1')->get();

        foreach ($presensi as $item) {
            $item['tanggal_mulai'] = $item->tanggal;
            $item['tanggal_akhir'] = $item->tanggal;
            $item['nama'] = $item->karyawan->nama;
        }

        $cuti = Cuti::where('status', '2')
            ->where('tanggal_mulai', '<=', date('Y-m-d'))
            ->where('tanggal_akhir', '>=', date('Y-m-d'))
            ->get();

        foreach ($cuti as $dataCuti) {
            $dataCuti['nama'] = $dataCuti->karyawan->nama;
        }

        $dataKalendar = new Collection;
        $dataKalendar = $dataKalendar->merge($presensi);
        $dataKalendar = $dataKalendar->merge($cuti);

        // dd($presensi);

        return response()->json($dataKalendar);
    }
}
