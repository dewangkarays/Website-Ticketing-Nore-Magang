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
            $dates[] = $start->copy()->format('d-m-Y');
            $start->addDay();
        }
        // admin
        $karyawans = Presensi::select('user_id')->distinct()->get();
        $presensi_all = Presensi::all();
        $sakit_all = Presensi::where('status','3')->count();
        $izin_all = Presensi::where('status','2')->count();          
        // karyawan
        $presensi = Presensi::where('user_id', \Auth::user()->id)->get();
        $sakit = Presensi::where('user_id', \Auth::user()->id)->where('status','3')->count();
        $izin = Presensi::where('user_id', \Auth::user()->id)->where('status','2')->count();     

        $sisa_cuti = 12 - $izin;

        // dd($karyawans);
        return view("presensi.index",compact('dates','presensi','sakit','izin','sisa_cuti','karyawans','presensi_all','sakit_all','izin_all'));
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
