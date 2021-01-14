<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Task;
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
        ->orderBy('proyeks.tipe', 'ASC')
        // ->where('tasks.status','!=','3')
        ->orderBy('tasks.status', 'DESC')
        ->orderBy('tasks.created_at', 'ASC')
        ->select('tasks.*')
        ->paginate(5);
        // dd(request()->all());
        // ->get();
        // dd($antrians);

        // dd('/antrian?page=2');
        // dd($antrians->toJson());

        $taskcount = Task::where('user_id',\Auth::user()->id)->get()->count();

        $task = User::where('id',\Auth::user()->id)->first();

        return view('client.antrian.antrian',compact('antrians','taskcount','task'));
    }

    // public function fetch_data(Request $request)
    // {
    // if($request->ajax())
    // {
    // $antrians = Task::join('proyeks', 'proyeks.id', '=', 'tasks.id_proyek')
    // ->orderBy('proyeks.tipe', 'ASC')
    // ->where('tasks.status','!=','3')
    // ->orderBy('tasks.status', 'DESC')
    // ->orderBy('tasks.created_at', 'ASC')
    // ->select('tasks.*')
    // ->paginate(5);
    
    // return view('client.antrian.antrian', compact('antrians'))->render();
    // }
    // }

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
