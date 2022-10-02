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
use Illuminate\Support\Facades\File;
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
            $tagihans = Tagihan::where('user_id',$requestUser)
            ->where('uang_muka','>',0)
            ->where(function ($q) {
                $q->whereNull('rekap_dptagihan_id')
                    ->orWhere('status_rekapdp', '5');
            })
            ->orderBy('id')
            ->get();
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

        // dd($data);
        
        $rekapdptagihan = RekapDptagihan::create($data);
        $rekapdptagihan->save();
        foreach($tagihans as $tagihan){
            $tagihan->status_rekapdp = 1;
            $tagihan->rekap_dptagihan_id = $rekapdptagihan->id;
            $tagihan->update();

            // $proyek_id = $tagihan->id_proyek;
            // $proyeks = Proyek::where('id', $proyek_id)->get();
            // foreach ($proyeks as $proyek) {
            //     $proyek->update([
            //         'rekap_dptagihan_id' => $rekapdptagihan->id,
            //     ]);
            // }

            $rekapdptagihan->nama_proyek = $rekapdptagihan->nama_proyek.$tagihan->proyek->nama_proyek.'<br>';
        }

        $rekapdptagihan->update();

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
        $lampirans = Lampiran_gambar::where('rekap_dptagihan_id', $rekapdp->id)->orderBy('jenis_lampiran', 'asc')->get();
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
        // $historyProyek = '';
        $rekapdp = RekapDptagihan::find($id);
        $tagihans = Tagihan::where('rekap_dptagihan_id', $id)->get();

        foreach($tagihans as $tagihan){
            // $historyProyek = $historyProyek.$tagihan->proyek->nama_proyek.'<br>';

            $tagihan->update([
                'status_rekapdp' => 5,
            ]);
        }

        $rekapdp->status = 5;
        // $rekapdp->history_proyek = $historyProyek;
        $rekapdp->update();

        return redirect()->route('rekapdptagihans.index')->with('error', 'Data dijadikan invalid!');
    }

    public function lampiran(Request $request,$id)
    {
        // $this->validate($request, [
        //     'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg',
        // ]);
        $request->validate([
            'gambar' => 'mimes:jpeg,png,jpg,gif,svg',
            'jenis_lampiran =>required'
        ]);

        if ($request->isMethod('GET')) {
            $rekapdp = RekapDptagihan::find($id);
            $lampirans = Lampiran_gambar::where('rekap_dptagihan_id', $id)->orderBy('id', 'desc')->get();
            // dd($lampirans);
            return view('rekapdptagihans.lampiran', compact('rekapdp', 'lampirans'));
        }

        if ($request->isMethod('POST')) {
        $data = $request->except(['_token', '_method','gambar']);
        // $tagihan = Tagihan::find($id);
        // dd($tagihan);

        $tujuan_upload = config('app.upload_url').'attachment/lampiran';
        $file = $request->file('gambar');
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
                if($img){
                    $data['gambar'] = $tujuan_upload.'/'.$name;
                }
        }
        
        //upload data lampiran to database
        if($request->judul != null)
        {
        $lampiran = Lampiran_gambar::create([
            'rekap_dptagihan_id' => $id,
            'gambar' => $data['gambar'],
            'keterangan' => $data['keterangan'],
            'judul' => $data['judul'],
            'jenis_lampiran' => $data['jenis_lampiran']
        
        ]);
        }
        else
        {
        $lampiran = Lampiran_gambar::create([
            'rekap_dptagihan_id' => $id,
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

    public function getrekapdp($status) {
        if ($status == 'aktif') {
            $rekapdps = RekapDptagihan::where('status','<','4')
                ->orderByDesc('id')
                ->get();
        } else if ($status == 'history') {
            $rekapdps = RekapDptagihan::where('status','>=','4')
                ->orderByDesc('updated_at')
                ->get();
        }

        return Datatables::of($rekapdps)->addIndexColumn()->make(true);
    }

}
