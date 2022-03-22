<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Proyek;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyeks = Proyek::all();
        // dd($proyeks);
        return view('proyeks.index', compact('proyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role','>','20')->get();
        return view('proyeks.create', compact('users'));
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
            'user_id'=>'required',
            'website'=>'required',
            'jenis_proyek'=>'required',
            'jenis_layanan'=>'required',
            'tipe'=>'required',
            'masa_berlaku'=>'required',
            ]);

        $proyek = new Proyek([
            'user_id' => $request->get('user_id'),
            'website' => $request->get('website'),
            'jenis_proyek' => $request->get('jenis_proyek'),
            'jenis_layanan' => $request->get('jenis_layanan'),
            'tipe' => $request->get('tipe'),
            'masa_berlaku' => $request->get('masa_berlaku'),
            'keterangan' => $request->get('keterangan'),
            ]);
            $proyek->save();
            return redirect('/proyeks')->with('success', 'Proyek saved!');
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
        $proyek = Proyek::find($id);
        $users = User::where('role','>','20')->get();
        return view('proyeks.edit', compact(['proyek','users']));
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
        $request->validate([
            // 'nama'=>'required',
            // 'email'=>'required',
            // 'telp'=>'required',
            // 'username'=>'required',
            // 'role'=>'required'
            ]);

            $proyek = Proyek::find($id);
            $data = $request->except(['_token', '_method']);

            $proyek->update($data);

            return redirect('/proyeks')->with('success', 'Proyek updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyek = Proyek::find($id);
        $proyek->delete();

        return redirect('/proyeks')->with('success', 'Proyek deleted!');
    }
}
