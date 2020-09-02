<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Pengeluaran;
use App\Model\Tagihan;
use Carbon\Carbon;


class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $filter = $request->get('tahun');
        } else {
            $filter = date('Y');
        }
        
        $dateina_month = Carbon::now()->daysInMonth;
        // $days = '1';
        // for ($i=2; $i <= $dateina_month; $i++) { 
        //     $days .= ','. $i;
        // }
        // dd($days);

        $chartmonth = array();

        $chart = array();
        $chart2 = array();
        $neto = array();

        $pie = array();
        $pie2 = array();
        
        // $chart[80] = $chart[90] = $chart[99] = array_fill(1, 12, 0);
        $chart[0] = array_fill(1, 12, 0);
        $chart2[0] = array_fill(1, 12, 0);
        $neto[0] = array_fill(1, 12, 0);
        
        $chartmonth = array_fill(1, $dateina_month, 0);
        $chartmonth2 = array_fill(1, $dateina_month, 0);
        $chartmonth3 = array_fill(1, $dateina_month, 0);

        $br[0] = array_fill(1,12,0);
        $pg[0] = array_fill(1,12,0);
        $qry5[0] = array_fill(1,12,0);
        $qry6[0] = array_fill(1,12,0);

        $qry10[0] = array_fill(1,$dateina_month,0);
        $qry11[0] = array_fill(1,$dateina_month,0);
        // $pie[80] = $pie[90] = $pie[99] = 0;
        // $pie['langgan'] = $pie['ad'] = $pie['lain'] = 0;
        $pie2[0] = $pie2[1] = $pie2[2] = $pie2[3]= $pie2[4]= $pie2[5] = 0;
        

        
        // chart 1, grafik pemasukan monthly bruto
        $qry10 = Payment::selectRaw('day(tgl_bayar) as hari, user_role, sum(nominal) as total ')->whereYear('tgl_bayar',$filter)->groupBy('hari', 'user_role')->get()->toArray();
        $qry11 = Payment::selectRaw('day(tgl_bayar) as hari, user_role, sum(nominal) as total ')->whereYear('tgl_bayar',$filter)->groupBy('hari', 'user_role')->get()->toArray();
        
        foreach ($qry10 as $val) {
            $chartmonth[$val['hari']] += $val['total'];
        }
        // dd($chartmonth);
        

        // chart 1, grafik line pemasukan bruto
        $qry = Payment::selectRaw('month(tgl_bayar) as bulan, user_role, sum(nominal) as total ')
        ->whereYear('tgl_bayar',$filter)->groupBy('bulan', 'user_role')->get()->toArray();

        foreach ($qry as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chart[0][$val['bulan']] += $val['total'];
            
        }
        
        
        // chart 1, grafik line pengeluaran
        $qry2 = Pengeluaran::selectRaw('month(tanggal) as bulan, jenis_pengeluaran, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('bulan', 'jenis_pengeluaran')->get()->toArray();
        
        foreach ($qry2 as $val2) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chart2[0][$val2['bulan']] += $val2['total'];
            
        }
        
        
        // chart 1, grafik line pemasukan neto
        $qry3 = Payment::selectRaw('month(tgl_bayar) as bulan, sum(nominal) as total ')->whereYear('tgl_bayar',$filter)->groupBy('bulan')->get()->toArray();
        
        $qry4 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();
        
        foreach ($qry3 as $net1) {
            $br[0][$net1['bulan']] = $net1['total'];
        }
        foreach ($qry4 as $net2) {
            $pg[0][$net2['bulan']] = $net2['total'];
        }
        foreach ($br[0] as $bulan => $total) {
            $keluar = empty($pg[0][$bulan]) ? 0 : $pg[0][$bulan];
            $neto[0][$bulan] = $total - $keluar;
        }
        
        // tabel list bruto
        $tblbruto = Payment::whereYear('tgl_bayar',$filter)->orderBy('tgl_bayar','DESC')->take(5)->get();
        // dd($tblbruto);
        
        // tabel list pengeluaran
        $tblpengeluaran = Pengeluaran::whereYear('tanggal',$filter)->orderBy('tanggal','DESC')->take(5)->get();
        // dd($tblbruto);
        
        // tabel list pemasukan neto
        $qry5 = Payment::selectRaw('month(tgl_bayar) as bulan, sum(nominal) as total ')
        ->whereYear('tgl_bayar',$filter)->groupBy('bulan')->get()->toArray();
        
        $qry6 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();
        
        $brtbl =array();
        $pgtbl =array();
        $netotbl =array();

        foreach ($qry5 as $net3) {
            $brtbl[$net3['bulan']] = $net3['total'];
        }
        foreach ($qry6 as $net4) {
            $pgtbl[$net4['bulan']] = $net4['total'];
        }

        empty($brtbl) ? 0 : $brtbl;
        empty($pgtbl) ? 0 : $pgtbl;

        foreach ($brtbl as $bulan => $total) {
            $keluar = empty($pgtbl[$bulan]) ? 0 : $pgtbl[$bulan];
            $netotbl[$bulan] = $total - $keluar;
        }
        empty($netotbl) ? 0 : $netotbl;

        // pie pemasukan
        $qrypie1 = Tagihan::selectRaw('sum(langganan) as Langganan, sum(ads) as Ads, sum(lainnya) as Lainnya')->whereYear('created_at',$filter)->get()->toArray();
        // dd($qrypie1);
        
        foreach ($qrypie1 as $pie1) {
            $pie += $pie1;
            // dd($pie);
        }
        
        
        // pie pengeluaran
        $qrypie2 = Pengeluaran::selectRaw('jenis_pengeluaran, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('jenis_pengeluaran')->get()->toArray();
        // dd($qrypie1);
        
        foreach ($qrypie2 as $pie2val) {
            $pie2[$pie2val['jenis_pengeluaran']] += $pie2val['total'];
            // dd($pie2);
        }
        
        $clients = Payment::select('*')->orderBy('tgl_bayar','DESC')->offset(0)->limit(8)->get();
        $totals = Payment::selectRaw('user_id, SUM(nominal) as total')->groupBy('user_id')->orderBy('total','DESC')->get();
        
        
        return view('laporankeuangan', compact('dateina_month', 'chartmonth', 'chart', 'chart2', 'neto', 'tblbruto', 'tblpengeluaran', 'brtbl', 'pgtbl', 'netotbl', 'pie', 'pie2', 'clients', 'filter','totals'));
    }
}
