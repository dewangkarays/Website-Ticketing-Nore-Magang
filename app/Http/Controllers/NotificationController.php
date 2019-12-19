<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notif = Notification::where('user_id', '=', \Auth::user()->id)->orderBy('id','desc')->get();

        return view('notifikasi', compact('notif'));
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

    public function getNotif()
    {
        $notif = Notification::where('user_id', '=', \Auth::user()->id)->where('status', '=', '1')->orderBy('id','desc')->get();
        $count = Notification::where('user_id', '=', \Auth::user()->id)->where('status', '=', '1')->get()->count();
        
        $hbody = '';
        $hcount = '';
        if($count>0){
            $hcount = '<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">'.$count.'</span>';

            foreach($notif as $data){
                $url = route('clicknotif',$data->id);
                $hbody .= '<li class="media" style="border-top: solid;border-width: 1px;border-color: #39b772;padding-top: 15px; cursor:pointer;">
                
                            <a href="'.$url.'">
                                <div class="media-body">
                                    <div class="media-title">
                                            <span class="font-weight-semibold">'.$data->title.'</span>
                                    </div>
                
                                    <span class="text-muted">'.$data->message.'</span>
                                </div>
                            </a>
                        <hr>
                    </li>';
            }
        } else {
            $hbody = '<li class="media" style="border-top: solid;border-width: 1px;border-color: #39b772;padding-top: 15px;">
                                <div class="media-body">
                                    <div class="media-title">
                                            <span>Tidak ada notifikasi baru</span>
                                    </div>
                                </div>
                            <hr>
                        </li>';
        }

        $html['count']  = $hcount;
        $html['body']   = $hbody;

        return json_encode($html);

    }

    public function clickNotif($id)
    {
        $data = Notification::find($id);
        $data->status = 0;
        $data->save();

        $url = $data->url;

        return redirect($url);
    }

    public function clearNotif()
    {
        $id = \Auth::user()->id;
        Notification::where('user_id','=',$id)->update([ 'status' => '0']);

        $notif = Notification::where('user_id', '=', \Auth::user()->id)->where('status', '=', '1')->orderBy('id','desc')->get();
        $count = Notification::where('user_id', '=', \Auth::user()->id)->where('status', '=', '1')->get()->count();
        
        $hbody = '';
        $hcount = '';
        if($count>0){
            $hcount = '<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">'.$count.'</span>';

            foreach($notif as $data){
                $url = route('clicknotif',$data->id);
                $hbody .= '<li class="media" style="border-top: solid;border-width: 1px;border-color: #39b772;padding-top: 15px; cursor:pointer;">
                
                            <a href="'.$url.'">
                                <div class="media-body">
                                    <div class="media-title">
                                            <span class="font-weight-semibold">'.$data->title.'</span>
                                    </div>
                
                                    <span class="text-muted">'.$data->message.'</span>
                                </div>
                            </a>
                        <hr>
                    </li>';
            }
        } else {
            $hbody = '<li class="media" style="border-top: solid;border-width: 1px;border-color: #39b772;padding-top: 15px;">
                                <div class="media-body">
                                    <div class="media-title">
                                            <span>Tidak ada notifikasi baru</span>
                                    </div>
                                </div>
                            <hr>
                        </li>';
        }

        $html['count']  = $hcount;
        $html['body']   = $hbody;

        return json_encode($html);
    }
}

