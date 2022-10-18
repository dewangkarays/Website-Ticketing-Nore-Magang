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
        $presensi = Presensi::all();

        return response()->json($presensi);
    }
}
