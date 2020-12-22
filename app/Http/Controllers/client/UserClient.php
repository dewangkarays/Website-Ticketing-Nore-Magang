<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\client\User;

class UserClient extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view('client.layout',['users'=>$users]);
    }
}
