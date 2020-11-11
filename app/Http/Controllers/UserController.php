<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\User;

class UserController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $users = User::where('role','<=','20')->get();
        return view('users.index', compact('users'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('users.create');
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
        $request->validate([
            'nama'=>'required',
            'email'=>'required',
            'telp'=>'required',
            'username'=>'required',
            'password'=>'required',
            'role'=>'required'
            ]);
            
            $user = new User([
                'nama' => $request->get('nama'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'telp' => $request->get('telp'),
                'alamat' => $request->get('alamat'),
                'website' => $request->get('website'),
                'kadaluarsa' => $request->get('kadaluarsa'),
                'password' => bcrypt($request->get('password')),
                'role' => $request->get('role'),
                'task_count' => $request->get('task_count'),
                ]);
                $user->save();
                return redirect('/members')->with('success', 'Member saved!');
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
                
                if ($user->role == '1') {
                    $roleuser = 'Super-Admin';
                } elseif ($user->role == '10') {
                    $roleuser = 'Karyawan';
                }elseif($user->role=='20'){
                    $roleuser = 'Keuangan';
                } elseif ($user->role == '80') {
                    $roleuser = 'Premium';
                }elseif ($user->role == '90') {
                    $roleuser = 'Prioritas';
                }elseif ($user->role == '99') {
                    $roleuser = 'Simpel';
                }

                return view('users.show', compact('user','roleuser'));
            }
            
            /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function edit($id)
            {
                $user = User::find($id);
                return view('users.edit', compact('user')); 
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
                    
                    $user = User::find($id);
                    $data = $request->except(['_token', '_method', 'password']);
                    
                    if($request->get('password')!=''){
                        $data['password'] = bcrypt($request->get('password'));
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
                            
                            return redirect('/changepass')->with('success', 'Password updated!');
                        } else {
                            return redirect('/changepass')->with('error', 'Password lama salah');
                        }
                    }
                }
                