<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Task;
use Carbon\Carbon;

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
        $todaynew = Task::where('status', '=', '1')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        $todayongoing = Task::where('status', '=', '2')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        $todaydone = Task::where('status', '=', '3')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        return view("index", compact('new','ongoing','done','todaynew','todayongoing','todaydone'));
    }

    public function karyawan()
    {
        $new = Task::where('status', '=', '1')->get()->count();
        $ongoing = Task::where('status', '=', '2')->get()->count();
        $done = Task::where('status', '=', '3')->get()->count();
        $todaynew = Task::where('status', '=', '1')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        $todayongoing = Task::where('status', '=', '2')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        $todaydone = Task::where('status', '=', '3')->whereDate('created_at', '=', Carbon::today()->toDateString())->get()->count();
        return view("index", compact('new','ongoing','done','todaynew','todayongoing','todaydone'));
    }

    public function customer()
    {
        $new = Task::where('status', '=', '1')->where('user_id',\Auth::user()->id)->get()->count();
        $ongoing = Task::where('status', '=', '2')->where('user_id',\Auth::user()->id)->get()->count();
        $done = Task::where('status', '=', '3')->where('user_id',\Auth::user()->id)->get()->count();
        return view("index", compact('new','ongoing','done'));
    }

    
}
