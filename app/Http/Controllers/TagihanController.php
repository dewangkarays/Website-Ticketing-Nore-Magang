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
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use PDF;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagihans = Tagihan::orderBy('id')->get();
        $proyeks = Proyek::all();
        return view('tagihans.index', compact('tagihans', 'proyeks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role','>=',80)->get();
        $users = $users->sortBy('kadaluarsa');
        $penagih = Setting::first();
        $lastno = Nomor::first();
        return view('tagihans.create',compact('users','penagih','lastno'));
    }

    public function createtagihan($id)
    {
        $fuser = User::find($id);
        $users = User::where('role','>=',80)->get();
        $users = $users->sortBy('kadaluarsa');
        $proyeks = Proyek::where('user_id',$id)->get();
        $penagih = Setting::first();
        $lastno = Nomor::first();
        // dd($proyeks);
        return view('users.createtagihan',compact('fuser','users','proyeks','penagih','lastno'));
    }

    public function export_excel()
    {
        return Excel::download(new TagihanExport, 'Tagihan '.(date('Y-m-d')).'.xlsx' );
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
        $request->validate([
            'nominal' => 'required',
        ]);

        $data = $request->except(['_token', '_method','noinv','ninv','noakhir','nouser','select_proyek','masa_berlaku']);

        if($request->get('langganan')==''){
            $data['langganan'] = 0;
        }
        if($request->get('ads')==''){
            $data['ads'] = 0;
        }
        if($request->get('lainnya')==''){
            $data['lainnya'] = 0;
        }

        if($request->get('uang_muka')==''){
            $data['uang_muka'] = 0;
        }

        if($request->get('masa_berlaku')!=''){
            $data['masa_berlaku'] = $request->get('masa_berlaku');
        }

        // // FORMAT INVOICE
        // $invoiceno = 01;

        // $invawal = $request->get('noinv');
        // $nomorinv = $request->get('ninv');
        // $noakhir = $request->get('noakhir');
        // $nouser = $request->get('nouser');
        // $no = str_pad($nomorinv,3,"0",STR_PAD_LEFT);
        // $nouserpad = str_pad($nouser,2,"0",STR_PAD_LEFT);
        // $data['invoice'] = $invawal.'/'.$no.'/'.$noakhir.'/'.$nouserpad;
        // // $data['user_id'] = $request->get('user_id');
        // $lastinv = Tagihan::latest('id')->first();

        // // dd($data);

        // if ($lastinv) {
        //     $diffinv = substr($lastinv->invoice,0,3);
        //     if ($diffinv == 'INV') {
        //         $different = 'no';
        //     } else {
        //         $different = 'yes';
        //     }

        //     if ($different == 'yes') {
        //         $lastno = Nomor::first();
        //         if ($lastno) {
        //             $lastno->ninv = $nomorinv;
        //             $lastno->save();
        //         } else {
        //             $lastno['ninv'] = 1;
        //             $lastno = Nomor::create($lastno);
        //         }
        //     } else {
        //         // jika tidak sama
        //         $lastno = Nomor::first();
        //         if ($lastno) {
        //             $lastno->ninv = $nomorinv;
        //             $lastno->save();
        //         } else {
        //             $lastno['ninv'] = 1;
        //             $lastno = Nomor::create($lastno);
        //         }
        //     }

        // } else {
        //     $lastno = Nomor::first();
        //     if ($lastno) {
        //         $lastno->ninv = $nomorinv;
        //         $lastno->save();
        //     } else {
        //         $lastno['ninv'] = 1;
        //         $lastno = Nomor::create($lastno);
        //     }
        // }

        $data['jml_tagih'] = $data['nominal'] - $data['uang_muka'];
        
        $user = User::find($data['user_id']);
        $data['nama'] = $user->nama;

        // dd($data);

        $tagihan = Tagihan::create($data);
        $proyek = Proyek::find($tagihan->id_proyek);
        $proyek->masa_berlaku = $proyek->tagihan->masa_berlaku;
        $proyek->save();

        return redirect('/tagihans')->with('success', 'Tagihan saved!');
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
        $users = User::where('role','>=',80)->get();
        $tagihan = Tagihan::find($id);
        $penagih = Setting::first();
        // $gambar = Lampiran_gambar::where('tagihan_id',$tagihan->id);
        // dd($tagihan->proyek->jenis_layanan);
        return view('tagihans.edit', compact('tagihan','users','penagih'));
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
            //
        ]);

        $data = $request->except(['_token', '_method','masa_berlaku']);
        $tagihan = Tagihan::find($id);
        if($request->get('langganan')==''){
            $data['langganan'] = 0;
        }
        if($request->get('ads')==''){
            $data['ads'] = 0;
        }
        if($request->get('lainnya')==''){
            $data['lainnya'] = 0;
        }

        if($request->get('uang_muka')!=''){
            $data['uang_muka'] = $request->get('uang_muka');
        }

        if($request->get('masa_berlaku')!=''){
            $data['masa_berlaku'] = $request->get('masa_berlaku');
        }

        $data['jml_tagih'] = $data['nominal'] - $data['uang_muka'];

        // dd($data);

        $tagihan->update($data);

        $proyek = Proyek::find($tagihan->id_proyek);
        $proyek->masa_berlaku = $proyek->tagihan->masa_berlaku;
        $proyek->save();

        return redirect('/tagihans')->with('success', 'Tagihan updated!');
    }

    public function getweb($id)
    {
        $data = User::find($id);
        // dd($data['website']);
        $web = $data['website'];
        return $web;
    }

    public function getkadaluarsa($nama_proyek)
    {
        $data = User::find($nama_proyek);
        $kadaluarsa = $data['kadaluarsa'];
        return $kadaluarsa;
    }

    public function getmasa_berlaku($id)
    {
        $data = Proyek::find($id);
        $masa_berlaku = $data['masa_berlaku'];
        return $masa_berlaku;
    }

    public function getproyek($id)
    {
        $proyek['data'] = Proyek::where('user_id',$id)->get();
        // $proyek = $data['proyek'];
        // dd($data);
        return response()->json($proyek);

    }

    public function cetak($id)
    {
        $invoice = Tagihan::find($id);
        $lampirans = Lampiran_gambar::where('tagihan_id', $id)->orderBy('id', 'asc')->get();
        $setting = Setting::first();
        // dd($lampirans);

        $pdf = PDF::loadview('tagihans.invoice', compact('invoice','lampirans','setting'))->setPaper('a4', 'potrait');
        return $pdf->stream();
    }

    public function lampiran(Request $request,$id)
    {
        if ($request->isMethod('GET')) {
            $tagihan = Tagihan::find($id);
            $lampirans = Lampiran_gambar::where('tagihan_id', $id)->orderBy('id', 'desc')->get();
            // dd($lampirans);
            return view('tagihans.lampiran', compact('tagihan', 'lampirans'));
        }

        if ($request->isMethod('POST')) {
        $data = $request->except(['_token', '_method','gambar']);
        // $tagihan = Tagihan::find($id);
        // dd($tagihan);

        $tujuan_upload = config('app.upload_url').'attachment/lampiran';
        $file = $request->file('gambar');
        if($file){
                $name = \Auth::user()->id."_".time().".".$file->getClientOriginalName();
                // $name = \Auth::user()->id."_".time().".".$file->getClientOriginalExtension();
                $up1 = $file->move($tujuan_upload,$name);
                if($up1){
                    $data['gambar'] = $tujuan_upload.'/'.$name;
                }
        }

        Lampiran_gambar::create([
            'tagihan_id' => $id,
            'gambar' => $data['gambar'],
            'keterangan' => $data['keterangan']

        ]);
        }

        return redirect()->back()->with('success', 'File uploaded!');

    }

    public function lampirandestroy(Request $request,$id,$idm)
    {
        $data = $request->except(['_token', '_method']);
        $lampiran = Lampiran_gambar::find($id);
        $path = $lampiran->gambar;
        // dd($idm);

        if(File::exists($path)) {
            File::delete($path);
        }

        $lampiran->delete();

        return redirect()->back()->with('success', 'File deleted!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tagihan = Tagihan::find($id);
        $tagihan->delete();

        return redirect('/tagihans')->with('success', 'Tagihan deleted!');
    }

    public function getTagihan($id)
    {
        $tagihans = Tagihan::where('user_id', $id)->get();
        $html = '<option value="">-- Pilih Tagihan --</option>';
        foreach ($tagihans as $tagihan) {
            $html .= '<option value="'.$tagihan->id.'" data-tagihan="'.$tagihan->jml_tagih.'" >'.$tagihan->invoice.' ('.number_format($tagihan->jml_tagih,0,',','.').')</option>';
        }

        return $html;
    }

    public function detailTagihan($id)
    {
        $tagihan = Tagihan::find($id);
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

        return $html;
    }

    public function tagihanuser()
    {
        $tagihans = Tagihan::where('user_id',\Auth::user()->id)->get( );

        return view('tagihanuser', compact('tagihans'));
    }

    public function bayaruser($id)
    {
        $tagihanuser = Tagihan::where('user_id',\Auth::user()->id)->get( );
        $users = User::where('role','>=',80)->get();
        $tagihanuser2 = Tagihan::find($id);
        // dd($tagihanuser2);
        // dd($tagihan);
        $setting = Setting::first();
        return view('payments.create', compact('users', 'tagihanuser', 'tagihanuser2', 'setting'));
    }

    public function createrekaptagihan()
    {
        $users = User::where('role','>=',80)->get();
        $users = $users->sortBy('kadaluarsa');
        $penagih = Setting::first();
        $lastno = Nomor::first();
        return view('rekaptagihans.create',compact('users','penagih','lastno'));
    }
    
    public function rekaptagihan(Request $request)
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
        return view('rekaptagihans.index', compact('users','tagihans','requestUser'));
    }
}
