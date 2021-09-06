<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        // $request->validate([
        //     'nama'=>'required',
        //     'email'=>'required|unique:users',
        //     'telp'=>'required|numeric|min:11|max:13',
        //     'username'=>'required|unique:users',
        //     'password'=>'required',
        //     ],
        //     [
        //     'email.unique'=>':attribute tidak boleh sama',
        //     'username.unique'=>':attribute tidak boleh sama',
        //     'telp.numeric'=>':attribute harus angka',
        //     'telp.min'=>':attribute jumlah minimal 11 angka',
        //     'telp.max'=>':attribute jumlah maksimal 13 angka',
        //     ]
        // );

            $validator = Validator::make($request->all(), [
                'username'=>'unique:users',
                'email'=>'unique:users'
            ]);

            if ($validator->fails()) {
                return redirect('members/create')
                            ->withErrors($validator)
                            ->withInput();
            }
            
            $user = new User([
                'nama' => $request->get('name'),
                'email' => $request->get('email'),
                'telp' => $request->get('phone'),
                'alamat' => $request->get('address'),
                'task_count' => $request->get('taskcount'),
                'username' => $request->get('username'),
                'password' => bcrypt($request->get('password')),
                'role' => $request->get('role')
                ]);

            $user->save();
            return redirect('/members')->with('success', 'User saved!');
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
            
            if($request->get('password')!=''){
                $data['password'] = bcrypt($request->get('password'));
            }

            $data = $request->except(['_token', '_method','password']);

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
