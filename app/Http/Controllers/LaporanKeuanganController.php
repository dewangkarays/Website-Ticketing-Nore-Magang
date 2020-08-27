<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Pengeluaran;
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
        
        $chart = array();
        $chart2 = array();
        $neto = array();
        $pie = array();
        $pie2 = array();
        // $chart[80] = $chart[90] = $chart[99] = array_fill(1, 12, 0);
        $chart[0] = array_fill(1, 12, 0);
        $chart2[0] = array_fill(1, 12, 0);
        $br[0] = array_fill(1,12,0);
        $pg[0] = array_fill(1,12,0);
        $neto[0] = array_fill(1, 12, 0);
        $pie[80] = $pie[90] = $pie[99] = 0;
        $pie2[0] = $pie2[1] = $pie2[2] = $pie2[3]= $pie2[4]= $pie2[5] = 0;
        
        // $years = Payment::selectRaw('year(tgl_bayar) as tahun')->where('status','1')->groupBy('tahun')->orderBy('tahun','DESC')->get();
        // $years = date('Y');
        // dd($years);
        
        // pemasukan bruto
        // $qry = Payment::selectRaw('month(tgl_bayar) as bulan, user_role, sum(nominal) as total ')->where('status','1')->whereYear('tgl_bayar',$filter)->groupBy('bulan', 'user_role')->get()->toArray();
        $qry = Payment::selectRaw('month(tgl_bayar) as bulan, user_role, sum(nominal) as total ')->whereYear('tgl_bayar',$filter)->groupBy('bulan', 'user_role')->get()->toArray();
        
        // pengeluaran
        $qry2 = Pengeluaran::selectRaw('month(tanggal) as bulan, jenis_pengeluaran, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('bulan', 'jenis_pengeluaran')->get()->toArray();
        
        // pemasukan neto
        $qry3 = Payment::selectRaw('month(tgl_bayar) as bulan, sum(nominal) as total ')->whereYear('tgl_bayar',$filter)->groupBy('bulan')->get()->toArray();
        
        $qry4 = Pengeluaran::selectRaw('month(tanggal) as bulan, sum(nominal) as total ')->whereYear('tanggal',$filter)->groupBy('bulan')->get()->toArray();
        
        
        foreach ($qry as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chart[0][$val['bulan']] += $val['total'];
            
            $pie[$val['user_role']] += $val['total'];
            
        }
        
        foreach ($qry2 as $val2) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chart2[0][$val2['bulan']] += $val2['total'];
            
            $pie2[$val2['jenis_pengeluaran']] += $val2['total'];
            
        }
        
        
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
        
        $clients = Payment::select('*')->orderBy('tgl_bayar','DESC')->offset(0)->limit(8)->get();
        $totals = Payment::selectRaw('user_id, SUM(nominal) as total')->groupBy('user_id')->orderBy('total','DESC')->get();
        
        return view('laporankeuangan', compact('chart', 'chart2', 'neto', 'pie', 'pie2', 'clients', 'filter','totals'));
    }
}
