<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Task;
use App\Model\Tagihan;
use App\Model\Proyek;

class SettingClient extends Controller
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

    public function changesetting(){

        $user = User::where('id',\Auth::user()->id)->first();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        
        return view ('client.setting.setting',compact('user','highproyek','taskactives','tagihanactives'));
    }

    public function changesettingupdate(Request $request, $id){
        $user = User::find($id);

        $user->nama = $request->input('nama');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->telp = $request->input('telp');
        $user->alamat = $request->input('alamat');

        $data_image = User::where('id',\Auth::user()->id)->first();

        $tujuan_upload = config('app.upload_url').'global_assets/images';

        if($request->hasFile('image')){
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $file_name = \Auth::user()->id."_".time().'.'.$ext;
                $up1 = $file->move($tujuan_upload,$file_name);
                if($up1){
                    $user->image = $tujuan_upload.'/'.$file_name;
                }
        }
        else{
            $user->image = $data_image->image;
        }


        if($request->get('password')!=''){
            $user->password = bcrypt(($request->input('password')));
        }

        $user->save();

        return redirect('/customer')->with('success','Data berhasil diupdate');
    }
}
