<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Payment;
use App\Model\Tagihan;
use App\Model\User;
use App\Model\Proyek;
use App\Model\Task;
use App\Model\Setting;
use Illuminate\Support\Facades\File;

class PaymentClient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $payments = Payment::where('user_id',\Auth::user()->id)->orderBy('tanggal','desc')->get();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $user = User::where('id',\Auth::user()->id)->first();
        return view('client.bayar.bayar',compact('payments','highproyek','taskactives','tagihanactives','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create($id)
    // {
    
    //     $tagihan = Tagihan::find($id);
    //     return view('client.bayar.pembayaran',compact('tagihan'));
    // }

    public function create()
    {
        $users = User::where('role','>','50')->get();
        $tagihanuser = Tagihan::where('user_id', \Auth::user()->id)->where('status', '<', '1')->get();
        $tagihanuser2 = '';
        $setting = Setting::first();
        $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $user = User::where('id',\Auth::user()->id)->first();
        return view('client.bayar.pembayaran',compact('setting', 'users', 'tagihanuser','tagihanuser2','highproyek','taskactives','tagihanactives','user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        // $request->validate([
        //     'bukti_pembayaran' => 'mimes:jpeg,png,jpg,gif,svg',
        //     'tgl_bayar => required'
        // ]);

        $tujuan_upload = config('app.upload_url').'bukti_pembayaran';
        $file = $request->file('bukti_pembayaran');
        // dd($file);
        if($file){
                $name = \Auth::user()->id."_".time().".".$file->getClientOriginalName();
                // $destinationPath = public_path('/thumbnail');
                
                $imgsize = $file->getSize();
                $imgsize = number_format($imgsize / 1048576,2);
                $img = \Image::make($file->getRealPath());
                // dd($imgsize);
                
                //compress file
                if(filesize($file) < 204800){
                    $img->save($tujuan_upload.'/'.$name, 90, 'jpg');
                }
                elseif(filesize($file) < 1048576){
                    $img->save($tujuan_upload.'/'.$name, 80, 'jpg');
                } else{
                    $img->save($tujuan_upload.'/'.$name, 10, 'jpg');
                }
                // $img->move($tujuan_upload, $name);
                // $name = \Auth::user()->id."_".time().".".$file->getClientOriginalExtension();
                // $up1 = $file->move($tujuan_upload,$name);
                // if($img){
                //     $data['bukti_pembayaran'] = $tujuan_upload.'/'.$name;
                // }
        }

        $tagihan = Tagihan::find($request->tagihan_id);

        $payment = new Payment;
        $payment->user_id = \Auth::user()->id;
        $payment->nama = \Auth::user()->nama;
        $payment->keterangan = $request->keterangan;
        $payment->nominal = $request->nominal;
        $payment->tanggal = $request->tgl_bayar;
        $payment->status = 0;
        $payment->jenis_pemasukan = 1;
        if ($request->jenis_rekap == "dptagihan") {
            $payment->rekap_dptagihan_id = $tagihan->rekap_dptagihan_id;
        } else {
            $payment->rekap_tagihan_id = $tagihan->rekap_tagihan_id;
        }
        $payment->tagihan_id = $tagihan->id;
        $payment->bukti_pembayaran = $tujuan_upload.'/'.$name;
        // dd($payment);
        $payment->save();
        return redirect('/customer');
        // dd($payment);
        // $tagihans = Tagihan::orderBy('created_at')->get();
        // $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        // $tagihanhistories = Tagihan::where('user_id',\Auth::user()->id)->where('status','=','2')->get()->count();
        // $highproyek = Proyek::where('user_id',\Auth::user()->id)->orderBy('tipe','asc')->first();
        // $taskactives = Task::where('user_id',\Auth::user()->id)->where('status','!=','3')->get()->count();
        // $user = User::where('id',\Auth::user()->id)->first();
        // return view('client.tagihan.tagihan',compact('tagihans','tagihanactives','tagihanhistories','highproyek','taskactives','user'));
        
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
}
