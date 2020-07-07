<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\User;
use App\Model\Notification;
use App\Model\Task;
use App\Model\Tagihan;

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
            $payments = Payment::where('user_id',\Auth::user()->id)->orderByRaw('case when status = 0 then 0 else 1 end, status')->orderBy('tgl_bayar','ASC')->get();
        } else {
            $payments = Payment::orderByRaw('case when status = 0 then 0 else 1 end, status')->orderBy('tgl_bayar','ASC')->get();
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
        $cust = User::find($request->get('user_id'));
        $data['user_role'] = $cust->role;
        $payment = Payment::create($data);
        
        if($request->get('kadaluarsa')!=''){

            $cust->kadaluarsa = $request->get('kadaluarsa');
            $cust->save();
        }

        if($request->get('task_count')!=''){

            $cust->task_count += $request->get('task_count');
            $cust->save();
        }

        $tagihan = Tagihan::find($request->get('tagihan_id'));
        $tagihan->jml_tagih -= $request->get('nominal');
        $tagihan->jml_bayar += $request->get('nominal');
        if($tagihan->jml_tagih==0){
            $tagihan->status=2;
        } else {
            $tagihan->status=1;
        }
        $tagihan->save();

        //notifikasi
        // $users = User::whereIn('role', ['1','10'])->get(); //role admin & karyawan
        // foreach ($users as $user) {
        //     $notif = new Notification();
        //     $notif->title = 'Pembayaran Baru';
        //     $notif->message = $cust->username.' mengirimkan pembayaran baru.';
        //     $notif->user_id = $user->id;
        //     $notif->url = route('payments.edit',$payment->id);
        //     $notif->save();
        // }

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
        $tagihans = Tagihan::where('user_id', $payment->user_id)->get();
        $detailtagih = Tagihan::find($payment->tagihan_id);
        $users = User::where('role','>','50')->get();
        return view('payments.edit', compact('payment','users','tagihans','detailtagih')); 
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
        $data = $request->except(['_token', '_method','kadaluarsa','updkadaluarsa','task_count']);
        
        $user = User::find($request->get('user_id'));
        if($request->get('kadaluarsa')!='' && $request->get('updkadaluarsa')=='1'){
            $data['kadaluarsa'] = $request->get('kadaluarsa');

            $user->kadaluarsa = $request->get('kadaluarsa');
            $user->save();
        }

        if($request->get('task_count')!='' && $request->get('updkadaluarsa')=='1'){
            $data['task_count'] = $request->get('task_count');

            $user->task_count += $request->get('task_count');
            $user->save();
        }

        // if($request->get('status')!=''){
        //     if($payment->status != $request->get('status')){

        //         //notifikasi
        //         if($request->get('status') == '1') {
        //             $notif = new Notification();
        //             $notif->title = 'Pembayaran Dikonfirmasi';
        //             $notif->message = 'Terima kasih telah melakukan pembayaran.';
        //             $notif->user_id = $payment->user_id;
        //             $notif->url = route('payments.edit',$payment->id);
        //             $notif->save();
        //         }

        //         //notifikasi
        //         if($request->get('status') == '2') {
        //             $notif = new Notification();
        //             $notif->title = 'Input Pembayaran Ditolak';
        //             $notif->message = 'Mohon periksa kembali data pembayaran dan lakukan konfirmasi ulang.';
        //             $notif->user_id = $payment->user_id;
        //             $notif->url = route('payments.edit',$payment->id);
        //             $notif->save();
        //         }
        //     }

        // }
        

        $tagihan = Tagihan::find($request->get('tagihan_id'));
        $tagihan->jml_tagih -= ($request->get('nominal') - $payment->nominal);
        $tagihan->jml_bayar += ($request->get('nominal') - $payment->nominal);
        if($tagihan->jml_tagih==0){
            $tagihan->status=2;
        } else {
            $tagihan->status=1;
        }
        $tagihan->save();

        $payment->update($data);

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
        
        $tagihan = Tagihan::find($payment->tagihan_id);
        $tagihan->jml_tagih += $payment->nominal;
        $tagihan->jml_bayar -= $payment->nominal;
        if($tagihan->jml_bayar==0){
            $tagihan->status=0;
        } else {
            $tagihan->status=1;
        }
        $tagihan->save();

        $payment->delete();

        return redirect('/payments')->with('success', 'Payment deleted!');
    }

    public function statistikpayment(Request $request){
        if($request->isMethod('post')){
            $filter = $request->get('tahun');
        } else {
            $filter = date('Y');
        }

        $chart = array();
        $pie = array();
        // $chart[80] = $chart[90] = $chart[99] = array_fill(1, 12, 0);
        $chart[0] = array_fill(1, 12, 0);
        $pie[80] = $pie[90] = $pie[99] = 0;

        $years = Payment::selectRaw('year(tgl_bayar) as tahun')->where('status','1')->groupBy('tahun')->orderBy('tahun','DESC')->get();

        $qry = Payment::selectRaw('month(tgl_bayar) as bulan, user_role, sum(nominal) as total ')->where('status','1')->whereYear('tgl_bayar',$filter)->groupBy('bulan', 'user_role')->get()->toArray();
        
        foreach ($qry as $val) {
            // $chart[$val['user_role']][$val['bulan']] = $val['total'];
            $chart[0][$val['bulan']] += $val['total'];

            $pie[$val['user_role']] += $val['total'];
        }

        $clients = Payment::select('*')->orderBy('tgl_bayar','DESC')->offset(0)->limit(8)->get();
        $totals = Payment::selectRaw('user_id, SUM(nominal) as total')->groupBy('user_id')->orderBy('total','DESC')->get();
        
        return view('statistikpayment', compact('years', 'chart', 'pie', 'clients', 'filter','totals'));
    }
}
