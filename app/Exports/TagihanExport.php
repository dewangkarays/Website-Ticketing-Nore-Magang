<?php

namespace App\Exports;

use App\Model\Tagihan;
use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TagihanExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('tagihans.tagihanexcel', [
            'tagihans' => Tagihan::all()
        ]);
    }
}
