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
            ]);
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
            ]);
        }
        if(count($cuti) != 0) {
            return response()->json([
                'code' => 400,
                'message' => 'Bukannya kamu lagi cuti, ya? Tidak perlu absen.'
            ]);
        }

        $presensi = new Presensi();
        $presensi->tanggal = $tanggal;
        $presensi->status = 1;
        $presensi->user_id = $user->id;

        $presensi->save();
        
        return response()->json([
            'code' => 200,
            'message' => 'Presensi kamu hari ini sudah tercatat!',
        ]);
    }
}
