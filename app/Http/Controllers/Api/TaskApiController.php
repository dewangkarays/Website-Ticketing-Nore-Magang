<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Model\Task;
use App\Model\User;
use App\Model\Attachment;
use App\Model\Notification;
use Carbon\Carbon;

class TaskApiController extends Controller
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
                        ->get(); //admin & karyawan & keuangan
        }
        
        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Get data task success', 
            'data'=> $tasks
        ]);
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
        $users = User::whereIn('role', ['1','10','20'])->get(); //role admin & karyawan & keuangan
        foreach ($users as $user) {
            $notif = new Notification();
            $notif->title = 'Task Baru';
            $notif->message = $task->user->username.' mengirimkan task baru.';
            $notif->user_id = $user->id;
            $notif->url = route('tasks.edit',$task->id);
            $notif->save();
        }

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Create data task success', 
            'data'=> ['insertId'=>$task->id]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            // $users = User::where('role','>','20')->get(); //role customer
            // $handlers = User::where('role','10')->get(); //role karyawan
            // $attachment = Attachment::where('task_id', '=', $id)->get();
            $task = Task::find($id);

            if (!isset($task->user_id)) {
                return response()->json([
                    'code'=>404, 
                    'status'=>'Error', 
                    'message'=>'Data Unavailable', 
                    'data'=> null
                ]);
            }

            if (\Auth::user()->role>20 && $task->user_id != \Auth::user()->id) {
                return response()->json([
                    'code'=>400, 
                    'status'=>'Error', 
                    'message'=>'Access Restrict', 
                    'data'=> null
                ]);
            }

            return response()->json([
                'code'=>200, 
                'status'=>'Success', 
                'message'=>'Show data task success', 
                'data'=> $task
            ]);
        }
        catch(Exception $e){
            
            return response()->json([
                'code'=>400, 
                'status'=>'Error', 
                'message'=>'Data Unavailable', 
                'data'=> null
            ]);
        }
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

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Update data task success', 
            'data'=> ['updateId'=>$id]
        ]);
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

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Delete data task success', 
            'data'=> ['deleteId'=>$id]
        ]);
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

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'get data antrian success', 
            'data'=> $tasks
        ]);
    }

    public function history()
    {
        if(\Auth::user()->role > 20){
            $tasks = Task::where('status','=','3')->where('user_id',\Auth::user()->id)->get(); //customer
        } else {
            $tasks = Task::where('status','=','3')->get(); //admin & karyawan & keuangan
        }
        
        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'get data history success', 
            'data'=> $tasks
        ]);
    }

    // public function statistiktask(Request $request){
    //     if($request->isMethod('post')){
    //         $filter = $request->get('filter');
    //         $tahun = $request->get('tahun');
    //     } else {
    //         $filter = 'bulan';
    //         $tahun = date('Y');;
    //     }
    //     $data = array();
    //     $pie = array();
    //     $years = Task::selectRaw('year(created_at) as tahun')->where('status','1')->groupBy('tahun')->orderBy('tahun','DESC')->get();

    //     if($filter=="minggu"){

    //         $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->whereYear('created_at',$tahun)->groupBy('minggu')->get()->toArray();
            
    //         foreach ($qry as $val) {
    //             $data['all'][$val['minggu']] = $val['total'];
    //         }
    
    //         $employees = Task::select('handler')->where('handler','>',0)->groupBy('handler')->get();
            
    //         foreach ($employees as $employee) {
    //             $user = User::find($employee->handler);
    //             $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->where('handler', $employee->handler)->whereYear('created_at',$tahun)->groupBy('minggu')->get()->toArray();
    
    //             $pie[$user->nama] = 0;
    //             foreach ($qry as $val) {
    //                 $data[$user->nama][$val['minggu']] = $val['total'];
    //                 $pie[$user->nama] += $val['total'];
    //             }
    //         }
    
    //         $chart = array();
    //         foreach ($data as $nama => $value) {
    //             $chart[$nama] = array();
    //             for($i=1; $i<=53; $i++){ //total week
    //                 if(isset($value[$i])){
    //                     $nilai = $value[$i];
    //                 } else {
    //                     $nilai = 0;
    //                 }
    //                 array_push($chart[$nama], $nilai);
    //             }
    //         }

    //     } else {

    //         $qry = Task::selectRaw('month(created_at) as bulan, count(*) as total ')->whereYear('created_at',$tahun)->groupBy('bulan')->get()->toArray();
            
    //         foreach ($qry as $val) {
    //             $data['all'][$val['bulan']] = $val['total'];
    //         }
    
    //         $employees = Task::select('handler')->where('handler','>',0)->groupBy('handler')->get();
            
    //         foreach ($employees as $employee) {
    //             $user = User::find($employee->handler);
    //             $qry = Task::selectRaw('month(created_at) as bulan, count(*) as total ')->where('handler', $employee->handler)->whereYear('created_at',$tahun)->groupBy('bulan')->get()->toArray();
    
    //             $pie[$user->nama] = 0;
    //             foreach ($qry as $val) {
    //                 $data[$user->nama][$val['bulan']] = $val['total'];
    //                 $pie[$user->nama] += $val['total'];
    //             }
    //         }
    
    //         $chart = array();
    //         foreach ($data as $nama => $value) {
    //             $chart[$nama] = array();
    //             for($i=1; $i<=12; $i++){ //total month
    //                 if(isset($value[$i])){
    //                     $nilai = $value[$i];
    //                 } else {
    //                     $nilai = 0;
    //                 }
    //                 array_push($chart[$nama], $nilai);
    //             }
    //         }
    //     }

    //     $clients = User::leftjoin('tasks', 'users.id', '=', 'tasks.user_id')->selectRaw('users.username, count(tasks.id) as total ')->where('users.role','>','50')->whereYear('tasks.created_at',$tahun)->groupBy('users.username')->orderBy('total', 'DESC')->get();
        
    //     return view('statistiktask', compact('years', 'chart', 'pie', 'clients', 'filter', 'tahun'));
    // }

    // public function getstatistik(){

    //     $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->groupBy('minggu')->get()->toArray();
        
    //     foreach ($qry as $val) {
    //         $data['all'][$val['minggu']] = $val['total'];
    //     }

    //     $employees = Task::select('handler')->groupBy('handler')->get();
    //     foreach ($employees as $employee) {
    //         $user = User::find($employee->handler);
    //         $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->where('handler', $employee->handler)->groupBy('minggu')->get()->toArray();

    //         foreach ($qry as $val) {
    //             $data[$user->nama][$val['minggu']] = $val['total'];
    //         }
    //     }

    //     $chart = array();
    //     $pie = array();
    //     foreach ($data as $nama => $value) {
    //         // dd($value);
    //         $chart[$nama] = array();
    //         $pie[$nama] = 0;
    //         for($i=1; $i<=53; $i++){
    //             if(isset($value[$i])){
    //                 $nilai = $value[$i];
    //             } else {
    //                 $nilai = 0;
    //             }
    //             array_push($chart[$nama], $nilai);
    //             $pie[$nama] += $nilai;
    //         }
    //     }

    //     dd($chart);
    // }
}
