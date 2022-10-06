<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Model\User;
use App\Model\Tagihan;
use App\Model\Payment;
use App\Model\Cuti;
use Carbon\Carbon;
use Auth;

class NotifComposer
{

    public function compose(View $view)
    {
        $currentUserId = Auth::id();

        $expired = User::where('kadaluarsa', '<', Carbon::now()->toDateString())->get()->count();
        $admunpaid = Tagihan::where('status','!=',2)->count();
        $userunpaid = Tagihan::where('status','!=',2)->where('user_id',\Auth::user()->id)->count();
        $confirmpayments = Payment::where('status', '=', 0)->count();
        $unverifiedcutiv = Cuti::where(
            function($q) use ($currentUserId) {
                $q->where(
                    function($q1) use ($currentUserId) {
                        $q1->where('verifikator_2_id', $currentUserId)
                            ->where('verifikasi_2', '1');
                    }
                )
                ->orWhere(
                    function($q2) use ($currentUserId) {
                        $q2->where('verifikator_1_id', $currentUserId)
                            ->where('verifikasi_2', '2')
                            ->where('verifikasi_1', '1');
                    }
                );
            }
        )
        ->where('status', '<', '3')
        ->count();
        $unverifiedcutis = Cuti::where('status', '1')->count();
        $view->with(compact('expired','admunpaid','userunpaid','confirmpayments','unverifiedcutiv','unverifiedcutis'));
    }
}