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
            $item['nama'] = $item->karyawan->nama;
            $item['tanggal_mulai'] = $item->tanggal;
            $item['tanggal_akhir'] = $item->tanggal;
            $item['url'] = '/presensi/'.$item->id;
            switch ($item->status) {
                case '2':
                    $item['warna'] = '#f54242'; //Merah
                    break;
                
                case '3':
                    $item['warna'] = '#f5d742'; //Kuning
                    break;
                
                case '4':
                    $item['warna'] = '#4284f5'; //Biru
                    break;
            }
        }

        $cuti = Cuti::where('status', '2')->get();

        foreach ($cuti as $dataCuti) {
            $dataCuti['nama'] = $dataCuti->karyawan->nama;
            $dataCuti['url'] = '/cuti/'.$dataCuti->id;
            $dataCuti['warna'] = '#7e8082'; //Grey
        }

        $dataKalendar = new Collection;
        $dataKalendar = $dataKalendar->merge($presensi);
        $dataKalendar = $dataKalendar->merge($cuti);

        // dd($presensi);

        return response()->json($dataKalendar);
    }
}
