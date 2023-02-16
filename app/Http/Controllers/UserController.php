<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Tagihan;
use App\Model\Proyek;
use Datatables;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // $users = User::where('role','<=','20')->get();
        return view('users.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $atasans = User::where('role','<=','50')->get();
        // dd($atasan);
        return view('users.create', compact('atasans'));
    }

    public function createmember()
    {
        return view('users.createmember');
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
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|unique:posts|max:255',
            // 'body' => 'required',
            'atasan_id' => 'required',
            'username'=>'unique:users',
            'email'=>'unique:users'
        ]);

        if ($validator->fails()) {
            return redirect('users/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = new User([
            'nama' => $request->get('name'),
            'nip' => $request->get('nip'),
            'jabatan' => $request->get('jabatan'),
            'email' => $request->get('email'),
            'tanggal_lahir' => $request->get('tanggal_lahir'),
            'telp' => $request->get('phone'),
            'alamat' => $request->get('address'),
            'username' => $request->get('username'),
            'password' => bcrypt($request->get('password')),
            'role' => $request->get('role'),
            'atasan_id' => $request->get('atasan_id'),
            'jatah_cuti' => 12,
            'sisa_cuti' => 12,
        ]);

        $user->save();
        return redirect('/users')->with('success', 'Member saved!');
    }


    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $user = User::find($id);

        // if ($user->role == '1') {
        //     $roleuser = 'Super-Admin';
        // } elseif ($user->role == '10') {
        //     $roleuser = 'Karyawan';
        // }elseif($user->role=='20'){
        //     $roleuser = 'Keuangan';
        // } elseif ($user->role == '80') {
        //     $roleuser = 'Premium';
        // }elseif ($user->role == '90') {
        //     $roleuser = 'Prioritas';
        // }elseif ($user->role == '99') {
        //     $roleuser = 'Simpel';
        // }

        return view('users.show', compact('user'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $atasans = User::where('role','<=','50')->get();
        $user = User::find($id);
        $def_atasan = User::where( 'id', '=',$user->atasan_id)->first();
        return view('users.edit', compact('user','atasans','def_atasan'));
    }

    public function setting($id){
        // $user = User::find($id);
        // return view('client.setting.setting', compact('user'));
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        // return view('client.setting.setting',compact('user','tagihanactives'));
        return view('client.setting.setting',compact('tagihanactives','highproyek','id'));
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
            'nama'=>'required',
            'email'=>'required',
            'tanggal_lahir'=>'required',
            'telp'=>'required',
            'username'=>'required',
            'role'=>'required'
            ]);

        $user = User::find($id);
        $data = $request->except(['_token', '_method', 'password']);

        //Mencegah user memasukan username yang sama dengan user lain
        if($request->username != $user->username) {
            $request->validate([
                'username' => 'unique:users',
            ]);
        }

        if($request->get('password')!=''){
            $data['password'] = bcrypt($request->get('password'));
        }
        if ($request->get('atasan_id')==null){
            $data['atasan_id'] = $user->atasan_id;
        }

        if ($data['sisa_cuti'] > $data['jatah_cuti']) {

            return redirect()->back()->with('error', 'Sisa cuti melebihi jatah cuti!');
        }

        $user->update($data);

        return redirect('/users')->with('success', 'User updated!');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect('/users')->with('success', 'User deleted!');
    }

    public function changePass()
    {
        return view('changepass');
    }

    public function changePassSubmit(Request $request, $id)
    {
        $request->validate([
            'old_pass'=>'required',
            'new_pass'=>'required',
            'con_pass'=>'required',
        ]);

        $user = User::find($id);
        if($request->get('new_pass') != $request->get('con_pass')){
            return redirect('/changepass')->with('error', 'Password baru tidak sama dengan konfirmasi password');
        }

        if(Hash::check($request->get('old_pass'), $user->password)){
            $user->password = bcrypt($request->get('new_pass'));
            $user->save();

        if($user->role==1)
        {
            return redirect('/admin')->with('success', 'Password updated!');
        }
        if($user->role<=50)
        {
            return redirect('/karyawan')->with('success', 'Password updated!');
        }
        
        } else {
            return redirect('/changepass')->with('error', 'Password lama salah');
        }
    }

    public function getkaryawans() {
        return Datatables::of(User::where('role', '<=', '50')->get())->addIndexColumn()->make(true);
    }

    public function updateDiscordId(Request $request, $id) {
        $request->validate([
            'discord_id'=>'required',
        ]);

        $user = User::find($id)->update(['discord_id' => $request->discord_id]);

        if(!$user) {
            return redirect('/presensi')->with('error', 'Terjadi kesalahan');
        }

        return redirect('/presensi')->with('success', 'Discord ID berhasil disimpan');
    }

    public function UpdateUser($id)
    {  
           
         $user = User::find($id);
         $user->update([
            'nonaktif'=>0
         ]);
       
         return redirect('/users')->with('success', 'User dinonaktifan!');
    }
    public function UserAktif($id)
    {  
           
         $user = User::find($id);
         $user->update([
            'nonaktif'=>1
         ]);
       
         return redirect('/users')->with('success', 'User diaktifan!');
    }
}
