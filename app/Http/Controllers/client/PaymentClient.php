<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Tagihan;
use App\Model\User;
use App\Model\Proyek;
use App\Model\Task;
use App\Model\Setting;

class PaymentClient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payments = Payment::where('user_id',\Auth::user()->id)->orderBy('tanggal','desc')->get();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $user = User::where('id',\Auth::user()->id)->first();
        return view('client.bayar.bayar',compact('payments','highproyek','taskactives','tagihanactives','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create($id)
    // {
    
    //     $tagihan = Tagihan::find($id);
    //     return view('client.bayar.pembayaran',compact('tagihan'));
    // }

    public function create()
    {
        $users = User::where('role','>','50')->get();
        $tagihanuser = Tagihan::where('user_id', \Auth::user()->id)->get();
        $tagihanuser2 = '';
        $setting = Setting::first();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $user = User::where('id',\Auth::user()->id)->first();
        return view('client.bayar.pembayaran',compact('setting', 'users', 'tagihanuser','tagihanuser2','highproyek','taskactives','tagihanactives','user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $tagihans = Tagihan::orderBy('created_at')->get();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $tagihanhistories = Tagihan::where('user_id',\Auth::user()->id)->where('status','=','2')->get()->count();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $user = User::where('id',\Auth::user()->id)->first();
        return view('client.tagihan.tagihan',compact('tagihans','tagihanactives','tagihanhistories','highproyek','taskactives','user'));
        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
