<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Task;
use App\Model\Tagihan;
use App\Model\User;
use App\Model\Proyek;


class TaskClient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where('user_id',\Auth::user()->id)
                    ->orderBy('tasks.status', 'ASC')
                    ->orderBy('tasks.created_at', 'DESC')
                    ->select('tasks.*')
                    ->get(); 
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $users = User::where('id',\Auth::user()->id)->get();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $setting = User::where('id',\Auth::user()->id)->first();

        return view('client.task.index',compact('tasks','users','highproyek','taskactives','tagihanactives','setting'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tasks = Task::where('user_id',\Auth::user()->id)->get();
        $proyeks = Proyek::where('user_id',\Auth::user()->id)->get();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $setting = User::where('id',\Auth::user()->id)->first();
        return view('client.task.create',compact('tasks','proyeks','highproyek','taskactives','tagihanactives','setting'));
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
        // return $request;
        $task = new Task;
        $task->user_id = \Auth::user()->id;
        $task->kebutuhan = $request->kebutuhan;
        $task->id_proyek = $request->website;
        $task->lampiran = $request->lampiran;
        
        $task->save();

        // dd($request->file('lampiran')); 
        
        return redirect('/taskclient');
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
        $tasks = Task::find($id);
        $tasks->delete();
        return redirect('/taskclient');
    }
}
