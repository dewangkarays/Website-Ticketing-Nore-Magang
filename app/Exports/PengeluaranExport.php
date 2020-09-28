<?php

namespace App\Exports;

use App\Model\Pengeluaran;
use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

// class PengeluaranExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return Pengeluaran::all();
//     }
// }
class PengeluaranExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('pengeluarans.pengeluaranexcel', [
            'pengeluarans' => Pengeluaran::all()
        ]);
    }
}
