<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Collection;

use App\Model\Cuti;
use App\Model\User;
use Carbon\Carbon;
use Auth;
use Dotenv\Regex\Success;
use Datatables;


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
        $cuti->status = 1;
        $cuti->tanggal_mulai = $request->get('tanggal_mulai');
        $cuti->tanggal_akhir = $request->get('tanggal_akhir');
        $cuti->alasan = $request->get('alasan');
        // $cuti->verifikator_2 = 2;
        // $cuti->verifikator_1 = 1;
        $cuti->verifikator_2 = $request->get('verifikator_2');
        $cuti->verifikator_1 = $request->get('verifikator_1');
        $cuti->user_id = \Auth::user()->id; 

        // dd($cuti);
        
        $cuti->save();
        
        return redirect('/cuti')->with('success', 'Task Saved!');
    }

    public function show($id) {
        $cuti = Cuti::find($id);
        return view('cuti.show', compact('cuti'));
    }

    public function edit($id) {
        $cuti = Cuti::find($id);
        return view('cuti.edit', compact('cuti'));
    }

    public function update(Request $request, $id) {
        //
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
        // $user = User::find($id);
        // $atasan_id = $user->atasan_id;
        // $i = 0;
        // $data = "";
        // for($i = $id; $i == null;){
        $verifs['data'] = User::where('role','=','70')->orderBy('atasan_id','desc')->get();
        // foreach ($verifs as $verif)
        // {
        //   $test = $verif->where('id','=',$atasan_id)->get();
        //   break;
        //   $atasan_id = $test->get('atasan_id');
        //   $data = $test->get();
        //   $i++;
        //   continue;
        // }
        // dd($data);
            // $i = $verif['atasan_id'];
        // }
        
        // dd($i);
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
}
