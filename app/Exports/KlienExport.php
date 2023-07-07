<?php

namespace App\Exports;

use App\Model\Klien;
use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class KlienExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('klien.leadsexcel', [
            'kliens' => Klien::all()
        ]);
    }
}