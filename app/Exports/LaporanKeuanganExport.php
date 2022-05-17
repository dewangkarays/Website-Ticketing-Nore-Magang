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

        $p_jasa = $payment->where('jenis_pemasukan', '=', 1)->sum('nominal');
        $p_bunga = 0;
        $p_lain2 = $payment->where('jenis_pemasukan', '=', 2)->sum('nominal');
        $pend_total = $p_jasa + $p_bunga + $p_lain2;

        $aset = $pengeluaran->where('jenis_pengeluaran', '=', 14)->sum('nominal');
        $peng_total = $pengeluaran->sum('nominal') - $aset;
        $labarugi = $pend_total - $peng_total;

        $allItems = new Collection;
        $allItems = $allItems->merge($payment);
        $allItems = $allItems->merge($pengeluaran)->sortBy('tanggal');

        $firstdate = "01-".$this->bulan."-".$this->tahun;
        $lastdate = date('t', strtotime($firstdate));
        $bulan = strtoupper(config('custom.bulan.' .$this->bulan));
        $tahun = $this->tahun;

        return view('exportlaporan', compact('pengeluaran','allItems', 'bulan', 'tahun', 'lastdate', 'allItems', 'p_jasa',
                                            'p_bunga', 'p_lain2', 'pend_total', 'peng_total', 'labarugi', 'aset'));
    }

    public function title(): string
    {
        return 'Laporan Keuangan';
    }
}
