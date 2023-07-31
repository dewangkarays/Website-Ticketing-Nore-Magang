<?php

namespace App\Http\Controllers;

// use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;


class QRController extends Controller
{
    public function index ()
    {
        return view('presensi.qrcode');
    }

    public function exportpdf()
    {
        $data = QrCode::size(200)->generate(date("Y-m-d"));
    
        $pdf = PDF::loadView('presensi.CetakBarcode-pdf', ['data' => $data]);

        return $pdf->download('datamahasiswa.pdf');
    }
}
