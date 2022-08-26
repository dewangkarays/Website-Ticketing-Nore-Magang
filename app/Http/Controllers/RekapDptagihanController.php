<?php

namespace App\Http\Controllers;

use App\Model\RekapDptagihan;
use App\Model\Tagihan;
use App\Model\User;
use App\Model\Nomor;
use App\Model\Setting;
use App\Model\Lampiran_gambar;
use App\Model\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Datatables;

class RekapDptagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekapdps = RekapDptagihan::where('status','<','4')->orderByDesc('created_at')->get();
        $tagihans = Tagihan::all();
        $users = User::where('role','>=','80')->get();
        return view('rekapdptagihans.index', compact('rekapdps','tagihans', 'users'));
    }

    public function history()
    {
        $rekapdps = RekapDptagihan::where('status','>=','4')->orderByDesc('created_at')->get();
        $tagihans = Tagihan::all();
        $users = User::where('role','>=','80')->get();
        return view('rekapdptagihans.history', compact('rekapdps','tagihans', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $requestUser = '';
        if($request->get('c'))
        {
            $requestUser = $request->get('c');
            $tagihans = Tagihan::where('user_id',$requestUser)->whereNull('rekap_dptagihan_id')->where('uang_muka','>',0)->orderBy('id')->get();
        }
        else
        {
            $tagihans = Tagihan::orderBy('id')->get();
        }
        // dd($tagihans);
        $users = User::where('role','>=',80)->get();
        $users = $users->sortBy('nama');
        $penagih = Setting::first();
        $lastno = Nomor::first();
        return view('rekapdptagihans.create', compact('users','penagih','lastno','requestUser','tagihans'));
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
            'ninv'=>'bail|unique:nomors|required',
        ]);

        $data = $request->except(['_token', '_method','noinv','ninv','noakhir','tagihan_id']);

        $arrayid = $request->get('tagihan_id');
        $findtagihan = Tagihan::whereIn('id', $arrayid)->get();
        $tagihans = $findtagihan;
        $finduser = User::find($data['user_id']);
        $data['nama'] = $finduser->nama;
        $data['total'] = $tagihans->sum('uang_muka');
        $data['status'] = 1;
        $data['nama_tertagih'] = $request->get('nama_tertagih');
        $data['alamat'] = $request->get('alamat');

        // FORMAT INVOICE
        $invoiceno = 01;

        $invawal = $request->get('noinv');
        $nomorinv = $request->get('ninv');
        $noakhir = $request->get('noakhir');
        $no = str_pad($nomorinv,3,"0",STR_PAD_LEFT);
        $data['invoice'] = $invawal.'/'.$no.'/'.$noakhir;
        $lastinv = Tagihan::latest('id')->first();

        // dd($data);

        if ($lastinv) {
            $diffinv = substr($lastinv->invoice,0,3);
            if ($diffinv == 'INV') {
                $different = 'no';
            } else {
                $different = 'yes';
            }

            if ($different == 'yes') {
                $lastno = Nomor::first();
                if ($lastno) {
                    $lastno->ninv = $nomorinv;
                    $lastno->save();
                } else {
                    $lastno['ninv'] = 1;
                    $lastno = Nomor::create($lastno);
                }
            } else {
                // jika tidak sama
                $lastno = Nomor::first();
                if ($lastno) {
                    $lastno->ninv = $nomorinv;
                    $lastno->save();
                } else {
                    $lastno['ninv'] = 1;
                    $lastno = Nomor::create($lastno);
                }
            }

        } else {
            $lastno = Nomor::first();
            if ($lastno) {
                $lastno->ninv = $nomorinv;
                $lastno->save();
            } else {
                $lastno['ninv'] = 1;
                $lastno = Nomor::create($lastno);
            }
        }

        // dd($data);
        $rekapdptagihan = RekapDptagihan::create($data);
        $rekapdptagihan->save();
        foreach($tagihans as $tagihan){
            $tagihan->update([
                'rekap_dptagihan_id'=> $rekapdptagihan->id,
            ]);
        }

        return redirect('/rekapdptagihans')->with('success', 'Rekap uang muka saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rekapdp = RekapDpTagihan::find($id);
        $tagihans = Tagihan::where('rekap_dptagihan_id', $id)->get();
        return view('rekapdptagihans.show', compact('rekapdp','tagihans'));
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
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        if($validator->fails()) {
            return redirect()->back()->with('error');
        }
        $data = $request->except(['_token', '_method']);

        $tagihans =Tagihan::where('rekap_tagihan_id', $id)->get();

        if($request->get('jml_terbayar')==''){
            $data['jml_terbayar'] = 0;
        }
        $data['status'] = $request->get('status');

        // dd($data);

        $rekapdp = RekapDptagihan::find($id);

        if(!$rekapdp->payment->isEmpty()){
            $rekapdp->status = $request->get('status');
            if($rekapdp->isDirty('status')){
                return redirect()->back()
                ->with('error','Tidak bisa mengubah status, rekap ini memiliki data pembayaran.');
            }
            else{
                $rekapdp->update($data);
                return redirect('/rekapdptagihans')->with('success', 'Rekap uang muka updated!');
            }
        }
        else{
            $rekapdp->update($data);
            return redirect('/rekapdptagihans')->with('success', 'Rekap uang muka updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rekapdp = RekapDptagihan::find($id);
        $tagihans = Tagihan::whereIn('rekap_dptagihan_id', $rekapdp)->get();
        // dd($tagihans);
        $rekapdp->delete();
        foreach($tagihans as $tagihan){
            $tagihan->update([
                'rekap_dptagihan_id' => null,
            ]);
        }

        return redirect('/rekapdptagihans')->with('success', 'Rekap uang muka deleted!');
    }

    public function cetakrekap(Request $request, $id)
    {
        $rekapdp = RekapDptagihan::find($id);
        // $arrayid = $request->get('tagihan');
        $invoices = Tagihan::where('rekap_dptagihan_id', $rekapdp->id)->get();
        // dd($invoices);
        $lampirans = Lampiran_gambar::where('tagihan_id')->orderBy('id', 'asc')->get();
        $setting = Setting::first();
        // dd($invoices->sum('nominal'));
        $pdf = PDF::loadview('rekapdptagihans.cetakrekap', compact('invoices','lampirans','setting','rekapdp'))->setPaper('a4', 'potrait');
        return $pdf->stream();
        // return view('rekaptagihans.cetakrekap', compact('invoices','lampirans','setting','arrayid','findtagihan'));
    }
    public function detailRekapTagihan($id)
    {
        $tagihan = RekapDptagihan::find($id);
        $html = '
        <table class="table table-striped">
            <tr>
                <td>Langganan</td>
                <td>Ads</td>
                <td>Lainnya</td>
                <td>Sudah Dibayar</td>
                <td>Total Tagihan</td>
            </tr>
            <tr>
                <td>'.number_format($tagihan->langganan,0,',','.').'</td>
                <td>'.number_format($tagihan->ads,0,',','.').'</td>
                <td>'.number_format($tagihan->lainnya,0,',','.').'</td>
                <td>'.number_format($tagihan->jml_bayar,0,',','.').'</td>
                <td>'.number_format($tagihan->jml_tagih,0,',','.').'</td>
            </tr>
        </table>';

        return $tagihan->total;
    }

    public function invalid($id) {
        $rekapdp = RekapDptagihan::find($id);
        $rekapdp->status = 5;
        $rekapdp->update();

        $tagihans = Tagihan::whereIn('rekap_dptagihan_id', $rekapdp)->get();
        // dd($tagihans);
        foreach($tagihans as $tagihan){
            $tagihan->update([
                'rekap_dptagihan_id' => null,
            ]);
        }

        return redirect()->route('rekapdptagihans.index')->with('error', 'Data dijadikan invalid!');
    }

    public function getrekapdp($status) {
        if ($status == 'aktif') {
            $rekapdps = RekapDptagihan::where('status','<','4')->orderByDesc('created_at')->get();
            return Datatables::of($rekapdps)->addIndexColumn()->make(true);
        } else if ($status == 'history') {
            $rekapdps = RekapDptagihan::where('status','>=','4')->orderByDesc('created_at')->get();
            return Datatables::of($rekapdps)->addIndexColumn()->make(true);
        }
    }

}
