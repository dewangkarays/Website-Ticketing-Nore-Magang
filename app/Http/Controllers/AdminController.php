<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Task;

class AdminController extends Controller
{
    public function __construct()
    {
    	//
    }

    public function index()
    {
        $new = Task::where('status', '=', '1')->get()->count();
        $ongoing = Task::where('status', '=', '2')->get()->count();
        $done = Task::where('status', '=', '3')->get()->count();
    	return view("index", compact('new','ongoing','done'));
    }

    
}
