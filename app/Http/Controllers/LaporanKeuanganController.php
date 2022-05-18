<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Pengeluaran;
use App\Model\Tagihan;
use App\Model\Setting;
use Carbon\Carbon;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganExport;
use \Illuminate\Database\Eloquent\Collection;


class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $filter = $request->get('tahun');
            $filterbulan = $request->get('bulan');
        } else {
            $filter = date('Y');
            $filterbulan = date('n');
        }

        // if($request->isMethod('post')){
        //     $filterbulan = $request->get('bulan');
        // } else {
        //    $filterbulan = date('m');
        // }
        // dd($filterbulan);

        if ($filterbulan == date('n')) {
            $dateina_month = Carbon::now()->daysInMonth;
        } elseif ($filterbulan != date('n') ) {
            $dateina_month = Carbon::create()->month($filterbulan)->daysInMonth;
        }
        // $days = '1';
        // for ($i=2; $i <= $dateina_month; $i++) {
            //     $days .= ','. $i;
            // }
        // dd($dateina_month);

        // yearly
        $chart = array();
        $chart2 = array();
        $neto = array();

        // monthly
        $chartmonth = array();
        $chartmonth2 = array();
        $chartmonth3 = array();

        // quarter
        $chartq1 = array();
        $chartq12 = array();
        $netoq13 = array();

        $chartq2 = array();
        $chartq22 = array();
        $chartq23 = array();

        $chartq3 = array();
        $chartq32 = array();
        $chartq33 = array();

        $chartq4 = array();
        $chartq42 = array();
        $chartq43 = array();

        // pie
        $pie = array();
        $pie2 = array();

        // $chart[80] = $chart[90] = $chart[99] = array_fill(1, 12, 0);
        // yearly
        $chart[0] = array_fill(1, 12, 0);
        $chart2[0] = array_fill(1, 12, 0);
        $neto[0] = array_fill(1, 12, 0);

        // monthly
        $chartmonth = array_fill(1, $dateina_month, 0);
        $chartmonth2 = array_fill(1, $dateina_month, 0);
        $chartmonth3 = array_fill(1, $dateina_month, 0);

        // quarter
        $chartq1[0] = array_fill(1, 3, 0);
        $chartq12[0] = array_fill(1, 3, 0);
        $netoq13[0] = array_fill(1, 3, 0);

        $chartq2[0] = array_fill(4, 3, 0);
        $chartq22[0] = array_fill(4, 3, 0);
        $chartq23[0] = array_fill(4, 3, 0);

        $chartq3[0] = array_fill(7, 3, 0);
        $chartq32[0] = array_fill(7, 3, 0);
        $chartq33[0] = array_fill(7, 3, 0);

        $chartq4[0] = array_fill(10, 3, 0);
        $chartq42[0] = array_fill(10, 3, 0);
        $chartq43[0] = array_fill(10, 3, 0);



        $br[0] = array_fill(1,12,0);
        $pg[0] = array_fill(1,12,0);

        // tabel
        $qry5[0] = array_fill(1,12,0);
        $qry6[0] = array_fill(1,12,0);

        // monthly
        $bru = array_fill(1,$dateina_month,0);
        $pge = array_fill(1,$dateina_month,0);

        // quarter
        $brq1[0] = array_fill(1,3,0);
        $brq2[0] = array_fill(4,3,0);
        $brq3[0] = array_fill(7,3,0);
        $brq4[0] = array_fill(10,3,0);
        $pgq1[0] = array_fill(1,3,0);
        $pgq2[0] = array_fill(4,3,0);
        $pgq3[0] = array_fill(7,3,0);
        $pgq4[0] = array_fill(10,3,0);

        $qry10[0] = array_fill(1,$dateina_month,0);
        $qry11[0] = array_fill(1,$dateina_month,0);
        $qry12[0] = array_fill(1,$dateina_month,0);
        $qry13[0] = array_fill(1,$dateina_month,0);
        // $pie[80] = $pie[90] = $pie[99] = 0;
        // $pie['langgan'] = $pie['ad'] = $pie['lain'] = 0;
        foreach(config("custom.kat_pengeluaran") as $key => $value)
        {
            $pie2[$key] = 0;
        }
        // $pie2[0] = $pie2[1] = $pie2[2] = $pie2[3]= $pie2[4]= $pie2[5] = 0;


/* ------------------------------------------------------------------------------
* ---------------------------------------------------------------------------- */

        // chart 1, grafik pemasukan monthly
        // bruto
        $qry10 = Payment::selectRaw('day(tanggal) as hari, user_role, sum(nominal) as total ')
        ->whereYear('tanggal',$filter)->whereMonth('tanggal', $filterbulan)
        ->groupBy('hari', 'user_role')->get()->toArray();

        foreach ($qry10 as $val) {
            $chartmonth[$val['hari']] += $val['total'];
        }

        // pengeluaran
        $qry11 = Pengeluaran::selectRaw('day(tanggal) as hari, jenis_pengeluaran, sum(nominal) as total ')
        ->whereYear('tanggal',$filter)->whereMonth('tanggal', $filterbulan)
        ->groupBy('hari', 'jenis_pengeluaran')->get()->toArray();
        // dd($chartmonth);
        foreach ($qry11 as $val) {
            $chartmonth2[$val['hari']] += $val['total'];
        }

        // neto
        $qry12 = Payment::selectRaw('day(tanggal) as hari, sum(nominal) as total ')
        ->whereYear('tanggal',$filter)->whereMonth('tanggal', $filterbulan)
        ->groupBy('hari')->get()->toArray();

        $qry13 = Pengeluaran::selectRaw('day(tanggal) as hari, sum(nominal) as total ')
        ->whereYear('tanggal',$filter)->whereMonth('tanggal', $filterbulan)
        ->groupBy('hari')->get()->toArray();

        foreach ($qry12 as $net1) {
            $bru[$net1['hari']] = $net1['total'];
        }

        foreach ($qry13 as $net2) {
            $pge[$net2['hari']] = $net2['total'];
        }

        foreach ($bru as $hari => $total) {
            $keluar = empty($pge[$hari]) ? 0 : $pge[$hari];
            $chartmonth3[$hari] = $total - $keluar;
        }

/* ------------------------------------------------------------------------------
* ---------------------------------------------------------------------------- */

// Quarter 1
// ------------------------------

        // chart q1
        $qry15 = Payment::selectRaw('month(tanggal) as bulan, user_role, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 1 AND month(tanggal) <= 3')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'user_role')->get()->toArray();

        foreach ($qry15 as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq1[0][$val['bulan']] += $val['total'];
        }
        // dd($chartq1);

        $qry16 = Pengeluaran::selectRaw('month(tanggal) as bulan, jenis_pengeluaran, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 1 AND month(tanggal) <= 3')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'jenis_pengeluaran')->get()->toArray();

        foreach ($qry16 as $val2) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq12[0][$val2['bulan']] += $val2['total'];
        }
        // dd($chartq2);

        $qry17 = Payment::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 1 AND month(tanggal) <= 3')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        $qry18 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 1 AND month(tanggal) <= 3')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        foreach ($qry17 as $net1) {
            $brq1[0][$net1['bulan']] = $net1['total'];
        }
        foreach ($qry18 as $net2) {
            $pgq1[0][$net2['bulan']] = $net2['total'];
        }
        foreach ($brq1[0] as $bulan => $total) {
            $keluar = empty($pgq1[0][$bulan]) ? 0 : $pgq1[0][$bulan];
            $netoq13[0][$bulan] = $total - $keluar;
        }

// Quarter 2
// ------------------------------

        // chart q2
        $qry19 = Payment::selectRaw('month(tanggal) as bulan, user_role, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 4 AND month(tanggal) <= 6')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'user_role')->get()->toArray();

        foreach ($qry19 as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq2[0][$val['bulan']] += $val['total'];
        }
        // dd($chartq1);

        $qry20 = Pengeluaran::selectRaw('month(tanggal) as bulan, jenis_pengeluaran, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 4 AND month(tanggal) <= 6')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'jenis_pengeluaran')->get()->toArray();

        foreach ($qry20 as $val2) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq22[0][$val2['bulan']] += $val2['total'];
        }
        // dd($chartq22);

        $qry21 = Payment::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 4 AND month(tanggal) <= 6')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        $qry22 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 4 AND month(tanggal) <= 6')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        foreach ($qry17 as $net1) {
            $brq2[0][$net1['bulan']] = $net1['total'];
        }
        foreach ($qry18 as $net2) {
            $pgq2[0][$net2['bulan']] = $net2['total'];
        }
        foreach ($brq2[0] as $bulan => $total) {
            $keluar = empty($pgq2[0][$bulan]) ? 0 : $pgq2[0][$bulan];
            $chartq23[0][$bulan] = $total - $keluar;
        }


// Quarter 3
// ------------------------------

        // chart q3
        $qry23 = Payment::selectRaw('month(tanggal) as bulan, user_role, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 7 AND month(tanggal) <= 9')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'user_role')->get()->toArray();

        foreach ($qry23 as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq3[0][$val['bulan']] += $val['total'];
        }
        // dd($chartq1);

        $qry24 = Pengeluaran::selectRaw('month(tanggal) as bulan, jenis_pengeluaran, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 7 AND month(tanggal) <= 9')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'jenis_pengeluaran')->get()->toArray();

        foreach ($qry24 as $val2) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq32[0][$val2['bulan']] += $val2['total'];
        }
        // dd($chartq22);

        $qry25 = Payment::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 7 AND month(tanggal) <= 9')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        $qry26 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 7 AND month(tanggal) <= 9')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        foreach ($qry25 as $net1) {
            $brq3[0][$net1['bulan']] = $net1['total'];
        }
        foreach ($qry26 as $net2) {
            $pgq3[0][$net2['bulan']] = $net2['total'];
        }
        // dd($qry26);
        foreach ($brq3[0] as $bulan => $total) {
            $keluar = empty($pgq3[0][$bulan]) ? 0 : $pgq3[0][$bulan];
            $chartq33[0][$bulan] = $total - $keluar;
        }

// Quarter 4
// ------------------------------

        // chart q4
        $qry27 = Payment::selectRaw('month(tanggal) as bulan, user_role, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 10 AND month(tanggal) <= 12')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'user_role')->get()->toArray();

        foreach ($qry27 as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq4[0][$val['bulan']] += $val['total'];
        }
        // dd($chartq1);

        $qry28 = Pengeluaran::selectRaw('month(tanggal) as bulan, jenis_pengeluaran, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 10 AND month(tanggal) <= 12')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'jenis_pengeluaran')->get()->toArray();

        foreach ($qry28 as $val2) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chartq42[0][$val2['bulan']] += $val2['total'];
        }
        // // dd($chartq22);

        $qry29 = Payment::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 10 AND month(tanggal) <= 12')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        $qry30 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereRaw('month(tanggal) >= 10 AND month(tanggal) <= 12')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        foreach ($qry29 as $net1) {
            $brq4[0][$net1['bulan']] = $net1['total'];
        }
        foreach ($qry30 as $net2) {
            $pgq4[0][$net2['bulan']] = $net2['total'];
        }

        // dd($qry26);
        foreach ($brq4[0] as $bulan => $total) {
            $keluar = empty($pgq4[0][$bulan]) ? 0 : $pgq4[0][$bulan];
            $chartq43[0][$bulan] = $total - $keluar;
        }


/* ------------------------------------------------------------------------------
* ---------------------------------------------------------------------------- */
// Chart yearly + grafik line
// ------------------------------

        // pemasukan bruto
        $qry = Payment::selectRaw('month(tanggal) as bulan, user_role, sum(nominal) as total ')
        ->whereYear('tanggal',$filter)->groupBy('bulan', 'user_role')->get()->toArray();

        foreach ($qry as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chart[0][$val['bulan']] += $val['total'];

        }


        // pengeluaran
        $qry2 = Pengeluaran::selectRaw('month(tanggal) as bulan, jenis_pengeluaran, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('bulan', 'jenis_pengeluaran')->get()->toArray();

        foreach ($qry2 as $val2) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chart2[0][$val2['bulan']] += $val2['total'];

        }


        // pemasukan neto
        $qry3 = Payment::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        $qry4 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

        foreach ($qry3 as $net1) {
            $br[0][$net1['bulan']] = $net1['total'];
        }
        foreach ($qry4 as $net2) {
            $pg[0][$net2['bulan']] = $net2['total'];
        }
        foreach ($br[0] as $bulan => $total) {
            $keluar2 = empty($pg[0][$bulan]) ? 0 : $pg[0][$bulan];
            $neto[0][$bulan] = $total - $keluar2;
        }

/* ------------------------------------------------------------------------------
* ---------------------------------------------------------------------------- */

        // tabel list bruto
        $tblbruto = Payment::whereYear('tanggal',$filter)->orderBy('tanggal','DESC')->take(5)->get();
        // dd($tblbruto);

        // tabel list pengeluaran
        $tblpengeluaran = Pengeluaran::whereYear('tanggal',$filter)->orderBy('tanggal','DESC')->take(5)->get();
        // dd($tblbruto);

        // tabel list pemasukan neto
        $qry5 = Payment::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')
        ->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();

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
        $qrypie1 = Tagihan::selectRaw('sum(nominal) as Tagihan, sum(uang_muka) as DP')->whereYear('created_at',$filter)->get()->toArray();
        // dd($qrypie1);

        foreach ($qrypie1 as $pie1) {
            $pie += $pie1;
            // dd($pie);
        }

        // pie pengeluaran
        $qrypie2 = Pengeluaran::selectRaw('sum(nominal) as total, jenis_pengeluaran')->whereYear('tanggal',$filter)->groupBy('jenis_pengeluaran')->get()->toArray();
        // dd($qrypie2);

        foreach ($qrypie2 as $pie2val) {
            // dump($pie2val);
            $pie2[$pie2val['jenis_pengeluaran']] += $pie2val['total'];
        }
        // dd($pie2);
        // die;

        $clients = Payment::select('*')->orderBy('tanggal','DESC')->offset(0)->limit(8)->get();
        $totals = Payment::selectRaw('user_id, SUM(nominal) as total')->groupBy('user_id')->orderBy('total','DESC')->get();


/* ------------------------------------------------------------------------------
* ---------------------------------------------------------------------------- */

        return view('laporankeuangan', compact(
            'dateina_month', 'chartmonth', 'chartmonth2', 'chartmonth3',
            'chartq1', 'chartq12', 'netoq13',
            'chartq2', 'chartq22', 'chartq23',
            'chartq3', 'chartq32', 'chartq33',
            'chartq4', 'chartq42', 'chartq43',
            'chart', 'chart2', 'neto',
            'tblbruto', 'tblpengeluaran', 'brtbl', 'pgtbl', 'netotbl',
            'pie', 'pie2', 'clients', 'filter', 'filterbulan', 'totals'));
    }
    public function cetaklaporan($filter, $filterbulan)
    {
        $tahun = $filter;
        $bulan = $filterbulan;
        $firstdate = "01-".$bulan."-".$tahun;
        $lastdate = date('t', strtotime($firstdate));
        //dd($lastdate);

        $payment = Payment::whereYear('tanggal',$tahun)->whereMonth('tanggal', $bulan)->orderBy('tanggal')->get();
        $pengeluaran = Pengeluaran::whereYear('tanggal',$tahun)->whereMonth('tanggal', $bulan)->orderBy('tanggal')->get();

        $p_jasa = $payment->where('jenis_pemasukan', '=', 1)->sum('nominal');
        $p_bunga = 0;
        $p_lain2 = $payment->where('jenis_pemasukan', '=', 2)->sum('nominal');
        $pend_total = $p_jasa + $p_bunga + $p_lain2;

        $aset = $pengeluaran->where('jenis_pengeluaran', '=', 14)->sum('nominal');
        $peng_total = $pengeluaran->sum('nominal') - $aset;
        $labarugi = $pend_total - $peng_total;

        //dd($peng_total);
        $allItems = new Collection;
        $allItems = $allItems->merge($payment);
        $allItems = $allItems->merge($pengeluaran)->sortBy('tanggal');

        $setting = Setting::first();

        $bulan = strtoupper(config('custom.bulan.' .$bulan));
        $pdf = PDF::loadview('pdflaporan',
                            compact('pengeluaran','payment', 'tahun', 'bulan', 'lastdate', 'allItems', 'setting',
                                    'p_jasa', 'p_bunga', 'p_lain2', 'pend_total', 'peng_total', 'labarugi', 'aset'))
                    ->setPaper('a4', 'landscape');
        return $pdf->stream();
        // return view('rekaptagihans.cetakrekap', compact('invoices','lampirans','setting','arrayid','findtagihan'));
    }
    public function exportlaporan($filter, $filterbulan)
    {
        $tahun = $filter;
        $bulan = $filterbulan;
        $bulan = config('custom.bulan.' .$bulan);

        return Excel::download(new LaporanKeuanganExport($filter, $filterbulan), 'Laporan Keuangan '.$bulan.' '.$tahun.'.xlsx' );
    }
};
