<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginApiController extends Controller
{
    public function login(Request $request){
	    $loginData = $request->validate([
	        'username' => 'required',
	        'password' => 'required',
            ]);
            
	    if (!auth()->attempt($loginData)){
	        return response()->json([
                'code'=>400, 
                'status'=>'Error', 
                'message'=>'Wrong Username & Password', 
                'data'=> null
            ]);
        }
        
        $accToken = auth()->user()->createToken('authToken')->accessToken;

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Login Success', 
            'data'=> [
                'token'=>$accToken,
                'user' => auth()->user(),
                'role'=> [
                    'id'   => auth()->user()->role,
                    'divisi' => config('custom.role.'.auth()->user()->role)
            ]]
        ]);
    }
    
	public function logout(Request $request)
	{
	    if (\Auth::check()) {
            \Auth::user()->token()->revoke();

            return response()->json([
                'code'=>200, 
                'status'=>'Success', 
                'message'=>'Logout Success', 
                'data'=> null
            ]);
        }
	}
}
