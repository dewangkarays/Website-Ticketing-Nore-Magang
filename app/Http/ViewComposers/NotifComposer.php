<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Model\Notification;

class NotifComposer
{

    public function compose(View $view)
    {
        $notif = Notification::where('user_id', '=', '1')->orderBy('id','desc')->get();
        $count = Notification::where('user_id', '=', '1')->where('status', '=', '1')->get()->count();
        $view->with(compact('notif', 'count'));
    }
}