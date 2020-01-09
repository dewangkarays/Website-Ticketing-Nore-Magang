<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Attachment;

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
}
