<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Presensi;
use Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $month = Carbon::now();
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $dates = [];
        while ($start->lte($end)) {
            $tanggal[] = $start->copy()->format('d'); // untuk tampilan
            $dates[] = $start->copy()->format('Y-m-d'); // untuk validasi dengan data
            $start->addDay();
        }
        // admin
        $karyawans_all = User::where('role', '<=' ,'50')->where('role', '!=', 1)->with(['presensi' => function ($q) {
            $q->orderBy('tanggal'); 
        }])
        ->get()->toArray();
        $presensi_all = Presensi::orderBy('tanggal')->get();
        $sakit_all = Presensi::where('status','3')->count();
        $izin_all = Presensi::where('status','2')->count();          
        $WFH_all = Presensi::where('status','4')->count();
        // karyawan
        $presensi = Presensi::where('user_id', '166')->orderBy('tanggal')->get();
        $karyawans = User::where('id', \Auth::user()->id)->with(['presensi' => function ($q) {
            $q->orderBy('tanggal'); 
        }])
        ->get()->toArray();
        // dd($dates);
        $sakit = Presensi::where('user_id', \Auth::user()->id)->where('status','3')->count();
        $izin = Presensi::where('user_id', \Auth::user()->id)->where('status','2')->count();     
        $WFH = Presensi::where('user_id', \Auth::user()->id)->where('status','4')->count(); 
       
        $sisa_cuti = 12 - $izin;

        $years = Presensi::selectRaw('year(tanggal) as tahun')->whereNotNull('status')->groupBy('tahun')->orderBy('tahun')->get();

        return view("presensi.index",compact('dates','tanggal','presensi','sakit','izin','sisa_cuti','karyawans','presensi_all','sakit_all','izin_all','karyawans_all','years','WFH',));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Auth::user()->role;
        if ($role == 1) {
            $users = User::where('role', '<', '80')
                ->orderBy('role')
                ->get();
        } else {
            $users = User::find(Auth::id());
        }

        return view("presensi.create", compact('users', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'tanggal'=>'required',
            'status'=>'required',
            'user_id'=>'required',
           
        ]);

        $check = Presensi::where('user_id',$request->get('user_id'))
        ->where('tanggal',$request->get('tanggal'))
        ->get();
        // dd(count($check));
        if(count($check) != 0) {
            return redirect('/presensi')->with('error', 'Presensi Sudah Diisi!');
        }

        $presensi = new Presensi();
        $presensi->tanggal = $request->get('tanggal');
        $presensi->status = $request->get('status');
        $presensi->user_id = $request->get('user_id');

        if ($presensi->status != 1) {
            $presensi->keterangan = $request->get('keterangan');

            $file = $request->file('bukti');
            $destinasi = config('app.upload_url').'attachment/bukti_ketidakhadiran';

            if ($file) {
                $nama = Auth::id()."_".time().".".$file->getClientOriginalName();
                $img = \Image::make($file->getRealPath());
                $img->save($destinasi.'/'.$nama);

                if ($img) {
                    $presensi->bukti = $destinasi.'/'.$nama;
                }
            }
        }

        // dd($file);

        $presensi->save();
        
        return redirect('/presensi')->with('success', 'Presensi Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $presensi = Presensi::find($id);
        return view('presensi.show', compact('presensi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function month($month)
    {
        $month = 10;
        return $month;
    }

    public function year($year)
    {
        $year = 2022;
        return $year;
    }

    public function getpresensi($tahun, $bulan, $id)
    {
        $check = User::find($id);

        $year = intval($tahun);
        $month = intval($bulan);
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        // dd($month);
        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy()->format('Y-m-d');
            $start->addDay();
        }

        if($check->role != 1){
        @$karyawans = User::where('id', $id)->with(['presensi' => function ($q) use ($month, $year) {
            $q->whereYear('tanggal','=',$year)->whereMonth('tanggal','=',$month)->orderBy('tanggal'); 
            // $q->orderBy('tanggal'); 
        }])
        ->get();
        return response()->json(@$karyawans);

    } else {
        @$karyawans = User::where('role','<=','50')->where('role','>=','10')->with(['presensi' => function ($q) use ($month, $year) {
            $q->whereYear('tanggal','=',$year)->whereMonth('tanggal','=',$month)->orderBy('tanggal'); 
            // $q->orderBy('tanggal'); 
        }])
        ->get();
          return response()->json(@$karyawans);
    }
    }

    public function gettotalizin($id)
    {
        // dd($id);
        $year = intval(substr($id, 0, 4));
        $izin = User::where('id', substr($id, 4))->with(['presensi' => function ($q) use ($year) {
            $q->whereYear('tanggal','=',$year)->where('status','=', 2); 
            // $q->orderBy('tanggal'); 
        }])
        ->get();
        // dd(count($sisa_cuti.['presensi']));
        return response()->json($izin);
    }
}
