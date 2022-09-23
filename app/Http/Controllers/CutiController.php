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
        return view('cuti.index');
    }

    public function create() {
        $users = User::where('id', '=', \Auth::user()->id)->get();
        $karyawans = User::where('role','<=','50')->get();
        // dd($karyawans);
        return view('cuti.create', compact('users','karyawans'));
    }

    public function store(Request $request) {
        // dd($request);
        $request->validate([
            'verifikator_2'=>'required',
            'tanggal_mulai'=>'required',
            'tanggal_akhir'=>'required',
            'alasan'=>'required'
        ]);
        $cuti = new Cuti();
        $verifikator2 = $request->get('verifikator_2');
        $verifikator1 = $request->get('verifikator_1');
        
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
        
        $nama_verif2 = User::where('id','=',$verifikator2)->first();
        $cuti->verifikator_2 = $nama_verif2->nama;
        $cuti->verifikator_2_id = $verifikator2;

        $nama_verif1 = null;
        $cuti->verifikator_1 = null;
        $cuti->verifikator_1_id = null;

        if ($verifikator1 != null){  
        $nama_verif1 = User::where('id','=',$verifikator1)->first();     
        $cuti->verifikator_1 = $nama_verif1->nama;    
        $cuti->verifikator_1_id = $verifikator1;
        }
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
        
        if (!(Auth::id() == $cuti->karyawan->id || Auth::id() == $cuti->verifikator2->id || Auth::id() == $cuti->verifikator1->id || Auth::user()->role == 1)) {
            return redirect()->back()->with('error', 'Maaf, Anda tidak memiliki hak akses!');
        }

        if (Auth::id() == $cuti->verifikator2->id) {
            $cuti->catatan_ver_2 = $request->get('catatan2');
        } else if (Auth::id() == $cuti->verifikator1->id) {
            $cuti->catatan_ver_1 = $request->get('catatan1');
        } else {
            $cuti->catatan_ver_2 = $request->get('catatan2');
            $cuti->catatan_ver_1 = $request->get('catatan1');
        }

        if ($request->status2) {
            $cuti->verifikasi_2 = $request->status2;
        }

        if ($request->status1) {
            $cuti->verifikasi_1 = $request->status1;
        }

        // dd($cuti);

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

        if ($cuti->verifikasi_2 == 2 && $cuti->verifikasi_1 == 2) {
            $cuti->status = 2;
        } else if ($cuti->verifikasi_2 == 3 || $cuti->verifikasi_1 == 3) {
            $cuti->status = 3;
        } else {
            $cuti->status = 1;
        }

        // dd($cuti);

        $cuti->update();
        if ($request->surat_cuti) {
            return redirect()->route('cuti')->with('success', 'Surat cuti berhasil diupload!');
        }
        return redirect()->route('verifikasi-cuti')->with('success', 'Verifikasi berhasil!');
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

    public function verifikasi() {
        return view('cuti.verifikasi');
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
        return redirect()->route('cuti')->with('error','Cuti Deleted');
    }

    public function getverifikator($id)
    {
        $verifs = User::where('role','<=','50')->get();
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
            return redirect()->back()->with('error', 'Maaf, Anda bukan pemohon data cuti ini!');
        }
        $cuti->status = 4;
        $cuti->update();
        return redirect()->route('cuti');
    }

    public function getcuti($status) {
        $currentUserId = Auth::id();
        $today = Carbon::today();
        if ($status == 'aktif') {
            if (Auth::user()->role == 1) {
                $cuti = Cuti::where('status', '<', '3')
                ->where('tanggal_akhir', '>=', $today)
                ->orderByDesc('id')
                ->with('karyawan')
                ->with('verifikator2')
                ->with('verifikator1')
                ->get();
            } else {
                $cuti = Cuti::where('status', '<', '3')
                ->where('tanggal_akhir', '>=', $today)
                ->where('user_id', $currentUserId)
                ->orderByDesc('id')
                ->with('karyawan')
                ->with('verifikator2')
                ->with('verifikator1')
                ->get();
            }
        } else if ($status == 'history') {
            if (Auth::user()->role == 1) {
                $cuti = Cuti::where(function($q) use ($today) {
                    $q->where('status', '>', '2')
                        ->orWhere('tanggal_akhir', '<', $today);
                    })
                    ->orderByDesc('id')
                    ->with('karyawan')
                    ->with('verifikator2')
                    ->with('verifikator1')
                    ->get();
            } else {
                $cuti = Cuti::where(function($q) use ($today) {
                    $q->where('status', '>', '2')
                        ->orWhere('tanggal_akhir', '<', $today);
                    })
                    ->where(
                        function($q) use ($currentUserId) {
                            $q->where('user_id', $currentUserId)
                                ->orWhere('verifikator_2_id', $currentUserId)
                                ->orWhere('verifikator_1_id', $currentUserId);
                        }
                    )
                    ->orderByDesc('id')
                    ->with('karyawan')
                    ->with('verifikator2')
                    ->with('verifikator1')
                    ->get();
            }
        } else if ($status == 'verifikasi') {
            if (Auth::user()->role == 1) {
                $cuti = Cuti::where(
                    function($q) {
                        $q->where('verifikasi_2', '<', '2')
                            ->orWhere('verifikasi_1', '<', '2');
                    }
                )
                ->where('status', '<', '3')
                ->orderByDesc('id')
                ->with('karyawan')
                ->with('verifikator2')
                ->with('verifikator1')
                ->get();
            } else {
                $cuti = Cuti::where(
                    function($q) use ($currentUserId) {
                        $q->where(
                            function($q1) use ($currentUserId) {
                                $q1->where('verifikator_2_id', $currentUserId)
                                    ->where('verifikasi_2', '1');
                            }
                        )
                        ->orWhere(
                            function($q2) use ($currentUserId) {
                                $q2->where('verifikator_1_id', $currentUserId)
                                    ->where('verifikasi_2', '2')
                                    ->where('verifikasi_1', '1');
                            }
                        );
                    }
                )
                ->orderByDesc('id')
                ->with('karyawan')
                ->with('verifikator2')
                ->with('verifikator1')
                ->get();
            }
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
