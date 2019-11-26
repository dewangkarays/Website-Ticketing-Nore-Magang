<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\Task;
use App\Model\User;
use App\Model\Attachment;
use App\Model\Notification;

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
        $users = User::where('role','99')->get(); //role customer
        $handlers = User::where('role','10')->get(); //role karyawan

        return view('tasks.create', compact('users','handlers'));
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

        //notifikasi
        $users = User::whereIn('role', ['1','10'])->get(); //role admin & karyawan
        foreach ($users as $user) {
            $notif = new Notification();
            $notif->title = 'Task Baru';
            $notif->message = $task->user->username.' mengirimkan task baru.';
            $notif->user_id = $user->id;
            $notif->save();
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
        $users = User::where('role','99')->get(); //role customer
        $handlers = User::where('role','10')->get(); //role karyawan
        $attachment = Attachment::where('task_id', '=', $id)->get();
        $task = Task::find($id);
        return view('tasks.edit', compact('task','users','handlers','attachment')); 
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
        if($task->status != $request->get('status')){
            $task->status = $request->get('status');

            //notifikasi
            if($request->get('status') == '2') {
                $notif = new Notification();
                $notif->title = 'Task Sedang Dikerjakan';
                $notif->message = 'Task yang anda kirimkan sedang dikerjakan.';
                $notif->user_id = $task->user_id;
                $notif->save();
            }

            //notifikasi
            if($request->get('status') == '3') {
                $notif = new Notification();
                $notif->title = 'Task Selesai Dikerjakan';
                $notif->message = 'Task yang anda kirimkan selesai dikerjakan.';
                $notif->user_id = $task->user_id;
                $notif->save();
            }
        }

        if($request->get('handler') != '' && $task->handler != $request->get('handler')){
            $task->handler = $request->get('handler');

            //notifikasi
            $notif = new Notification();
            $notif->title = 'Task Baru untuk Anda';
            $notif->message = 'Anda mendapat task baru untuk dikerjakan.';
            $notif->user_id = $request->get('handler');
            $notif->save();
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
                $attach->task_id = $id;
                $attach->file = $id.$name;
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
