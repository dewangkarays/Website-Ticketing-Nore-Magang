<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Model\Notification;

class NotifComposer
{

    public function compose(View $view)
    {
        $notif = Notification::where('user_id', '=', \Auth::user()->id)->orderBy('id','desc')->get();
        $count = Notification::where('user_id', '=', \Auth::user()->id)->where('status', '=', '1')->get()->count();
        $view->with(compact('notif', 'count'));
    }
}