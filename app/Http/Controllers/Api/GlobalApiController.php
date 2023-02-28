<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Attachment;
use App\Model\Presensi;
use App\Model\Cuti;

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
}
