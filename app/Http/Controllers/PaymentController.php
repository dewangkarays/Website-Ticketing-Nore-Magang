<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\User;
use App\Model\Notification;
use App\Model\Task;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role > 20){
            $payments = Payment::where('user_id',\Auth::user()->id)->orderBy('status','ASC')->orderBy('tgl_bayar','ASC')->get();
        } else {
            $payments = Payment::orderBy('status','ASC')->orderBy('tgl_bayar','ASC')->get();
        }
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role','>','50')->get();

        return view('payments.create', compact('users'));
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
            // 'user_id'=>'required',
            // 'keterangan'=>'required',
            // 'nominal'=>'required',
        ]);

        $data = $request->except(['_token', '_method']);
        $user = User::find($request->get('user_id'));
        $data['user_role'] = $user->role;
        $payment = Payment::create($data);
        
        $cust = User::find($request->get('user_id'));
        if($request->get('kadaluarsa')!='' && $request->get('status')=='1'){
            //$payment->kadaluarsa = $request->get('kadaluarsa');

            $cust->kadaluarsa = $request->get('kadaluarsa');
            $cust->save();
        }

        //notifikasi
        $users = User::whereIn('role', ['1','10'])->get(); //role admin & karyawan
        foreach ($users as $user) {
            $notif = new Notification();
            $notif->title = 'Pembayaran Baru';
            $notif->message = $cust->username.' mengirimkan pembayaran baru.';
            $notif->user_id = $user->id;
            $notif->url = route('payments.edit',$payment->id);
            $notif->save();
        }

        return redirect('/payments')->with('success', 'Payment saved!');
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
        $payment = Payment::find($id);
        $users = User::where('role','>','50')->get();
        return view('payments.edit', compact('payment','users')); 
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
            // 'user_id'=>'required',
            // 'keterangan'=>'required',
            // 'nominal'=>'required',
        ]);

        $payment = Payment::find($id);
        $data = $request->except(['_token', '_method','kadaluarsa','updkadaluarsa']);
        
        if($request->get('kadaluarsa')!='' && $request->get('status')=='1' && $request->get('updkadaluarsa')=='1'){
            $data['kadaluarsa'] = $request->get('kadaluarsa');

            $user = User::find($request->get('user_id'));
            $user->kadaluarsa = $request->get('kadaluarsa');
            $user->save();
        }

        if($request->get('status')!=''){
            if($payment->status != $request->get('status')){

                //notifikasi
                if($request->get('status') == '1') {
                    $notif = new Notification();
                    $notif->title = 'Pembayaran Dikonfirmasi';
                    $notif->message = 'Terima kasih telah melakukan pembayaran.';
                    $notif->user_id = $payment->user_id;
                    $notif->url = route('payments.edit',$payment->id);
                    $notif->save();
                }

                //notifikasi
                if($request->get('status') == '2') {
                    $notif = new Notification();
                    $notif->title = 'Input Pembayaran Ditolak';
                    $notif->message = 'Mohon periksa kembali data pembayaran dan lakukan konfirmasi ulang.';
                    $notif->user_id = $payment->user_id;
                    $notif->url = route('payments.edit',$payment->id);
                    $notif->save();
                }
            }

            $payment->update($data);
        }

        return redirect('/payments')->with('success', 'Payment updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        $payment->delete();

        return redirect('/payments')->with('success', 'Payment deleted!');
    }

    public function statistikpayment($filter = 'bulan'){
        $pie = array();

        if($filter=="minggu"){

            $qry = Task::selectRaw('week(created_at) as minggu, count(*) as total ')->groupBy('minggu')->get()->toArray();
            
            foreach ($qry as $val) {
                $data['all'][$val['minggu']] = $val['total'];
            }
    
            $employees = Task::select('handler')->groupBy('handler')->get();
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

            $chart = array();
            $chart[80] = $chart[90] = $chart[99] = array_fill(1, 12, 0);
            $pie[80] = $pie[90] = $pie[99] = 0;

            $qry = Payment::selectRaw('month(tgl_bayar) as bulan, user_role, sum(nominal) as total ')->where('status','1')->groupBy('bulan', 'user_role')->get()->toArray();
            
            foreach ($qry as $val) {
                $chart[$val['user_role']][$val['bulan']] = $val['total'];

                $pie[$val['user_role']] += $val['total'];
            }
            
        }

        $clients = Payment::select('*')->offset(10)->limit(7)->get();
        
        return view('statistikpayment', compact('chart', 'pie', 'clients', 'filter'));
    }
}
