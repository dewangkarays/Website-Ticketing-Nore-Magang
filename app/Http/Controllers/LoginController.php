<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
    	//
    }

    public function index()
    {
    	return view("login");
    }

    public function login(Request $request){
	    $this->validate($request, [
	        'username' => 'required',
	        'password' => 'required',
	        ]);
	    if (\Auth::attempt([
	        'username' => $request->username,
	        'password' => $request->password])
	    ){
	    	if(\Auth::user()->role==1){
	    		return redirect('/admin');
	    	}elseif(\Auth::user()->role==99){
	    		return redirect('/member');
	    	} else {
	    		return redirect('/login')->with('error', 'Invalid Email address or Password');
	    	}
	        
	    }
	    return redirect('/login')->with('error', 'Invalid Email address or Password');
	}
	/* GET
	*/
	public function logout(Request $request)
	{
	    if(\Auth::check())
	    {
	        \Auth::logout();
	        $request->session()->invalidate();
	    }
	    return  redirect('/login');
	}
}
