<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Collection;

use App\Model\Cuti;
use App\Model\User;
use Carbon\Carbon;
use App\Model\Setting;
use Auth;
use Dotenv\Regex\Success;
use Datatables;
use PDF;


class CutiController extends Controller
{
    public function index() {
        //tampilan index menggunakan serverside datatables
        return view('cuti.index');
    }

    public function create() {
        $users = User::where('id', '=', \Auth::user()->id)->get();
        $karyawans = User::where('role','<=','20')->get();
        // dd($karyawans);
        return view('cuti.create', compact('users','karyawans'));
    }

    public function store(Request $request) {
        // dd($request);
        $request->validate([
            'verifikator_2'=>'required',
            'verifikator_1'=>'required',
            'tanggal_mulai'=>'required',
            'tanggal_akhir'=>'required',
            'alasan'=>'required'
        ]);
        $cuti = new Cuti();
        $verifikator2 = $request->get('verifikator_2');
        $verifikator1 = $request->get('verifikator_1');
        $nama_verif2 = User::where('id','=',$verifikator2)->first();
        $nama_verif1 = User::where('id','=',$verifikator1)->first();
        $cuti->status = 1;
        if ($request->get('tanggal_mulai') == null || $request->get('tanggal_akhir') == null) {
            return redirect()->back()->with('error', 'Tanggal Tidak Boleh Kosong!');
        }
        if ($request->get('tanggal_mulai') == $request->get('tanggal_akhir')) {
            return redirect()->back()->with('error', 'Tanggal Tidak Boleh Sama!');
        }
        $cuti->tanggal_mulai = $request->get('tanggal_mulai');
        $cuti->tanggal_akhir = $request->get('tanggal_akhir');
        $cuti->alasan = $request->get('alasan');
        $cuti->verifikator_2 = $nama_verif2->nama;
        $cuti->verifikator_1 = $nama_verif1->nama;
        $cuti->verifikator_2_id = $verifikator2;
        $cuti->verifikator_1_id = $verifikator1;
        if (\Auth::user()->id == 1){
        $cuti->user_id = $request->get('name');
        } else {
        $cuti->user_id = \Auth::user()->id;          
        }

        $cuti->save();
        
        return redirect('/cuti')->with('success', 'Cuti Saved!');
    }

    public function show($id) {
        $cuti = Cuti::find($id);
        return view('cuti.show', compact('cuti'));
    }

    public function upload(Request $request, $id) {
        
        $cuti = Cuti::find($id);
        $cuti->catatan_ver_2 = $request->get('catatan2');
        $cuti->catatan_ver_1 = $request->get('catatan1');
        
       

   
        $file = $request->except(['_token', '_method','surat_cuti']);

        $tujuan_upload = config('app.upload_url').'surat_cuti';
        $file = $request->file('surat_cuti');
        if($file){
                $name = \Auth::user()->id."_".time().".".$file->getClientOriginalName();
                
                $img = \Image::make($file->getRealPath());
                $img->save($tujuan_upload.'/'.$name);
                
                if($img){
                    $cuti['surat_cuti'] = $tujuan_upload.'/'.$name;
                }
               
            }
          
                $cuti->update();
            return redirect('/cuti')->with('success', 'File uploaded!');
            }
                

    public function edit($id) {
        $cuti = Cuti::find($id);
        if (!(Auth::id() == $cuti->karyawan->id || Auth::user()->role == 1)) {
            return redirect()->back()->with('error', 'Maaf, Anda bukan pemohon data cuti ini!');
        }
        $verifikator1 = User::where('id', '=', $cuti->verifikator_1_id)->first();
        $verifikator2 = User::where('id', '=', $cuti->verifikator_2_id)->first();
        return view('cuti.edit', compact('cuti','verifikator1','verifikator2'));
    }

    public function update(Request $request, $id) {
        // dd($request);
        $cuti = Cuti::find($id);
        if (!(Auth::id() == $cuti->karyawan->id || Auth::user()->role == 1)) {
            return redirect()->back()->with('error', 'Maaf, Anda bukan pemohon data cuti ini!');
        }
        $cuti->status = 1;
        if ($request->get('tanggal_mulai') == null || $request->get('tanggal_akhir') == null) {
            return redirect()->back()->with('error', 'Tanggal Tidak Boleh Kosong!');
        }
        if ($request->get('tanggal_mulai') == $request->get('tanggal_akhir')) {
            return redirect()->back()->with('error', 'Tanggal Tidak Boleh Sama!');
        }
        $cuti->tanggal_mulai = $request->get('tanggal_mulai');
        $cuti->tanggal_akhir = $request->get('tanggal_akhir');
        $cuti->alasan = $request->get('alasan');
        $verifikator2 = $request->get('verifikator_2');
        $verifikator1 = $request->get('verifikator_1');
        if ($verifikator2 != null) {
            $nama_verif2 = User::where('id','=',$verifikator2)->first();
            $cuti->verifikator_2 = $nama_verif2->nama;
            $cuti->verifikator_2_id = $verifikator2;
        }
        if ( $verifikator1 != null){
            $nama_verif1 = User::where('id','=',$verifikator1)->first();
            $cuti->verifikator_1 = $nama_verif1->nama;
            $cuti->verifikator_1_id = $verifikator1;
        }
        if ($verifikator2 == $cuti->verifikator_1_id || $verifikator1 == $cuti->verifikator_2_id) {
        return redirect()->back()->with('error', 'Verifikator Tidak Boleh Sama!');
        }
        $verifs = User::where('role','<=','20')->get();
        $id_verif1 = $cuti->verifikator_1_id;
        $data_verif1 = User::where('id',$id_verif1)->first();
        $atasan_id = $data_verif1->atasan_id;
        $data = [];
        $j = 0;
        $len = $verifs->count();
        // dd($verifikator1);
        for($i = 0; $i<$len;$i++){
            foreach ($verifs as $verif){
                if ($atasan_id == $verif->id) {
                    $data[$j] = $verif;
                    $atasan_id = $verif->atasan_id;
                    $j++;
                }
            }    
        };      
        $collection = collect($data);
        // dd($verifikator2);
        if ($collection->contains('id',$verifikator2)){
            return redirect()->back()->with('error', 'Jabatan Verifikator 2 Lebih Tinggi');
        } else {
            $cuti->update();
            return redirect('/cuti')->with('success', 'Cuti Updated');
        }
    }

    public function historycuti() {
        return view('cuti.history');
    }

    public function destroy($id) {
        $cuti = Cuti::find($id);
        if (!(Auth::id() == $cuti->karyawan->id || Auth::user()->role == 1)) {
            return redirect()->back()->with('error', 'Maaf, Anda bukan pemohon data cuti ini!');
        }
        // dd($cuti);
        $cuti->delete();
        return redirect()->route('cuti');
    }

    public function getverifikator($id)
    {
        $verifs = User::where('role','<=','20')->get();
        if ($id != 0) {
            $user = User::find($id);
            $atasan_id = $user->atasan_id;
            $data = [];
            $j = 0;
            $len = $verifs->count();
            for($i = 0; $i<$len;$i++){
                foreach ($verifs as $verif){
                    if ($atasan_id == $verif->id) {
                        $data[$j] = $verif;
                        $atasan_id = $verif->atasan_id;
                        $j++;
                    }
                }    
            };      
            // dd($len);
            return response()->json($data);
        } else {
            return response()->json($verifs);
        }
        
    }

    public function invalid($id) {
        $cuti = Cuti::find($id);
        if (!(Auth::id() == $cuti->karyawan->id || Auth::user()->role == 1)) {
            return redirect()->route('cuti')->with('error', 'Maaf, Anda bukan pemohon data cuti ini!');
        }
        $cuti->status = 4;
        $cuti->update();
        return redirect()->route('cuti');
    }

    //tampilan index menggunakan serverside datatables
    public function getcuti($status) {
        $currentUserId = Auth::id();
        $today = Carbon::today();
        if ($status == 'aktif') {
            $cuti = Cuti::where('status', '<', '3')
                ->where('tanggal_akhir', '>=', $today)
                ->with('karyawan')
                ->get();
        } else if ($status == 'history') {
            $cuti = Cuti::where(function($q) use ($today) {
                $q->where('status', '>', '2')
                    ->orWhere('tanggal_akhir', '<', $today);
                })
                ->with('karyawan')
                ->get();
        }
        return Datatables::of($cuti)
            ->addIndexColumn()
            ->addColumn('currentUserId', $currentUserId)
            ->make(true);
    }

    public function cetaksuratcuti($id) {
        $cuti = Cuti::find($id);
        $setting = Setting::first();
        $pdf = PDF::loadView('cuti.cetaksuratcuti', compact('cuti', 'setting'));
        return $pdf->stream();
    }
}
