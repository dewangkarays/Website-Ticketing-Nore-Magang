<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\User;
use App\Model\Notification;
use App\Model\Task;

class PaymentApiController extends Controller
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
        
        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Get data payment success', 
            'data'=> $payments
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
            'keterangan'=>'required',
            'nominal'=>'required',
            'tgl_bayar'=>'required',
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
        $users = User::whereIn('role', ['1','10','20'])->get(); //role admin & karyawan & keuangan
        foreach ($users as $user) {
            $notif = new Notification();
            $notif->title = 'Pembayaran Baru';
            $notif->message = $cust->username.' mengirimkan pembayaran baru.';
            $notif->user_id = $user->id;
            $notif->url = route('payments.edit',$payment->id);
            $notif->save();
        }

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Create data payment success', 
            'data'=> ['insertId'=>$payment->id]
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
        $payment = Payment::find($id);
        // $users = User::where('role','>','50')->get();

        if (!isset($payment->user_id)) {
            return response()->json([
                'code'=>404, 
                'status'=>'Error', 
                'message'=>'Data Unavailable', 
                'data'=> null
            ]);
        }

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Show data payment success', 
            'data'=> $payment
        ]);
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

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Update data payment success', 
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
        $payment = Payment::find($id);
        $payment->delete();

        return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Delete data payment success', 
            'data'=> ['deleteId'=>$id]
        ]);
    }

    // public function statistikpayment(Request $request){
    //     if($request->isMethod('post')){
    //         $filter = $request->get('tahun');
    //     } else {
    //         $filter = date('Y');
    //     }

    //     $chart = array();
    //     $pie = array();
    //     // $chart[80] = $chart[90] = $chart[99] = array_fill(1, 12, 0);
    //     $chart[0] = array_fill(1, 12, 0);
    //     $pie[80] = $pie[90] = $pie[99] = 0;

    //     $years = Payment::selectRaw('year(tgl_bayar) as tahun')->where('status','1')->groupBy('tahun')->orderBy('tahun','DESC')->get();

    //     $qry = Payment::selectRaw('month(tgl_bayar) as bulan, user_role, sum(nominal) as total ')->where('status','1')->whereYear('tgl_bayar',$filter)->groupBy('bulan', 'user_role')->get()->toArray();
        
    //     foreach ($qry as $val) {
    //         // $chart[$val['user_role']][$val['bulan']] = $val['total'];
    //         $chart[0][$val['bulan']] += $val['total'];

    //         $pie[$val['user_role']] += $val['total'];
    //     }

    //     $clients = Payment::select('*')->orderBy('tgl_bayar','DESC')->offset(0)->limit(8)->get();
        
    //     return view('statistikpayment', compact('years', 'chart', 'pie', 'clients', 'filter'));
    // }
}
