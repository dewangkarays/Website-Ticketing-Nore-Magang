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
        $karyawans = User::where('role','=','70')->get(); //ganti role = 10 jika tanpa dummy data
        // dd($karyawan);
        return view('cuti.create', compact('users','karyawans'));
    }

    public function store(Request $request) {
        // dd($request);
        $cuti = new Cuti();
        $verifikator2 = $request->get('verifikator_2');
        $verifikator1 = $request->get('verifikator_1');
        $nama_verif2 = User::where('id','=',$verifikator2)->first();
        $nama_verif1 = User::where('id','=',$verifikator1)->first();
        $cuti->status = 1;
        if ($request->get('tanggal_mulai') == $request->get('tanggal_akhir')) {
            return redirect()->back()->with('error', 'Tanggal Tidak Boleh Sama!');
        }
        $cuti->tanggal_mulai = $request->get('tanggal_mulai');
        $cuti->tanggal_akhir = $request->get('tanggal_akhir');
        $cuti->alasan = $request->get('alasan');
        $cuti->verifikator_2 = $nama_verif2->nama;
        $cuti->verifikator_1 = $nama_verif1->nama;
        $cuti->verifikator_2_id = $verifikator2;
        $cuti->verifikator_1_id = $verifikator1;
        if (\Auth::user()->id == 1){
        $cuti->user_id = $request->get('name');
        } else {
        $cuti->user_id = \Auth::user()->id;          
        }

        // dd($cuti);
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
        $verifikator1 = User::where('id', '=', $cuti->verifikator_1_id)->first();
        $verifikator2 = User::where('id', '=', $cuti->verifikator_2_id)->first();
        return view('cuti.edit', compact('cuti','verifikator1','verifikator2'));
    }

    public function update(Request $request, $id) {
        // dd($request);
        $cuti = Cuti::find($id);
        $cuti->status = 1;
        if ($request->get('tanggal_mulai') == $request->get('tanggal_akhir')) {
            return redirect()->back()->with('error', 'Tanggal Tidak Boleh Sama!');
        }
        $cuti->tanggal_mulai = $request->get('tanggal_mulai');
        $cuti->tanggal_akhir = $request->get('tanggal_akhir');
        $cuti->alasan = $request->get('alasan');
        $verifikator2 = $request->get('verifikator_2');
        $verifikator1 = $request->get('verifikator_1');
        if ($verifikator2 != null) {
            $nama_verif2 = User::where('id','=',$verifikator2)->first();
            $cuti->verifikator_2 = $nama_verif2->nama;$cuti->verifikator_2_id = $verifikator2;
        }
        if ( $verifikator1 != null){
            $nama_verif1 = User::where('id','=',$verifikator1)->first();
            $cuti->verifikator_1 = $nama_verif1->nama;$cuti->verifikator_1_id = $verifikator1;
        }
        // if ($request->get('verifikator_2') == null && $request->get('verifikator_1') == null) {
            if ($verifikator2 == $cuti->verifikator_1_id || $verifikator1 == $cuti->verifikator_2_id) {
            return redirect()->back()->with('error', 'Verifikator Tidak Boleh Sama!');
            }

        // }
        // dd($verifikator1);   
        
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

    public function getverifikator($id)
    {
        $verifs = User::where('role','=','70')->get(); //ganti role = 10 jika tanpa dummy data
        if ($id != 0) {
            $user = User::find($id);
            $atasan_id = $user->atasan_id;
            $data = [];
            $j = 0;
            $len = $verifs->count();
            for($i = 0; $i<$len;$i++){
                foreach ($verifs as $verif){
                    if ($atasan_id == $verif->id) {
                        $data[$j] = $verif;
                        $atasan_id = $verif->atasan_id;
                        $j++;
                    }
                }    
            };      
            // dd($len);
            return response()->json($data);
        } else {
            return response()->json($verifs);
        }
        
    }

    public function invalid($id) {
        $cuti = Cuti::find($id);
        $cuti->status = 4;
        $cuti->update();
        return redirect()->route('cuti');
    }

    //tampilan index menggunakan serverside datatables
    public function getcuti($status) {
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
        return Datatables::of($cuti)->addIndexColumn()->make(true);
    }

    public function cetaksuratcuti($id) {
        $cuti = Cuti::find($id);
        $setting = Setting::first();
        $pdf = PDF::loadView('cuti.cetaksuratcuti', compact('cuti', 'setting'));
        return $pdf->stream();
    }
}
