<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Attachment;
use App\Model\Presensi;
use App\Model\Cuti;
use Carbon\Carbon;


class GlobalApiController extends Controller
{
    public function getCustomer()
    {
        $users = User::where('role','>','20')->get();
        
        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Get data customer success', 
            'data'=> $users
        ]);
    }

    public function getKaryawan()
    {
        $users = User::where('role','10')->get();
        
        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Get data karyawan success', 
            'data'=> $users
        ]);
    }

    public function getKeuangan()
    {
        $users = User::where('role','20')->get();
        
        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Get data keuangan success', 
            'data'=> $users
        ]);
    }

    public function getAttachment($id)
    {
        $attachment = Attachment::where('task_id', '=', $id)->get();
        
        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Get data attachment success', 
            'data'=> $attachment
        ]);
    }

    public function hadir(Request $request)
    {
        $data = $request->all();

        $user = User::where('discord_id', $request->get('discord_id'))->first();

        if(!$user) {
            return response()->json([
                'code' => 400,
                'message' => 'Discord ID kamu belum diset! Silahkan update di halaman presensi.',
            ], 400);
        }

        $tanggal = date('Y-m-d');

        $check = Presensi::where('user_id',$user->id)
        ->where('tanggal',$tanggal)
        ->get();

        $cuti = Cuti::where('user_id',$user->id)
        ->where('tanggal_mulai','<=',$tanggal)
        ->where('tanggal_akhir','>=',$tanggal)
        ->get();
        // dd($cuti);
        if(count($check) != 0) {
            return response()->json([
                'code' => 400,
                'message' => 'Kamu sudah presensi hari ini!'
            ], 400);
        }
        if(count($cuti) != 0) {
            return response()->json([
                'code' => 400,
                'message' => 'Bukannya kamu lagi cuti, ya? Tidak perlu absen.'
            ], 400);
        }

        $presensi = new Presensi();
        $presensi->tanggal = $tanggal;
        $presensi->status = 1;
        $presensi->user_id = $user->id;

        $presensi->save();
        
        return response()->json([
            'code' => 200,
            'message' => 'Presensi kamu hari ini sudah tercatat!',
        ], 200);
    }

    public function getUserBelumPresensi()
    {
        $tanggal = date('Y-m-d');
        $users = User::whereNotNull('discord_id')
            ->whereDoesntHave('cuti', function($q) use($tanggal) {
                $q->where('tanggal_mulai','<=',$tanggal)
                ->where('tanggal_akhir','>=',$tanggal);
            })
            ->whereDoesntHave('presensi', function($q) use($tanggal) {
                $q->where('tanggal', $tanggal);
            })
            ->select('nama', 'discord_id')
            ->get();


        if(!$users) {
            return response()->json([
                'code' => 500,
                'message' => 'Something wrong',
            ], 500);
        }
        
        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'data' => $users
        ], 200);
    }
    
    public function izin($id,Request $request)
    {
        $user   = User::find($id);
        $tanggal= date('Y-m-d');
        if($user->sisa_cuti > 0){
            // $user->sisa_cuti -= 1;
            
            // $user->save();

            $tanggal              = date('Y-m-d');
            $presensi             = new Presensi();
            $presensi->tanggal    = $tanggal;
            $presensi->status     = 2;
            $presensi->user_id    = $user->id;
            $presensi->keterangan = $request->keterangan;
    
            $presensi->save();

            return response()->json([
                'code' => 200,
                'message' => 'Presensi Izin kamu hari ini sudah tercatat!',
            ], 200);
        } 

        return response()->json([
            'code' => 400,
            'message' => 'Sisa cuti kamu sudah habis!',
        ], 400);
        
    }

    public function wfh($id,Request $request)
    {
        $user   = User::find($id);
        $tanggal= date('Y-m-d');
       
           
            $tanggal              = date('Y-m-d');
            $presensi             = new Presensi();
            $presensi->tanggal    = $tanggal;
            $presensi->status     = 4;
            $presensi->user_id    = $user->id;
            $presensi->keterangan = $request->keterangan;
    
            $presensi->save();

            return response()->json([
                'code' => 200,
                'message' => 'Presensi WFH kamu hari ini sudah tercatat!',
            ], 200);
        
    }

    public function getTodayUlangTahun()
    {
        $day = date('d');
        $month = date('m');
        
        $user = User::whereMonth('tanggal_lahir', $month)
            ->whereDay('tanggal_lahir', $day)
            ->get();

        if(!$user) {
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan'
            ]);

        }

        return response()->json([
            'code' => 200,
            'message' => 'Success',
            'data' => $user
        ]);
    }

    public function cektoken(Request $request){
        // break up the string to extract only the token
        $auth_header = explode(' ', $request->get('token'));
        $token = $auth_header[0];

        // break up the token into its three respective parts
        // The current version of Passport places the JTI string value in the second token part, so: $token_parts[1]
        $token_parts = explode('.', $token);
        // $token_header = $token_parts[0];
        $token_header = $token_parts[1];

        // base64 decode to get a json string
        $token_header_json = base64_decode($token_header);

        // then convert the json to an array
        $token_header_array = json_decode($token_header_json, true);
        $user_token = $token_header_array['jti'];

        $oauth_user = \DB::table('oauth_access_tokens')->where('id', $user_token)->where('revoked', 0)->first();
        if($oauth_user){
            $expires = Carbon::parse($oauth_user->expires_at)->toDateTimeString();
            $now = date('Y-m-d h:i:s');

            if ($expires > $now) {
                return response()->json([
                    'code' => 200,
                    'message' => 'Token Valid',
                ]);
            } else {
                return response()->json([
                    'code' => 400,
                'message' => 'Token Invalid',
                ])(400,'Success','Token Expired');
            }
        } else {
            return response()->json([
                'code' => 400,
                'message' => 'Token Invalid',
            ]);
        }
    }
}
