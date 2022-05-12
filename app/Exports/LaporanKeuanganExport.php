<?php

namespace App\Exports;

use App\Model\Pengeluaran;
use App\Model\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use \Illuminate\Database\Eloquent\Collection;

class LaporanKeuanganExport implements FromView, WithTitle
{
    public function __construct($filter, $filterbulan)
    {
        $this->tahun = $filter;
        $this->bulan = $filterbulan;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $payment = Payment::whereYear('tanggal',$this->tahun)->whereMonth('tanggal', $this->bulan)->orderBy('tanggal')->get();
        $pengeluaran = Pengeluaran::whereYear('tanggal',$this->tahun)->whereMonth('tanggal', $this->bulan)->orderBy('tanggal')->get();

        $allItems = new Collection;
        $allItems = $allItems->merge($payment);
        $allItems = $allItems->merge($pengeluaran)->sortBy('tanggal');

        $firstdate = "01-".$this->bulan."-".$this->tahun;
        $lastdate = date('t', strtotime($firstdate));
        $bulan = config('custom.bulan.' .$this->bulan);
        $tahun = $this->tahun;

        return view('exportlaporan', compact('allItems', 'bulan', 'tahun', 'lastdate'));
    }

    public function title(): string
    {
        return 'Lporan Keuangan Export';
    }
}
