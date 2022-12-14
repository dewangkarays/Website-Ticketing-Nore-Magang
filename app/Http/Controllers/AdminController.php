<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Task;
use App\Model\Tagihan;
use App\Model\Payment;
use App\Model\Proyek;
use App\Model\User;
use App\Model\Pengeluaran;
use App\Model\Cuti;
use App\Model\Presensi;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function __construct()
    {
    	//
    }

    public function index()
    {
        $new = Task::where('status', '=', '1')->get()->count();
        $ongoing = Task::where('status', '=', '2')->get()->count();
        $done = Task::where('status', '=', '3')->get()->count();
        $todaynew = Task::where('status', '=', '1')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        $todayongoing = Task::where('status', '=', '2')->whereDate('updated_at', '=', Carbon::today()->toDateString())->get()->count();
        $todaydone = Task::where('status', '=', '3')->whereDate('updated_at', '=', Carbon::today()->toDateString())->get()->count();
        $member = User::where('role','>','20')->get()->count();
        $proyek = Proyek::all();
        $simple = Proyek::where('tipe','=','99')->get()->count();
        $prioritas = Proyek::where('tipe','=','90')->get()->count();
        $premium = Proyek::where('tipe','=','80')->get()->count();
        $pengeluarans = Pengeluaran::all()->sum('nominal');
        $pendapatans = Payment::all()->sum('nominal');
        $memberthis = User::where('role','>','20')->whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->count();
        $memberlast = User::where('role','>','20')->whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->count();
        $proyekthis =  Proyek::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->count();
        $proyeklast =  Proyek::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->count();
        $pengeluaranthis = Pengeluaran::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->sum('nominal');
        $pengeluaranlast =  Pengeluaran::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->sum('nominal');
        $pendapatanthis = Payment::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->sum('nominal');
        $pendapatanlast =  Payment::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->sum('nominal');
        $karyawanhadir = Presensi::where('status', '1')->where('tanggal', date('Y-m-d'))->count();
        $karyawancutis = Cuti::where('status', '2')->where('tanggal_mulai', '<=', date('Y-m-d'))->where('tanggal_akhir', '>=', date('Y-m-d'))->get();
        $karyawanizin = Presensi::where('status', '2')->where('tanggal', date('Y-m-d'))->get();
        $karyawansakit = Presensi::where('status', '3')->where('tanggal', date('Y-m-d'))->get();
        $karyawanwfh = Presensi::where('status', '4')->where('tanggal', date('Y-m-d'))->get();
        $jumlahkaryawan = User::where('role', '<', '80')->where('role', '>', '1')->where('nonaktif', '=', '1')->count();
        $belumpresensi = $jumlahkaryawan - $karyawancutis->count() - $karyawanhadir - $karyawanizin->count() - $karyawansakit->count() - $karyawanwfh->count();

        // dd(date('Y-m-d') == '2022-10-17');
        return view("index", compact('new','ongoing','done','todaynew','todayongoing','todaydone','member','proyek','simple','prioritas','premium',
        'pengeluarans','pendapatans','memberlast','memberthis','proyekthis','proyeklast','pengeluaranthis','pengeluaranlast','pendapatanthis','pendapatanlast',
        'karyawanhadir', 'karyawancutis', 'karyawanizin', 'karyawansakit', 'karyawanwfh', 'belumpresensi'));
    }

    public function karyawan()
    {
        $new = Task::where('status', '=', '1')->get()->count();
        $ongoing = Task::where('status', '=', '2')->get()->count();
        $done = Task::where('status', '=', '3')->get()->count();
        $todaynew = Task::where('status', '=', '1')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        $todayongoing = Task::where('status', '=', '2')->whereDate('updated_at', '=', Carbon::today()->toDateString())->get()->count();
        $todaydone = Task::where('status', '=', '3')->whereDate('updated_at', '=', Carbon::today()->toDateString())->get()->count();
        $member = User::where('role','>','20')->get()->count();
        $proyek = Proyek::all();
        $simple = Proyek::where('tipe','=','99')->get()->count();
        $prioritas = Proyek::where('tipe','=','90')->get()->count();
        $premium = Proyek::where('tipe','=','80')->get()->count();
        $memberthis = User::where('role','>','20')->whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->count();
        $memberlast = User::where('role','>','20')->whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->count();
        $proyekthis =  Proyek::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->count();
        $proyeklast =  Proyek::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->count();
        $karyawanhadir = Presensi::where('status', '1')->where('tanggal', date('Y-m-d'))->count();
        $karyawancutis = Cuti::where('status', '2')->where('tanggal_mulai', '<=', date('Y-m-d'))->where('tanggal_akhir', '>=', date('Y-m-d'))->get();
        $karyawanizin = Presensi::where('status', '2')->where('tanggal', date('Y-m-d'))->get();
        $karyawansakit = Presensi::where('status', '3')->where('tanggal', date('Y-m-d'))->get();
        $karyawanwfh = Presensi::where('status', '4')->where('tanggal', date('Y-m-d'))->get();
        $jumlahkaryawan = User::where('role', '<', '80')->where('role', '>', '1')->count();
        $belumpresensi = $jumlahkaryawan - $karyawancutis->count() - $karyawanhadir - $karyawanizin->count() - $karyawansakit->count() - $karyawanwfh->count();
        $karyawanabsensi= Presensi::where('user_id', \Auth::id())->where('tanggal', date('Y-m-d'))->count();
        $cuti = Cuti::where('user_id',\Auth::user()->id)
        ->where('tanggal_mulai','<=',date('Y-m-d'))
        ->where('tanggal_akhir','>=',date('Y-m-d'))
        ->get();
        // dd($cuti);
    
return view("index", compact('new','ongoing','done','todaynew','todayongoing','todaydone','member','proyek','simple','prioritas','premium',
        'memberlast','memberthis','proyekthis','proyeklast', 'karyawanhadir', 'karyawancutis', 'karyawanizin', 'karyawansakit', 'karyawanwfh', 'belumpresensi','karyawanabsensi','cuti'));
    }

    public function keuangan()
    {
        $new = Task::where('status', '=', '1')->get()->count();
        $ongoing = Task::where('status', '=', '2')->get()->count();
        $done = Task::where('status', '=', '3')->get()->count();
        $todaynew = Task::where('status', '=', '1')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        $todayongoing = Task::where('status', '=', '2')->whereDate('updated_at', '=', Carbon::today()->toDateString())->get()->count();
        $todaydone = Task::where('status', '=', '3')->whereDate('updated_at', '=', Carbon::today()->toDateString())->get()->count();
        $member = User::where('role','>','20')->get()->count();
        $proyek = Proyek::all();
        $simple = Proyek::where('tipe','=','99')->get()->count();
        $prioritas = Proyek::where('tipe','=','90')->get()->count();
        $premium = Proyek::where('tipe','=','80')->get()->count();
        $memberthis = User::whereYear('created_at','=',Carbon::now()->today()->year)->where('role','>','20')->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->count();
        $memberlast = User::whereYear('created_at','=',Carbon::now()->today()->year)->where('role','>','20')->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->count();
        $proyekthis =  Proyek::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->today()->month)->get()->count();
        $proyeklast =  Proyek::whereYear('created_at','=',Carbon::now()->today()->year)->whereMonth('created_at','=',Carbon::now()->subMonth()->month)->get()->count();
        $karyawanhadir = Presensi::where('status', '1')->where('tanggal', date('Y-m-d'))->count();
        $karyawancutis = Cuti::where('status', '2')->where('tanggal_mulai', '<=', date('Y-m-d'))->where('tanggal_akhir', '>=', date('Y-m-d'))->get();
        $karyawanizin = Presensi::where('status', '2')->where('tanggal', date('Y-m-d'))->get();
        $karyawansakit = Presensi::where('status', '3')->where('tanggal', date('Y-m-d'))->get();
        $karyawanwfh = Presensi::where('status', '4')->where('tanggal', date('Y-m-d'))->get();
        $jumlahkaryawan = User::where('role', '<', '80')->where('role', '>', '1')->count();
        $belumpresensi = $jumlahkaryawan - $karyawancutis->count() - $karyawanhadir - $karyawanizin->count() - $karyawansakit->count() - $karyawanwfh->count();
        $karyawanabsensi= Presensi::where('user_id', \Auth::id())->where('tanggal', date('Y-m-d'))->count();
        $cuti = Cuti::where('user_id',\Auth::user()->id)
        ->where('tanggal_mulai','<=',date('Y-m-d'))
        ->where('tanggal_akhir','>=',date('Y-m-d'))
        ->get();
       
        return view("index", compact('new','ongoing','done','todaynew','todayongoing','todaydone','member','proyek','simple','prioritas','premium',
        'memberlast','memberthis','proyekthis','proyeklast', 'karyawanhadir', 'karyawancutis', 'karyawanizin', 'karyawansakit', 'karyawanwfh', 'belumpresensi','karyawanabsensi','cuti'));
    }

    // public function customer()
    // {
    //     $new = Task::where('status', '=', '1')->where('user_id',\Auth::user()->id)->get()->count();
    //     $ongoing = Task::where('status', '=', '2')->where('user_id',\Auth::user()->id)->get()->count();
    //     $done = Task::where('status', '=', '3')->where('user_id',\Auth::user()->id)->get()->count();
    //     $tagihan = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get();
    //     $totalbayar = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->sum('jml_bayar');
    //     $lastpayment = Payment::where('user_id',\Auth::user()->id)->where('status',1)->orderBy('tgl_bayar','desc')->get()->first();
    //     dd($tagihan);
    //     return view("index", compact('new','ongoing','done','tagihan','lastpayment','totalbayar'));
    // }

    //test view costumer()
    public function customer(){
        
        $new = Task::where('status', '=', '1')->where('user_id',\Auth::user()->id)->get()->count();
        $ongoing = Task::where('status', '=', '2')->where('user_id',\Auth::user()->id)->get()->count();
        $done = Task::where('user_id',\Auth::user()->id)->where('status', '=', '3')->get()->count();
        $website = Proyek::where('user_id',\Auth::user()->id)->get()->count();
        $taskall = User::where('id',\Auth::user()->id)->value('task_count');
        $tagihans = Tagihan::where('user_id',\Auth::user()->id)->orderBy('created_at')->orderBy('status','desc')->get();
        $proyeks = Proyek::where('user_id',\Auth::user()->id)->orderBy('masa_berlaku','asc')->get();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskcounts = Task::where('user_id',\Auth::user()->id)->get()->count();
        $tasks = Task::where('user_id',\Auth::user()->id)->get();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $tagihanhistories = Tagihan::where('user_id',\Auth::user()->id)->where('status','=','2')->get();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $user = User::where('id',\Auth::user()->id)->first();
        // dd($user);
        return view("client.layout",compact('new','ongoing','done','website','taskall','proyeks','tagihans','taskcounts','tasks','tagihanactives','tagihanhistories','taskactives','highproyek','user'));
    }

    // public function customer()
    // {
    //     $new = Task::where('status', '=', '1')->where('user_id',\Auth::user()->id)->get()->count();
    //     $ongoing = Task::where('status', '=', '2')->where('user_id',\Auth::user()->id)->get()->count();
    //     $done = Task::where('status', '=', '3')->where('user_id',\Auth::user()->id)->get()->count();
    //     return view("client.layout", compact('new','ongoing','done'));
    // }
        
    
}
