<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Task;
use App\Model\Tagihan;
use App\Model\Proyek;

class AntrianClient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $antrians = Task::join('proyeks', 'proyeks.id', '=', 'tasks.id_proyek')
        ->where('proyeks.tipe','!=','80')
        ->orderBy('tasks.status', 'DESC')
        ->orderBy('tasks.created_at', 'ASC')
        ->get();

        $antrianpremiums = Task::join('proyeks', 'proyeks.id', '=', 'tasks.id_proyek')
        ->where('proyeks.tipe', '80')
        ->orderBy('tasks.status', 'DESC')
        ->orderBy('tasks.created_at', 'ASC')
        ->get();

        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();

        $premiumproyek = Proyek::where('user_id',\Auth::user()->id)->where('tipe','80')->count();
        // dd($premiumproyek);

        $otherproyek = Proyek::where('user_id',\Auth::user()->id)->where('tipe','!=','80')->count();
        // dd($otherproyek);

        $taskcount = Task::where('user_id',\Auth::user()->id)->get()->count();

        $task = User::where('id',\Auth::user()->id)->first();

        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();

        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();

        $user = User::where('id',\Auth::user()->id)->first();

        return view('client.antrian.antrian',compact('antrians','taskcount','task','highproyek','taskactives','tagihanactives','user','otherproyek','antrianpremiums','premiumproyek'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
