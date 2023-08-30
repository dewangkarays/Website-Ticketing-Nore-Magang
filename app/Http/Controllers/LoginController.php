<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Model\PresensiQR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;



class LoginController extends Controller
{
    public function __construct()
    {
    	//test
    }

    public function index()
    {
		
			return view("login");

    }
    public function qrcode()
    {
		$cacheKey = 'uuid_' . now()->toDateString();

        $uuid = Cache::remember($cacheKey, now()->addDay(), function () {
             return Uuid::uuid4()->toString();
			 
    });
        $presensi = PresensiQR::updateOrCreate(
            [
                'tanggal' => now()->toDateString() 
            ],
            [    
                'uuid' => $uuid 
            ]);
			// dd($uuid);
			return view("login", compact('uuid'));

    }
	

    public function login(Request $request){
		$this->validate($request, [
			'username' => 'required',
	        'password' => 'required',
		]);
		// dd(bcrypt($request->password));
	    if (\Auth::attempt([
	        'username' => $request->username,
	        'password' => $request->password])
	    ){
	    	if(\Auth::user()->role==1){
	    		return redirect('/admin');
	    	}elseif(\Auth::user()->role==10 || \Auth::user()->role>=30 && \Auth::user()->role<=40){
	    		return redirect('/karyawan');
			}elseif(\Auth::user()->role==20){
				return redirect('/keuangan');
			}
			elseif(\Auth::user()->role==50){
				return redirect('/marketing');
			}
			elseif(\Auth::user()->role==95){
	    		return redirect('/customer');
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
