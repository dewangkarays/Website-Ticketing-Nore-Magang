<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\client\Proyek;

class UserClient extends Controller
{
    //
    public function index(){
        $proyeks = Proyek::where('user_id',\Auth::user()->id);
        
        return view('client.layout',['proyeks'=>$proyeks]);
    }
}
