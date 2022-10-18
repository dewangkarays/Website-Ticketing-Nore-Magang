<?php

namespace App\Http\Controllers;

use App\Model\Presensi;
use Illuminate\Http\Request;

class KalendarController extends Controller
{
    public function index() {
        return view('kalendar');
    }

    public function getkalender() {
        $presensi = Presensi::where('status', '!=', '1')->get();

        foreach ($presensi as $item) {
            $item['nama'] = $item->karyawan->nama;
        }

        // dd($presensi);

        return response()->json($presensi);
    }
}
