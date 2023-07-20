<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Model\User;
use App\Model\Klien;
use App\Model\Proyek;
use App\Model\Historyklien;
use App\Model\Nomor;
use App\Model\Tagihan;
use App\Model\RekapDptagihan;
use App\Model\RekapTagihan;
use App\Exports\KlienExport; //plugin excel
use Maatwebsite\Excel\Facades\Excel;
use Datatables;


class KlienController extends Controller
{
    public function index(Request $request)
    {
        $marketings = User::where('role', '50')->get();
        return view('klien.index', compact('marketings'));
    }

    public function getData(Request $request)
    {
      
        if(\Auth::user()->role==1 || \Auth::user()->role==20){
            $json_data = Klien::where('member_created',false)
            ->orderBy('id', 'desc')
            ->with('marketing')
            ->get();
        }else{
            $json_data = Klien::where('member_created',false)
            ->where('marketing_id','=',\Auth::user()->id)
            ->orderBy('id', 'desc')
            ->with('marketing')
            ->get();
        }
        // return json_encode($json_data);
        return Datatables::of($json_data)->addIndexColumn()->make(true);
    }

    //CREATE
    public function create(Request $request)
    {
        $marketings = User::where('role', '50')->get();
        return view('klien.create', compact('marketings'));
    }

    public function saveCreate(Request $request)
    {

        $validatedData = $request->validate([
            'status' => 'required',
            'telp'   => 'required',
            'alamat' => 'required',
          ],
        [
            'status.required'=>'Status lead mohon diisi',
            'telp.required'  =>'Nomor telp mohon diisi',
            'alamat.required'=>'Alamat mohon diisi'
        ]);
        
        
        $klien = new Klien;
        $klien->nama_calonklien         = $request->nama_calonklien;
        $klien->nama_perusahaan         = $request->nama_perusahaan;
        $klien->jenis_perusahaan        = $request->jenis_perusahaan;
        $klien->potensi                 = $request->potensi;
        $klien->tanggal_kontakpertama   = $request->tanggal_kontakpertama;
        $klien->tanggal_kontakterakhir  = $request->tanggal_kontakterakhir;
        $klien->status                  = $request->status;
        $klien->telp                    = $request->telp;
        $klien->alamat                  = $request->alamat;
        $klien->marketing_id            = $request->marketing_id;
        $klien->source                  = $request->source;
        $klien->keterangan_lain         = $request->keterangan_lain;

        $klien->save();

        $klien = Klien::latest()->first();
        $history                = new Historyklien();
        $history->created_at    = $klien->created_at;
        $history->status        = $request->status;
        $history->klien_id      = $klien->id;
        $history->keterangan    = $request->keterangan_lain;
        $history->save();
        return redirect('/klien')->with('success', 'Klien saved!');
    }

    //Show
    public function show($id)
    {
        $klien = Klien::find($id);
        return view('klien.show', compact('klien'));
    }

    //DELETE
    public function delete($id)
    {
        $klien = Klien::find($id);
        $klien->delete();

        return redirect('/klien')->with('success', 'Klien deleted!');
    }

    //EDIT
    public function edit($id)
    {
        $klien = Klien::find($id);
        $marketings = User::where('role', '50')->get();
        return view('klien.edit', compact('klien', 'marketings'));
    }

    public function saveEdit(Request $request, $id)
    {
        $klien = Klien::find($id);
        $klien->nama_calonklien              = $request->nama_calonklien;
        $klien->nama_perusahaan              = $request->nama_perusahaan;
        $klien->jenis_perusahaan             = $request->jenis_perusahaan;
        $klien->potensi                      = $request->potensi;
        $klien->tanggal_kontakpertama        = $request->tanggal_kontakpertama;
        $klien->tanggal_kontakterakhir       = $request->tanggal_kontakterakhir;
        $klien->status                       = $request->status;
        $klien->telp                         = $request->telp;
        $klien->source                       = $request->source;
        $klien->alamat                       = $request->alamat;
        $klien->keterangan_lain              = $request->keterangan_lain;
        $klien->marketing_id                 = $request->marketing_id;


        $klien->save();

        if($klien->status==4){
            return $this->createMember($id);
        }
        
        return redirect('/klien')->with('success', 'Klien updated!');
    }

    public function KlienHistory(Request $request, $id)
    {
      
        
        $klien   = Klien::find($id);
        $tanggal = date('Y-m-d');


        $tanggal                = date('Y-m-d');
        $history                = new Historyklien();
        $history->created_at    = $tanggal;
        $history->status        = $request->status;
        $history->klien_id      = $klien->id;
        $history->keterangan    = $request->keterangan_lain;
        $history->save();
        
        

        $klien->updated_at                   = $request->updated_at;
        $klien->status                       = $request->status;
        $klien->keterangan_lain              = $request->keterangan_lain;

        $klien->save();

        if($klien->status==4){
            return $this->createMember($id);
        }
        return redirect('/klien')->with('success', 'Klien updated!');
    }

    public function getdatahistory(Request $request, $id)
    {
        // dd($id);
        $history = Historyklien::where('klien_id', $id)
                    ->orderByDesc('updated_at')
                    ->get();

       
        return response()->json($history);
    }

    //createMember
    public function createMember($id)
    {
        $klien = Klien::find($id);
        $marketings = User::where('role', '50')->get();
        $lastno = Nomor::first();
        return view('klien.createmember', compact('klien', 'marketings'));
    }

    public function savecreateMember(Request $request, $id)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            'username'=>'unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        if ($request->get('email') != null) {
            $validator = Validator::make($request->all(), [
                'email'=>'unique:users',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
        }

        if ($request->get('telp') != null) {
            $validator = Validator::make($request->all(), [
                'telp'=>'unique:users',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }
        }

        $user = new User([
            'nama'         => $request->get('nama_calonklien'),
            'email'        => $request->get('email'),
            'telp'         => $request->get('telp'),
            'alamat'       => $request->get('alamat'),
            'username'     => $request->get('username'),
            'password'     => bcrypt($request->get('password')),
            'role'         => 95,
            'marketing_id' => $request->get('marketing_id'),
        ]);

        $user->save();


        if ($request->jl_web != '') {
            $jenislayanan = $request->jl_web;
        } else if ($request->jl_app != '') {
            $jenislayanan = $request->jl_app;
        } else if ($request->jl_ulo != '') {
            $jenislayanan = $request->jl_ulo;
        } else if ($request->null == '') {
            $jenislayanan = $request->null;
        }

        if ($request->tipe_web != '') {
            $kelaslayanan = $request->tipe_web;
        } else if ($request->tipe_app != '') {
            $kelaslayanan = $request->tipe_app;
        } else if ($request->tipe_ulo != '') {
            $kelaslayanan = $request->tipe_ulo;
        } else if ($request->null == '') {
            $kelaslayanan = $request->null;
        }

        $proyek = new Proyek([
            'user_id'       => $user->id,
            'nama_proyek'   => $request->get('nama_proyek'),
            'website'       => $request->get('website'),
            'jenis_proyek'  => $request->get('jenis_proyek'),
            'jenis_layanan' => $jenislayanan,
            'tipe'          => $kelaslayanan,
            'masa_berlaku'  => $request->get('masa_berlaku'),
            'task_count'    => $request->get('task_count'),
            'keterangan'    => $request->get('keterangan'),
            'marketing_id'  => $request->get('marketing_id'),
           
        ]);

        $proyek->save();

        // $request->validate([
        //     'nominal' => 'required|max:11',
        //     'uang_muka' => 'max:11',
        // ]);

        $tagihan = new Tagihan([
            'user_id'       => $user->id,
            'id_proyek'     => $proyek->id,
            'masa_berlaku'  => $request->get('masa_berlaku'),
            'nominal'       => $request->get('nominal'),
            'jml_tagih'     => $request->get('nominal'),
            'uang_muka'     => $request->get('uang_muka'),
 
        ]);

        $tagihan->save();

        if ($request->buat_rekap == 1) {
            //Tagihan terakhir
            $last_tagihan = Tagihan::all()->last();

            // dd($last_tagihan);

            if ($last_tagihan->uang_muka > 0) {
                //Menyimpan data ke rekap dp tagihan
                $rekapdptagihan = new RekapDptagihan;
                $rekapdptagihan->user_id = $user->id;
                $rekapdptagihan->nama = $user->nama;
                $rekapdptagihan->total =  $last_tagihan->uang_muka;
                $rekapdptagihan->status = 2;
                $rekapdptagihan->nama_tertagih = $user->nama;
                $rekapdptagihan->alamat = $user->alamat ? $user->alamat : "-";
                $rekapdptagihan->jatuh_tempo = date('Y-m-d', strtotime(date('y:m:d') . '+7 days'));
                $rekapdptagihan->nama_proyek = $tagihan->proyek->nama_proyek . '<br>';

                if ($request->buat_invoice == 1) {
                    // FORMAT INVOICE

                    $lastno = Nomor::first();
                    if ($lastno) {
                        if (isset($lastno->ninv)) {
                            $ninv = $lastno->ninv + 1;
                        } else {
                            $ninv = 1;
                        }
                    }

                    $invoiceno = 01;

                    $invawal = "INV";
                    $nomorinv = $ninv;
                    $noakhir = date('dmY');
                    $no = str_pad($nomorinv, 3, "0", STR_PAD_LEFT);
                    $nomor_invoice = $invawal . '/' . $no . '/' . $noakhir;
                    // $lastinv = Tagihan::latest('id')->first();
                    $lastinv = $last_tagihan;

                    // dd($data);

                    if ($lastinv) {
                        $diffinv = substr($lastinv->invoice, 0, 3);
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
            }

            //Menyimpan date ke rekap tagihan
            $rekaptagihan = new RekapTagihan;
            $rekaptagihan->user_id = $user->id;
            $rekaptagihan->nama = $user->nama;
            $rekaptagihan->total =  $last_tagihan->jml_tagih;
            $rekaptagihan->status = 2;
            $rekaptagihan->nama_tertagih = $user->nama;
            $rekaptagihan->alamat = $user->alamat ? $user->alamat : "-";
            $rekaptagihan->jatuh_tempo = date('Y-m-d', strtotime(date('y:m:d') . '+7 days'));
            $rekaptagihan->nama_proyek = $tagihan->proyek->nama_proyek . '<br>';

            if ($request->buat_invoice == 1) {
                // FORMAT INVOICE

                $lastno = Nomor::first();
                if ($lastno) {
                    if (isset($lastno->ninv)) {
                        $ninv = $lastno->ninv + 1;
                    } else {
                        $ninv = 1;
                    }
                }

                $invoiceno = 01;

                $invawal = "INV";
                $nomorinv = $ninv;
                $noakhir = date('dmY');
                $no = str_pad($nomorinv, 3, "0", STR_PAD_LEFT);
                $nomor_invoice = $invawal . '/' . $no . '/' . $noakhir;
                // $lastinv = Tagihan::latest('id')->first();
                $lastinv = $last_tagihan;

                // dd($data);

                if ($lastinv) {
                    $diffinv = substr($lastinv->invoice, 0, 3);
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
            if ($last_tagihan->uang_muka > 0) {
                $last_tagihan->rekap_dptagihan_id = $last_rekapdptagihan->id;
            }
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


        $klien = Klien::find($id);
        $klien->update([
            'member_created' => true
        ]);
        return redirect('/members')->with('success', 'Member & Proyek saved!');
    }

    public function leads_excel()
    {
        return Excel::download(new KlienExport, 'Leads ' . (date('Y-m-d')) . '.xlsx');
    }
}
