<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\User;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('role','>','20')->get();
        return view('members.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
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
            'nama'=>'required',
            'email'=>'required|unique:users',
            'telp'=>'required',
            'username'=>'required|unique:users',
            'password'=>'required',
        ],
            [
                'email.unique'=>':attribute tidak boleh sama',
                'username.unique'=>':attribute tidak boleh sama'
            ]
        );
            
            $user = new User([
                'nama' => $request->get('nama'),
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'telp' => $request->get('telp'),
                'password' => bcrypt($request->get('password')),
                'task_count' => $request->get('task_count'),
                ]);
                $user->save();
                return redirect('/users')->with('success', 'User saved!');
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
                }elseif ($user->role == '95') {
                    $roleuser = 'Klien';
                }elseif ($user->role == '99') {
                    $roleuser = 'Simpel';
                }

                return view('members.show', compact('user','roleuser'));
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
        return view('members.edit', compact('user')); 
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
            
            return redirect('/members')->with('success', 'Member updated!');
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
        
        return redirect('/members')->with('success', 'Member deleted!');
    }
}
