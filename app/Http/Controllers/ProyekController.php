<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Proyek;
use Illuminate\Support\Facades\Validator;

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

        $data = $request->except(['_token', '_method']);

        if($request->get('tipe_web')!=''){
            $data['tipe'] = $request->get('tipe_web');
        }
        if($request->get('tipe_app')!=''){
            $data['tipe'] = $request->get('tipe_app');
        }
        if($request->get('jl_web')!=''){
            $data['jenis_layanan'] = $request->get('jl_web');
        }
        if($request->get('jl_app')!=''){
            $data['jenis_layanan'] = $request->get('jl_app');
        }

        $proyek = new Proyek($data);
        $proyek->save();

        $user = User::find($proyek->user_id);
        $user->task_count = $user->proyek->sum('task_count');
        $user->save();

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
        $proyek = Proyek::find($id);
        $data = $request->except(['_token', '_method']);

        if($request->get('tipe_web')!=''){
            $data['tipe'] = $request->get('tipe_web');
        }
        if($request->get('tipe_app')!=''){
            $data['tipe'] = $request->get('tipe_app');
        }
        if($request->get('jl_web')!=''){
            $data['jenis_layanan'] = $request->get('jl_web');
        }
        if($request->get('jl_app')!=''){
            $data['jenis_layanan'] = $request->get('jl_app');
        }
        if($request->get('new_mb')!=''){
            $data['masa_berlaku'] = $request->get('new_mb');
        }

        $proyek->update($data);

        $user = User::find($proyek->user_id);
        $user->task_count = $user->proyek->sum('task_count');
        $user->save();

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
