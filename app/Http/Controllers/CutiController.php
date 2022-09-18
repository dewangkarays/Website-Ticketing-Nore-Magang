<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Cuti;
use App\Model\User;
use Auth;
use Dotenv\Regex\Success;

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
        //
    }

    public function update(Request $request, $id) {
        //
    }

    public function destroy($id) {
        $cuti = Cuti::find($id);
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

    //tampilan index menggunakan serverside datatables
}
