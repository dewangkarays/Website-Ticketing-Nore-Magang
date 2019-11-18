<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\Task;
use App\Model\User;
use App\Model\Attachment;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'kebutuhan'=>'required'
        ]);

        $task = new Task([
            'user_id' => $request->get('user_id'),
            'kebutuhan' => $request->get('kebutuhan'),
        ]);

        if($request->get('handler')!=''){
            $task->handler = $request->get('handler');
        }

        $task->save();

        if($request->hasfile('file'))
        {
            foreach($request->file('file') as $file)
            {
                $name=$file->getClientOriginalName();
                $file->storeAs('/attachment/', $task->id.$name); 
                // $data[] = $name;  

                $attach= new Attachment();
                $attach->task_id=$task->id;
                $attach->file= $task->id.$name;
                $attach->save();
            }
            
        }

        return redirect('/tasks')->with('success', 'Task saved!');
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
        $users = User::all();
        $attachment = Attachment::where('task_id', '=', $id)->get();
        $task = Task::find($id);
        return view('tasks.edit', compact('task','users','attachment')); 
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
        $request->validate([
            'status'=>'required',
        ]);

        $task = Task::find($id);
        $task->status =  $request->get('status');

        if($request->get('handler')!=''){
            $task->handler = $request->get('handler');
        }

        $task->save();

        if($request->hasfile('file'))
        {
            foreach($request->file('file') as $file)
            {
                $name=$file->getClientOriginalName();
                $file->storeAs('/attachment/', $id.$name); 
                // $data[] = $name;  

                $attach= new Attachment();
                $attach->task_id=$id;
                $attach->file= $id.$name;
                $attach->save();
            }
             
        }

        return redirect('/tasks')->with('success', 'Task updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        $attachment = Attachment::where('task_id', '=', $id);
        foreach ($attachment->get() as $attach) {
            Storage::delete('/attachment/'.$attach->file);
        }

        $attachment->delete();

        return redirect('/tasks')->with('success', 'Task deleted!');
    }
}
