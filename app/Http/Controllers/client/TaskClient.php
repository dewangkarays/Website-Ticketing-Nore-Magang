<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Task;


class TaskClient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role > 20){
            $tasks = Task::join('users', 'users.id', '=', 'tasks.user_id',)
                        ->where('user_id',\Auth::user()->id)
                        ->orderBy('tasks.status', 'DESC')
                        ->orderBy('users.role', 'ASC')
                        ->orderBy('tasks.created_at', 'ASC')
                        ->select('tasks.*')
                        ->get();  //customer
        } else {
            $tasks = Task::join('users', 'users.id', '=', 'tasks.user_id')
                        ->orderBy('tasks.status', 'DESC')
                        ->orderBy('users.role', 'ASC')
                        ->orderBy('tasks.created_at', 'ASC')
                        ->select('tasks.*','users.task_count')
                        ->get(); //admin & karyawan
        }

        return view('client.task.index',['tasks'=>$tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('client.task.create');
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
        $task->save();
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
