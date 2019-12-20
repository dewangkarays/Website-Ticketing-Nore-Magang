<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Model\User;
use Carbon\Carbon;

class NotifComposer
{

    public function compose(View $view)
    {
        $expired = User::where('kadaluarsa', '<', Carbon::now()->toDateString())->get()->count();
        $view->with(compact('expired'));
    }
}