<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Cuti;
use App\Model\User;
use Auth;

class CutiController extends Controller
{
    public function index() {
        //tampilan index menggunakan serverside datatables
        return view('cuti.index');
    }

    public function create() {
        $users = User::where('id', '=', \Auth::user()->id)->get() ;
        // dd($nip);
        return view('cuti.create', compact('users'));
    }

    public function store(Request $request) {
        // dd($request);
        return view('cuti.create');
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

    //tampilan index menggunakan serverside datatables
}
