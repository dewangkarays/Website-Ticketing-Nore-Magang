<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\Task;
use App\Model\User;
use App\Model\Attachment;
use App\Model\Notification;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role > 20){
            $tasks = Task::join('users', 'users.id', '=', 'tasks.user_id')
                        ->where('tasks.status','!=','3')
                        ->where('user_id',\Auth::user()->id)
                        ->orderBy('tasks.status', 'DESC')
                        ->orderBy('users.role', 'ASC')
                        ->orderBy('tasks.created_at', 'ASC')
                        ->select('tasks.*')
                        ->get();  //customer
        } else {
            $tasks = Task::join('users', 'users.id', '=', 'tasks.user_id')
                        ->where('tasks.status','!=','3')
                        ->orderBy('tasks.status', 'DESC')
                        ->orderBy('users.role', 'ASC')
                        ->orderBy('tasks.created_at', 'ASC')
                        ->select('tasks.*')
                        ->get(); //admin & karyawan
        }
        
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role','>','20')->get(); //role customer
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
            $notif->url = route('tasks.edit',$task->id);
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
        $users = User::where('role','>','20')->get(); //role customer
        $handlers = User::where('role','10')->get(); //role karyawan
        $attachment = Attachment::where('task_id', '=', $id)->get();
        $task = Task::find($id);

        if (\Auth::user()->role>20 && $task->user_id != \Auth::user()->id) {
            return redirect('/tasks')->with('error', 'Akses tidak diperbolehkan');
        }

        // if (\Auth::user()->role>20 && $task->status == '2') {
        //     return redirect('/tasks')->with('error', 'Task Sedang Dikerjakan');
        // }

        return view('tasks.show', compact('task','users','handlers','attachment')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::where('role','>','20')->get(); //role customer
        $handlers = User::where('role','10')->get(); //role karyawan
        $attachment = Attachment::where('task_id', '=', $id)->get();
        $task = Task::find($id);

        if (\Auth::user()->role>20 && $task->user_id != \Auth::user()->id) {
            return redirect('/tasks')->with('error', 'Akses tidak diperbolehkan');
        }

        // if (\Auth::user()->role>20 && $task->status == '2') {
        //     return redirect('/tasks')->with('error', 'Task Sedang Dikerjakan');
        // }

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
            //'status'=>'required',
        ]);

        $task = Task::find($id);
        $data = $request->except(['_token', '_method', 'file']);
        
        if($request->get('status')!=''){
            if($task->status != $request->get('status')){

                //notifikasi
                if($request->get('status') == '2') {
                    $notif = new Notification();
                    $notif->title = 'Task Sedang Dikerjakan';
                    $notif->message = 'Task yang anda kirimkan sedang dikerjakan.';
                    $notif->user_id = $task->user_id;
                    $notif->url = route('tasks.edit',$task->id);
                    $notif->save();
                }

                //notifikasi
                if($request->get('status') == '3') {
                    $notif = new Notification();
                    $notif->title = 'Task Selesai Dikerjakan';
                    $notif->message = 'Task yang anda kirimkan selesai dikerjakan.';
                    $notif->user_id = $task->user_id;
                    $notif->url = route('tasks.edit',$task->id);
                    $notif->save();
                }
            }
        }

        if($request->get('handler') != '' && $task->handler != $request->get('handler')){

            //notifikasi
            $notif = new Notification();
            $notif->title = 'Task Baru untuk Anda';
            $notif->message = 'Anda mendapat task baru untuk dikerjakan.';
            $notif->user_id = $request->get('handler');
            $notif->url = route('tasks.edit',$task->id);
            $notif->save();
        }

        $task->update($data);

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

    public function antrian()
    {
        $tasks = Task::join('users', 'users.id', '=', 'tasks.user_id')
                    ->where('tasks.status','!=','3')
                    ->orderBy('tasks.status', 'DESC')
                    ->orderBy('users.role', 'ASC')
                    ->orderBy('tasks.created_at', 'ASC')
                    ->select('tasks.*')
                    ->get();
                    //users.nama, users.username, 
        return view('antrian', compact('tasks'));
    }

    public function history()
    {
        if(\Auth::user()->role > 20){
            $tasks = Task::where('status','=','3')->where('user_id',\Auth::user()->id)->get(); //customer
        } else {
            $tasks = Task::where('status','=','3')->get(); //admin & karyawan
        }
        
        return view('history', compact('tasks'));
    }

    public function statistiktask($filter = 'bulan'){
        $pie = array();

        if($filter=="minggu"){

            $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->groupBy('minggu')->get()->toArray();
            
            foreach ($qry as $val) {
                $data['all'][$val['minggu']] = $val['total'];
            }
    
            $employees = Task::select('handler')->where('handler','>',0)->groupBy('handler')->get();
            
            foreach ($employees as $employee) {
                $user = User::find($employee->handler);
                $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->where('handler', $employee->handler)->groupBy('minggu')->get()->toArray();
    
                $pie[$user->nama] = 0;
                foreach ($qry as $val) {
                    $data[$user->nama][$val['minggu']] = $val['total'];
                    $pie[$user->nama] += $val['total'];
                }
            }
    
            $chart = array();
            foreach ($data as $nama => $value) {
                $chart[$nama] = array();
                for($i=1; $i<=53; $i++){ //total week
                    if(isset($value[$i])){
                        $nilai = $value[$i];
                    } else {
                        $nilai = 0;
                    }
                    array_push($chart[$nama], $nilai);
                }
            }

        } else {

            $qry = Task::selectRaw('month(created_at) as bulan, count(*) as total ')->groupBy('bulan')->get()->toArray();
            
            foreach ($qry as $val) {
                $data['all'][$val['bulan']] = $val['total'];
            }
    
            $employees = Task::select('handler')->where('handler','>',0)->groupBy('handler')->get();
            
            foreach ($employees as $employee) {
                $user = User::find($employee->handler);
                $qry = Task::selectRaw('month(created_at) as bulan, count(*) as total ')->where('handler', $employee->handler)->groupBy('bulan')->get()->toArray();
    
                $pie[$user->nama] = 0;
                foreach ($qry as $val) {
                    $data[$user->nama][$val['bulan']] = $val['total'];
                    $pie[$user->nama] += $val['total'];
                }
            }
    
            $chart = array();
            foreach ($data as $nama => $value) {
                $chart[$nama] = array();
                for($i=1; $i<=12; $i++){ //total month
                    if(isset($value[$i])){
                        $nilai = $value[$i];
                    } else {
                        $nilai = 0;
                    }
                    array_push($chart[$nama], $nilai);
                }
            }
        }

        $clients = User::leftjoin('tasks', 'users.id', '=', 'tasks.user_id')->selectRaw('users.username, count(tasks.id) as total ')->where('users.role','>','50')->groupBy('users.username')->orderBy('total', 'DESC')->get();
        
        return view('statistiktask', compact('chart', 'pie', 'clients', 'filter'));
    }

    public function getstatistik(){

        $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->groupBy('minggu')->get()->toArray();
        
        foreach ($qry as $val) {
            $data['all'][$val['minggu']] = $val['total'];
        }

        $employees = Task::select('handler')->groupBy('handler')->get();
        foreach ($employees as $employee) {
            $user = User::find($employee->handler);
            $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->where('handler', $employee->handler)->groupBy('minggu')->get()->toArray();

            foreach ($qry as $val) {
                $data[$user->nama][$val['minggu']] = $val['total'];
            }
        }

        $chart = array();
        $pie = array();
        foreach ($data as $nama => $value) {
            // dd($value);
            $chart[$nama] = array();
            $pie[$nama] = 0;
            for($i=1; $i<=53; $i++){
                if(isset($value[$i])){
                    $nilai = $value[$i];
                } else {
                    $nilai = 0;
                }
                array_push($chart[$nama], $nilai);
                $pie[$nama] += $nilai;
            }
        }

        dd($chart);
    }
}
