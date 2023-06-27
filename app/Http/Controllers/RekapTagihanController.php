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
use App\Model\Payment;
use App\Model\RekapTagihan;
use App\Model\RekapDptagihan;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use PDF;
use Illuminate\Support\Facades\Validator;
use LDAP\Result;
use Datatables;

class RekapTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekaptagihans = RekapTagihan::where('status','<','4')->orderByDesc('created_at')->get();
        $tagihans = Tagihan::all();
        $users = User::where('role','>=','80')->get();
        return view('rekaptagihans.index', compact('rekaptagihans','tagihans', 'users'));
    }

    public function history()
    {
        $rekaptagihans = RekapTagihan::where('status','>=','4')->orderByDesc('created_at')->get();
        $tagihans = Tagihan::all();
        $users = User::where('role','>=','80')->get();
        return view('rekaptagihans.history', compact('rekaptagihans','tagihans', 'users'));
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
            $tagihans = Tagihan::where('user_id',$requestUser)
            ->where(function ($q) {
                $q->whereNull('rekap_tagihan_id')
                    ->orWhere('status_rekap', '5');
            })
            ->orderBy('id')
            ->get();
        }
        else
        {
            $tagihans = Tagihan::orderBy('id')->get();
        }
        $users = User::where('role','>=',80)->get();
        $users = $users->sortBy('nama');
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
        // $request->validate([
        //     'ninv'=>'bail|unique:nomors|required',
        // ]);

        $data = $request->except(['_token', '_method','noinv','ninv','noakhir','tagihan_id']);

        $arrayid = $request->get('tagihan_id');
        $findtagihan = Tagihan::whereIn('id', $arrayid)->get();
        $tagihans = $findtagihan;
        $finduser = User::find($data['user_id']);
        $data['nama'] = $finduser->nama;
        $data['total'] = $tagihans->sum('jml_tagih');
        $data['uang_muka'] = $tagihans->sum('uang_muka');
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
        // $data['user_id'] = $request->get('user_id');
        // $lastinv = Tagihan::latest('id')->first();

        $lastno = Nomor::first();
        $lastno->ninv = $nomorinv;
        $lastno->update();

        // dd($data);

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
        $nomor_invoices = RekapTagihan::select('invoice')->get();

        foreach ($nomor_invoices as $nomor_invoice) {
            if ($data['invoice'] == $nomor_invoice->invoice) {
                return redirect()->back()->with('error', 'Nomor invoice sudah diambil, silakan masukan ulang!');
            }
        }

        // dd($data);
        $rekaptagihan = RekapTagihan::create($data);
        $rekaptagihan->save();
        foreach($tagihans as $tagihan){
            $tagihan->status_rekap = 1;
            $tagihan->rekap_tagihan_id = $rekaptagihan->id;
            $tagihan->update();

            // $proyek_id = $tagihan->id_proyek;
            // $proyeks = Proyek::where('id', $proyek_id)->get();
            // foreach ($proyeks as $proyek) {
            //     $proyek->update([
            //         'rekap_tagihan_id' => $rekaptagihan->id,
            //     ]);
            // }
            $rekaptagihan->nama_proyek = $rekaptagihan->nama_proyek.$tagihan->proyek->nama_proyek.'<br>';
        }

        $rekaptagihan->update();

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
        $rekaptagihan = RekapTagihan::find($id);
        $tagihans = Tagihan::where('rekap_tagihan_id', $id)->get();
        return view('rekaptagihans.show', compact('rekaptagihan','tagihans'));
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

        $tagihans = Tagihan::where('rekap_tagihan_id', $id)->get();
        // dd($tagihans);
        // if($request->get('jml_terbayar')!=''){
        //     $data['jml_terbayar'] = $request->get('jml_terbayar');
        // }
        $data['status'] = $request->get('status');

        // dd($data);

        $rekaptagihan = RekapTagihan::where('id',$id)->first();

        // foreach ($tagihans as $tagihan)
        // {
        // $langganan = Proyek::where('user_id', $tagihan->user_id)
        //                 ->where('jenis_layanan','=','3') //jumlah langganan
        //                 ->count();
        // $ads = Proyek::where('user_id', $tagihan->user_id)
        //                 ->where('jenis_proyek','=','2') //jumlah ads
        //                 ->count();
        // $lainnya = Proyek::where('user_id', $tagihan->user_id)
        //                 ->where('jenis_proyek','=','5') //jumlah lainnya
        //                 ->count();

        // dd($rekaptagihan);

        if(!$rekaptagihan->payment->isEmpty()){
            $rekaptagihan->status = $request->get('status');
            if($rekaptagihan->isDirty('status')){
                return redirect()->back()
                ->with('error','Tidak bisa mengubah status, rekap ini memiliki data pembayaran.');
            }
            else{
                // $tagihan->langganan = $langganan;
                // $tagihan->ads = $ads;
                // $tagihan->lainnya = $lainnya;
                // $tagihan->invoice = $rekaptagihan->invoice;
                // $tagihan->save();
                $rekaptagihan->update($data);
                return redirect('/rekaptagihans')->with('success', 'Rekap Tagihan updated!');
            }
        }
        else{
            // $tagihan->langganan = $langganan;
            // $tagihan->ads = $ads;
            // $tagihan->lainnya = $lainnya;
            // $tagihan->invoice = $rekaptagihan->invoice;
            // // dd($tagihans);
            // $tagihan->save();
            $rekaptagihan->update($data);
            return redirect('/rekaptagihans')->with('success', 'Rekap Tagihan updated!');
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
        $rekaptagihan = RekapTagihan::find($id);
        $tagihans = Tagihan::whereIn('rekap_tagihan_id', $rekaptagihan)->get();
        // dd($tagihans);
        $rekaptagihan->delete();
        foreach($tagihans as $tagihan){
            $tagihan->update([
                'rekap_tagihan_id' => null,
            ]);
        }

        return redirect('/rekaptagihans')->with('success', 'Rekap tagihan deleted!');
    }

    public function cetakrekap(Request $request, $id)
    {
        $rekap = RekapTagihan::find($id);
        // $arrayid = $request->get('tagihan');
        $invoices = Tagihan::where('rekap_tagihan_id', $rekap->id)->get();
        // dd($rekap);
        $lampirans = Lampiran_gambar::where('rekap_tagihan_id', $rekap->id)->orderBy('jenis_lampiran', 'desc')->get();
        // dd($lampirans)
        $setting = Setting::first();
        // dd(count($lampirans));
        $pdf = PDF::loadview('rekaptagihans.cetakrekap', compact('invoices','lampirans','setting','rekap'))->setPaper('a4', 'potrait');
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

    public function getRekapTagihan($id)
    {
        $rekaptagihans = RekapTagihan::where('user_id', $id)->get();
        $html = '<option value="">-- Pilih Tagihan --</option>';
        foreach ($rekaptagihans as $tagihan) {
            $html .= '<option value="'.$tagihan->id.'" data-tagihan="'.$tagihan->total.'" >'.$tagihan->invoice.' ('.number_format($tagihan->total,0,',','.').')</option>';
        }

        return $html;
    }

    public function getRadBox(Request $request)
    {
        // return $request;
        $user_id = $request->user_id;
        if($request->rad == 1){
            $rekaptagihans = RekapTagihan::where('user_id', $user_id)
                ->whereIn('status', [2,3])->get();
            // dd($rekaptagihans);
            $html = '<option value="">-- Pilih Tagihan --</option>';
            foreach ($rekaptagihans as $tagihan) {
                $html .= '<option value="'.$tagihan->id.'" data-tagihan="'.$tagihan->total.'" data-jmlbayar="'.@$tagihan->jml_terbayar.'">'.$tagihan->invoice.' ('.number_format($tagihan->total,0,',','.').')</option>';
            }
        }
        elseif($request->rad == 2){
            $rekaptagihans = RekapDptagihan::where('user_id', $request->user_id)
                ->whereIn('status', [2,3])->get();
            $html = '<option value="">-- Pilih Tagihan --</option>';
            foreach ($rekaptagihans as $tagihan) {
                $html .= '<option value="'.$tagihan->id.'" data-tagihan="'.$tagihan->total.'" data-jmlbayar="'.@$tagihan->jml_terbayar.'">'.$tagihan->invoice.' ('.number_format($tagihan->total,0,',','.').')</option>';
            }
        }
        else{
            $html = '<option value="">-- Pilih Tagihan --</option>';
        }
        return $html;
    }
    public function detailRekapTagihan(Request $request, $id)
    {
        if($request->rad == 1){
            $tagihan = RekapTagihan::find($id);
        }
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

    public function invalid($id) {
        // $historyProyek = '';
        $rekap = RekapTagihan::find($id);
        $tagihans = Tagihan::where('rekap_tagihan_id', $id)->get();

        foreach($tagihans as $tagihan){
            $tagihan->rekap_tagihan_id = null;
            $tagihan->status_rekap = 5;

            $tagihan->update();
        }

        $rekap->status = 5;
        // $rekap->history_proyek = $historyProyek;
        $rekap->update();

        return redirect()->route('rekaptagihans.index')->with('error', 'Data dijadikan invalid!');
    }

    public function lampiran(Request $request,$id)
    {
        // $this->validate($request, [
        //     'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        // $request->validate([
        //     'gambar' => 'mimes:jpeg,png,jpg,gif,svg,application/pdf',
        //     // 'jenis_lampiran' =>'required',
        // ]);
        //  dd($request);
        if ($request->isMethod('GET')) {
            $rekap = RekapTagihan::find($id);
            $lampirans = Lampiran_gambar::where('rekap_tagihan_id', $id)->orderBy('id', 'desc')->get();
            // dd($lampirans);
            return view('rekaptagihans.lampiran', compact('rekap', 'lampirans'));
        }

        if ($request->isMethod('POST')) {
        $data = $request->except(['_token', '_method','gambar']);
        // $tagihan = Tagihan::find($id);
        // dd($data);

        $tujuan_upload = config('app.upload_url').'attachment/lampiran';
        $file = $request->file('gambar');
        // dd($file->getMimeType());
        if($file){
                $name = \Auth::user()->id."_".time().".".$file->getClientOriginalName();
                // $destinationPath = public_path('/thumbnail');
                if($file->getMimeType()=='application/pdf'){
                    $file->move($tujuan_upload,$name);
                    $data['gambar'] = $tujuan_upload.'/'.$name;
                
                }else{
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
                    if($img){
                        $data['gambar'] = $tujuan_upload.'/'.$name;
                    }
                }
    
        }
        // dd($request);
        //upload data lampiran to database
        if($request->judul != null)
        {
            $lampiran = Lampiran_gambar::create([
                'rekap_tagihan_id' => $id,
                'gambar' => $data['gambar'],
                'keterangan' => $data['keterangan'],
                'judul' => $data['judul'],
                'jenis_lampiran' => $data['jenis_lampiran']
        
        ]);
        }else{
            $lampiran = Lampiran_gambar::create([
                'rekap_tagihan_id' => $id,
                'gambar' => $data['gambar'],
                'keterangan' => $data['keterangan'],
                'jenis_lampiran' => $data['jenis_lampiran']
        
        ]);
        }
        $lampiran->save();  
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

    public function getrekap($status) {
        if ($status == 'aktif') {
            $rekaptagihans = RekapTagihan::where('status','<','4')
                ->orderByDesc('id')
                ->get();
        } else if ($status == 'history') {
            $rekaptagihans = RekapTagihan::where('status','>=','4')
                ->orderByDesc('updated_at')
                ->get();
        }
        return Datatables::of($rekaptagihans)->addIndexColumn()->make(true);
    }
}
