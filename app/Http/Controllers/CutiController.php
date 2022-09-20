<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Collection;

use App\Model\Cuti;
use App\Model\User;
use Carbon\Carbon;
use App\Model\Setting;
use Auth;
use Dotenv\Regex\Success;
use Datatables;
use PDF;


class CutiController extends Controller
{
    public function index() {
        //tampilan index menggunakan serverside datatables
        return view('cuti.index');
    }

    public function create() {
        $users = User::where('id', '=', \Auth::user()->id)->get();
        // dd($nip);
        return view('cuti.create', compact('users'));
    }

    public function store(Request $request) {
        // dd($request);
        $cuti = new Cuti();
        $verifikator2 = $request->get('verifikator_2');
        $verifikator1 = $request->get('verifikator_1');
        $nama_verif2 = User::where('id','=',$verifikator2)->first();
        $nama_verif1 = User::where('id','=',$verifikator1)->first();
        $cuti->status = 1;
        $cuti->tanggal_mulai = $request->get('tanggal_mulai');
        $cuti->tanggal_akhir = $request->get('tanggal_akhir');
        $cuti->alasan = $request->get('alasan');
        $cuti->verifikator_2 = $nama_verif2->nama;
        $cuti->verifikator_1 = $nama_verif1->nama;
        $cuti->verifikator_2_id = $verifikator2;
        $cuti->verifikator_1_id = $verifikator1;
        $cuti->user_id = \Auth::user()->id; 

        // dd($cuti);
        
        $cuti->save();
        
        return redirect('/cuti')->with('success', 'Cuti Saved!');
    }

    public function show($id) {
        $cuti = Cuti::find($id);
        return view('cuti.show', compact('cuti'));
    }

    public function edit($id) {
        $cuti = Cuti::find($id);
        $verifikator1 = User::where('id', '=', $cuti->verifikator_1)->first();
        $verifikator2 = User::where('id', '=', $cuti->verifikator_2)->first();
        return view('cuti.edit', compact('cuti','verifikator1','verifikator2'));
    }

    public function update(Request $request, $id) {
        // dd($data);
        $cuti = Cuti::find($id);
        $cuti->status = 1;
        $cuti->tanggal_mulai = $request->get('tanggal_mulai');
        $cuti->tanggal_akhir = $request->get('tanggal_akhir');
        $cuti->alasan = $request->get('alasan');
        if ($request->get('verifikator_2') != null) {
            $cuti->verifikator_2 = $request->get('verifikator_2');
        }
        if ($request->get('verifikator_1') != null){
            $cuti->verifikator_1 = $request->get('verifikator_1');
        }
        // if ($request->get('verifikator_2') == $cuti->verifikator_1 || $request->get('verifikator_1') == $cuti->verifikator_2) {
        //     return redirect()->back()->with('error', 'Verifikator Tidak Boleh Sama!');
        // }
        
        $cuti->update();
        return redirect('/cuti')->with('success', 'Cuti Updated');
    }

    public function historycuti() {
        return view('cuti.history');
    }

    public function destroy($id) {
        $cuti = Cuti::find($id);
        // dd($cuti);
        $cuti->delete();
        return redirect()->route('cuti');
    }

    public function getverifikator()
    {
        $verifs['data'] = User::where('role','=','70')->orderBy('atasan_id','desc')->get();
        return response()->json($verifs);
    }

    public function invalid($id) {
        $cuti = Cuti::find($id);
        $cuti->status = 4;
        $cuti->update();
        return redirect()->route('cuti');
    }

    //tampilan index menggunakan serverside datatables
    public function getcuti($status) {
        $currentUserId = Auth::id();
        $today = Carbon::today();
        if ($status == 'aktif') {
            $cuti = Cuti::where('status', '<', '3')
                ->where('tanggal_akhir', '>=', $today)
                ->with('karyawan')
                ->get();
        } else if ($status == 'history') {
            $cuti = Cuti::where(function($q) use ($today) {
                $q->where('status', '>', '2')
                    ->orWhere('tanggal_akhir', '<', $today);
                })
                ->with('karyawan')
                ->get();
        }
        return Datatables::of($cuti)
            ->addIndexColumn()
            ->addColumn('currentUserId', $currentUserId)
            ->make(true);
    }

    public function cetaksuratcuti($id) {
        $cuti = Cuti::find($id);
        $setting = Setting::first();
        $pdf = PDF::loadView('cuti.cetaksuratcuti', compact('cuti', 'setting'));
        return $pdf->stream();
    }
}
