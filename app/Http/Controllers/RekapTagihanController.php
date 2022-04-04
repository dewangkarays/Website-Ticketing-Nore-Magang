<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tagihan;
use App\Model\User;
use App\Model\Setting;
use App\Model\Nomor;
use App\Model\Proyek;
use App\Model\Lampiran_gambar;
use App\Exports\TagihanExport; //plugin excel
use App\Model\RekapTagihan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use PDF;

class RekapTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekaptagihans = RekapTagihan::orderBy('jatuh_tempo')->get();
        $tagihans = Tagihan::all();
        $users = User::where('role','>=','80')->get();
        return view('rekaptagihans.index', compact('rekaptagihans','tagihans', 'users'));
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
            $tagihans = Tagihan::where('user_id',$requestUser)->orderBy('id')->get();
        }
        else
        {
            $tagihans = Tagihan::orderBy('id')->get();
        }
        $users = User::where('role','>=',80)->get();
        $users = $users->sortBy('kadaluarsa');
        $penagih = Setting::first();
        $lastno = Nomor::first();
        return view('rekaptagihans.create',compact('users','penagih','lastno','requestUser','tagihans'));
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

        $data = $request->except(['_token', '_method','noinv','ninv','noakhir','nouser','tagihan_id']);

        // FORMAT INVOICE
        $invoiceno = 01;

        $invawal = $request->get('noinv');
        $nomorinv = $request->get('ninv');
        $noakhir = $request->get('noakhir');
        $nouser = $request->get('nouser');
        $no = str_pad($nomorinv,3,"0",STR_PAD_LEFT);
        $nouserpad = str_pad($nouser,2,"0",STR_PAD_LEFT);
        $data['invoice'] = $invawal.'/'.$no.'/'.$noakhir.'/'.$nouserpad;
        // $data['user_id'] = $request->get('user_id');
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

        $arrayid = $request->get('tagihan_id');
        $findtagihan = Tagihan::whereIn('id', $arrayid)->get();
        $finduser = Tagihan::whereIn('user_id', $findtagihan)->get();
        $data['tagihan_id'] = $findtagihan;
        dd($data);

        $rekaptagihan = RekapTagihan::create($data);
        // dd($data);
        $rekaptagihan->save();

        return redirect('/rekaptagihans')->with('success', 'Rekap Tagihan saved!');
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

    public function cetakrekap(Request $request)
    {
        $arrayid = $request->get('tagihan');
        $findtagihan = Tagihan::whereIn('id', $arrayid)->get();
        $invoices = $findtagihan;
        $lampirans = Lampiran_gambar::where('tagihan_id')->orderBy('id', 'asc')->get();
        $setting = Setting::first();
        // dd($invoices->sum('nominal'));
        $pdf = PDF::loadview('rekaptagihans.cetakrekap', compact('invoices','lampirans','setting','arrayid','findtagihan'))->setPaper('a4', 'potrait');
        return $pdf->stream();
        // return view('rekaptagihans.cetakrekap', compact('invoices','lampirans','setting','arrayid','findtagihan'));
    }
    public function createrekap(Request $request)
    {
        $requestUser = '';
        if($request->get('c'))
        {
            $requestUser = $request->get('c');
            $tagihans = Tagihan::where('user_id',$requestUser)->orderBy('id')->get();
        }
        else
        {
            $tagihans = Tagihan::orderBy('id')->get();
        }
        $users = User::where('role','>=',80)->get();
        return view('rekaptagihans.create', compact('requestUser','tagihans','users'));
    }
}
