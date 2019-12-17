<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\User;

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

        $payment = new Payment();

        $data = $request->except(['_token', '_method']);
        $payment->insert($data);
        
        if($request->get('kadaluarsa')!=''){
            //$payment->kadaluarsa = $request->get('kadaluarsa');

            $user = User::find($request->get('user_id'));
            $user->kadaluarsa = $request->get('kadaluarsa');
            $user->save();
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
        $data = $request->except(['_token', '_method']);

        if($request->get('kadaluarsa')!=''){

            $user = User::find($request->get('user_id'));
            $user->kadaluarsa = $request->get('kadaluarsa');
            $user->save();
        }

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
        $payment->delete();

        return redirect('/payments')->with('success', 'Payment deleted!');
    }
}
