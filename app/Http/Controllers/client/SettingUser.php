<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Task;
use App\Model\Tagihan;
use App\Model\Proyek;

class SettingUser extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function changesetting(){

        $user = User::where('id',\Auth::user()->id)->first();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        
        return view ('client.setting.setting',compact('user','highproyek','taskactives','tagihanactives'));
    }

    public function changesettingupdate(Request $request, $id){
        $user = User::find($id);

        $user->nama = e($request->input('nama'));
        $user->username = e($request->input('username'));
        $user->email = e($request->input('email'));
        $user->telp = e($request->input('telp'));
        $user->alamat = e($request->input('alamat'));
        $user->password = bcrypt(e($request->input('password')));
        $user->image = e($request->file('image'));

        $user->save();

        return redirect('/customer');
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
