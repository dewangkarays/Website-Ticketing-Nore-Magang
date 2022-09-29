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
            $dates[] = $start->copy()->format('Y-m-d');
            $start->addDay();
        }
        // admin
        // $karyawans_all = Presensi::select('user_id')->distinct()->get();
        $karyawans_all = User::where('role', '<=' ,'50')->where('role', '!=', 1)->with(['presensi' => function ($q) {
            $q->orderBy('tanggal'); 
        }])
        ->get()->toArray();
        $presensi_all = Presensi::orderBy('tanggal')->get();
        $sakit_all = Presensi::where('status','3')->count();
        $izin_all = Presensi::where('status','2')->count();          
        // karyawan
        $presensi = Presensi::where('user_id', '166')->orderBy('tanggal')->get();
        // $test_all = User::where('role','<=','50')->with('presensi')->orderBy('tanggal')->get();
        // $test = User::where('id', \Auth::user()->id)->where(function ($q) {
        //     $q->select('*')
        //     ->from('presensi')
        //     ->orderBy('tanggal');
        // })
        // ->get();
        $karyawans = User::where('id', \Auth::user()->id)->with(['presensi' => function ($q) {
            $q->orderBy('tanggal'); 
        }])
        ->get()->toArray();
        $sakit = Presensi::where('user_id', \Auth::user()->id)->where('status','3')->count();
        $izin = Presensi::where('user_id', \Auth::user()->id)->where('status','2')->count();     

        $sisa_cuti = 12 - $izin;

        // foreach($presensi_all as $pres)
        // dd(count($karyawans_all));
        // dd(count($karyawans_all[0]['presensi']));
        return view("presensi.index",compact('dates','presensi','sakit','izin','sisa_cuti','karyawans','presensi_all','sakit_all','izin_all','karyawans_all'));
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
        $presensi = new Presensi();
        $presensi->tanggal = $request->get('tanggal');
        $presensi->status = $request->get('status');
        $presensi->user_id = $request->get('user_id');
        $check = Presensi::where('user_id',$request->get('user_id'))
        ->where('tanggal',$request->get('tanggal'))
        ->get();
        // dd(count($check));
        if(count($check) != 0) {
            return redirect('/presensi')->with('error', 'Presensi Sudah Diisi!');
        }
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
        //
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
}
