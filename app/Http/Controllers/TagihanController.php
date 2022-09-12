<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tagihan;
use App\Model\RekapDptagihan;
use App\Model\RekapTagihan;
use App\Model\User;
use App\Model\Setting;
use App\Model\Nomor;
use App\Model\Proyek;
use App\Model\Lampiran_gambar;
use App\Exports\TagihanExport; //plugin excel
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use PDF;
use Datatables;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //     $tagihans = Tagihan::orderBy('id')->where('status', '!=', '2')->get();
    //   //$proyeks = Proyek::all();
        return view('tagihans.index');
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
            $proyeks = Proyek::find($requestUser);
        }
        else
        {
            $proyeks = '';
        }
        $users = User::where('role','>=',80)->get();
        $users = $users->sortBy('kadaluarsa');
        $penagih = Setting::first();
        $lastno = Nomor::first();
        //dd($proyeks);
        return view('tagihans.create',compact('users','penagih','lastno', 'requestUser', 'proyeks'));
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
            'nominal' => 'required|max:11',
            'uang_muka' => 'max:11',
        ]);

        $data = $request->except(['_token', '_method','select_proyek','masa_berlaku']);

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

        if($request->get('new_mb')==''){
            $data['masa_berlaku'] = $request->get('masa_berlaku');
        }

        if($request->get('new_mb')!=''){
            $data['masa_berlaku'] = $request->get('new_mb');
        }

        if($request->get('jenis_diskon')!=''){
            if($request->get('persen_diskon')!=''){
                $data['diskon'] = $data['persen_diskon'] * $data['nominal'] / 100;
            } else if ($request->get('nominal_diskon')!='') {
                $data['diskon'] = $data['nominal_diskon'];
            }
        }

        if($data['diskon'] != '') {
            $data['jml_tagih'] = $data['nominal'] - $data['uang_muka'] - $data['diskon'];
        } else {
            $data['jml_tagih'] = $data['nominal'] - $data['uang_muka'];
        }
        
        if ($data['jml_tagih'] < 0) {
            return redirect()->back()->with('error', 'Uang muka melebihi nominal!');
        }

        // if ($data['jml_tagih'] > )

        // dd($data);

        $user = User::find($data['user_id']);
        $data['nama'] = $user->nama;

        // dd($data);

        $tagihan = Tagihan::create($data);
        $proyek = Proyek::find($tagihan->id_proyek);
        $proyek->masa_berlaku = $tagihan->masa_berlaku;
        $proyek->save();

        if ($request->buat_rekap == 1) {
            //Tagihan terakhir
            $last_tagihan = Tagihan::all()->last();

            // dd($last_tagihan);

            //Menyimpan data ke rekap dp tagihan
            $rekapdptagihan = new RekapDptagihan;
            $rekapdptagihan->user_id = $user->id;
            $rekapdptagihan->nama = $user->nama;
            $rekapdptagihan->total =  $last_tagihan->uang_muka;
            $rekapdptagihan->status = 2;
            $rekapdptagihan->nama_tertagih = $user->nama;
            $rekapdptagihan->alamat = $user->alamat;
            $rekapdptagihan->jatuh_tempo = $last_tagihan->masa_berlaku ? $last_tagihan->masa_berlaku : date('Y-m-d');

            if ($request->buat_invoice == 1) {
                // FORMAT INVOICE

                $lastno = Nomor::first();
                if ($lastno) {
                    if (isset($lastno->ninv)) {
                        $ninv = $lastno->ninv+1;
                    } else {
                        $ninv = 1;
                    }
                }

                $invoiceno = 01;

                $invawal = "INV";
                $nomorinv = $ninv;
                $noakhir = date('dmY');
                $no = str_pad($nomorinv,3,"0",STR_PAD_LEFT);
                $nomor_invoice = $invawal.'/'.$no.'/'.$noakhir;
                // $lastinv = Tagihan::latest('id')->first();
                $lastinv = $last_tagihan;

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
                $rekapdptagihan->invoice = $nomor_invoice;
            } else {
                $rekapdptagihan->invoice = now();
            }

            $rekapdptagihan->save();

            //Menyimpan date ke rekap tagihan
            $rekaptagihan = new RekapTagihan;
            $rekaptagihan->user_id = $user->id;
            $rekaptagihan->nama = $user->nama;
            $rekaptagihan->total =  $last_tagihan->jml_tagih;
            $rekaptagihan->status = 2;
            $rekaptagihan->nama_tertagih = $user->nama;
            $rekaptagihan->alamat = $user->alamat;
            $rekaptagihan->jatuh_tempo = $last_tagihan->masa_berlaku ? $last_tagihan->masa_berlaku : date('Y-m-d');

            if ($request->buat_invoice == 1) {
                // FORMAT INVOICE

                $lastno = Nomor::first();
                if ($lastno) {
                    if (isset($lastno->ninv)) {
                        $ninv = $lastno->ninv+1;
                    } else {
                        $ninv = 1;
                    }
                }

                $invoiceno = 01;

                $invawal = "INV";
                $nomorinv = $ninv;
                $noakhir = date('dmY');
                $no = str_pad($nomorinv,3,"0",STR_PAD_LEFT);
                $nomor_invoice = $invawal.'/'.$no.'/'.$noakhir;
                // $lastinv = Tagihan::latest('id')->first();
                $lastinv = $last_tagihan;

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
                $rekaptagihan->invoice = $nomor_invoice;
            } else {
                $rekaptagihan->invoice = now();
            }

            $rekaptagihan->save();

            //Memperbarui rekap dp tagihan id dan rekap tagihan id
            $last_rekapdptagihan = RekapDptagihan::all()->last();
            $last_rekaptagihan = RekapTagihan::all()->last();
            $last_tagihan->rekap_dptagihan_id = $last_rekapdptagihan->id;
            $last_tagihan->rekap_tagihan_id = $last_rekaptagihan->id;
            $last_tagihan->update();

            //Memperbarui nilai rekap dp tagihan dan rekap tagihan id ke proyek
            $proyek_id = $last_tagihan->id_proyek;
            $proyeks = Proyek::where('id', $proyek_id)->get();
            foreach ($proyeks as $proyek) {
                $proyek->rekap_dptagihan_id = $last_rekapdptagihan->id;
                $proyek->rekap_tagihan_id = $last_rekaptagihan->id;
                $proyek->update();
            }
        }

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
            'nominal' => 'required|max:11',
            'uang_muka' => 'max:11',
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

        if($request->get('uang_muka')==''){
            $data['uang_muka'] = 0;
        }

        if($request->get('new_mb')!=''){
            $data['masa_berlaku'] = $request->get('new_mb');
        }

        if($request->get('jenis_diskon')!=''){
            if($request->get('persen_diskon')!=''){
                $data['diskon'] = $data['persen_diskon'] * $data['nominal'] / 100;
            } else if ($request->get('nominal_diskon')!='') {
                $data['diskon'] = $data['nominal_diskon'];
            }
        }

        $data['jml_tagih'] = $data['nominal'] - $data['uang_muka'];

        if ($data['jml_tagih'] < 0) {
            return redirect()->back()->with('error', 'Uang muka melebihi nominal!');
        }

        // dd($data);

        $tagihan->update($data);

        $proyek = Proyek::find($tagihan->id_proyek);
        $proyek->masa_berlaku = $tagihan->masa_berlaku;
        $proyek->update();

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

    // public function cetak($id)
    // {
    //     $invoice = Tagihan::find($id);
    //     $lampirans = Lampiran_gambar::where('tagihan_id', $id)->orderBy('id', 'asc')->get();
    //     $setting = Setting::first();
    //     // dd($lampirans);

    //     $pdf = PDF::loadview('tagihans.invoice', compact('invoice','lampirans','setting'))->setPaper('a4', 'potrait');
    //     return $pdf->stream();
    // }

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
        $lampiran = Lampiran_gambar::create([
            'tagihan_id' => $id,
            'gambar' => $data['gambar'],
            'keterangan' => $data['keterangan'],
            'jenis_lampiran' => $data['jenis_lampiran']
        
        ]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tagihan = Tagihan::find($id);

        if($tagihan->rekap_dptagihan_id > 0 || $tagihan->rekap_tagihan_id > 0) {
            return redirect()->back()->with('error', 'Sudah ada invoice penagihan!');
        }
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
        $terbayar = $tagihan->rekapdptagihan->jml_terbayar + $tagihan->rekaptagihan->jml_terbayar;
        $html = '
        <table class="table table-striped">
            <tr>
                <td>Langganan</td>
                <td>Ads</td>
                <td>Lainnya</td>
                <td>Uang Muka</td>
                <td>Total Tagihan</td>
                <td>Sudah Dibayar</td>
            </tr>
            <tr>
                <td>'.number_format($tagihan->langganan,0,',','.').'</td>
                <td>'.number_format($tagihan->ads,0,',','.').'</td>
                <td>'.number_format($tagihan->lainnya,0,',','.').'</td>
                <td>'.number_format($tagihan->uang_muka,0,',','.').'</td>
                <td>'.number_format($tagihan->jml_tagih,0,',','.').'</td>
                <td>'.number_format($terbayar,0,',','.').'</td>
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

    public function gettagihans() {
        $tagihans = Tagihan::orderBy('id', 'desc')
            ->where('status', '!=', '2')
            ->with('user')
            ->with('proyek')
            ->get();
        return Datatables::of($tagihans)->addIndexColumn()->make(true);
    }
}
