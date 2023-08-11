<?php

namespace App\Http\Controllers;

// use Barryvdh\DomPDF\PDF;
use PDF;

use Ramsey\Uuid\Uuid;
use App\Model\PresensiQR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class QRController extends Controller
{
    public function index ()
    {   
        $cacheKey = 'uuid_' . now()->toDateString();

        $uuid = Cache::remember($cacheKey, now()->addDay(), function () {
             return Uuid::uuid4()->toString();
    });
        $presensi = PresensiQR::updateOrCreate(
            [
                'tanggal' => now()->toDateString() 
            ],
            [    
                'uuid' => $uuid 
            ]);
        return view('presensi.qrcode', compact('uuid'));
        
    }

    public function exportpdf()
    {
        $cacheKey = 'uuid_' . now()->toDateString();

        $uuid = Cache::remember($cacheKey, now()->addDay(), function () {
             return Uuid::uuid4()->toString();
        });
        $data = QrCode::size(200)->generate($uuid);
    
        $pdf = PDF::loadView('presensi.CetakBarcode-pdf', ['data' => $data]);

        return $pdf->download('KodeQR.pdf');
    }

    // public function store(Request $request)
    // {
    //         Presensi::create([
    //         'uuid' => $uuid,
    //         'tanggal' => now()->format('Y-m-d'),
    //     ]);

    // }
}
