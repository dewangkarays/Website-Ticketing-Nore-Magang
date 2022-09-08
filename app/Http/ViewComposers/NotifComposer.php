<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Model\User;
use App\Model\Tagihan;
use App\Model\Payment;
use Carbon\Carbon;

class NotifComposer
{

    public function compose(View $view)
    {
        $expired = User::where('kadaluarsa', '<', Carbon::now()->toDateString())->get()->count();
        $admunpaid = Tagihan::where('status','!=',2)->count();
        $userunpaid = Tagihan::where('status','!=',2)->where('user_id',\Auth::user()->id)->count();
        $confirmpayments = Payment::where('status', '=', 0)->count();
        $view->with(compact('expired','admunpaid','userunpaid','confirmpayments'));
    }
}