<?php

namespace App\Http\Controllers\Api;

use App\Model\Presensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $user = auth()->user();
        $roleId = $user->role;
        $user->divisi = config('custom.role.' . $roleId, null);

        $hadir = Presensi::where('user_id', \Auth::user()->id)->where('status', '1')->count();
        $sakit = Presensi::where('user_id', \Auth::user()->id)->where('status', '3')->count();
        $izin = Presensi::where('user_id', \Auth::user()->id)->where('status', '2')->count();     
        $WFH = Presensi::where('user_id', \Auth::user()->id)->where('status', '4')->count(); 
        $sisa_cuti = 12 - $izin;
        $validasipresensi = $hadir > 0 || $sakit > 0 || $izin > 0 || $WFH > 0;
        
        // $user->jumlah_kehadiran = [
        //     'hadir' => $hadir,
        //     'sakit' => $sakit,
        //     'izin' => $izin,
        //     'WFH' => $WFH,
        //     'sisa_cuti' => $sisa_cuti
        // ];
        $user->hadir = $hadir;
        $user->sakit = $sakit;
        $user->izin = $izin;
        $user->WFH = $WFH;
        $user->sisa_cuti = $sisa_cuti;
        $user->validasi_presensi = $validasipresensi;
       

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Login Success', 
            'data'=> [
                'token'=>$accToken,
                'user' => $user,
                // 'jumlah_kehadiran'=> [
                //     'hadir' => $hadir,
                //    'sakit'=> $sakit,
                //     'izin'=> $izin,
                //     'WFH'=>$WFH,
                //     'sisa_cuti'=>$sisa_cuti
                // ]
                // 'posisi' => $user, 
                // 'divisi' => config('custom.role.' . $roleId, null),
                 
                
            ]
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
