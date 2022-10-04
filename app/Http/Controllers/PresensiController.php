<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use App\Model\Presensi;
use Auth;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $month = Carbon::now();
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();

        $dates = [];
        while ($start->lte($end)) {
            $tanggal[] = $start->copy()->format('d'); // untuk tampilan
            $dates[] = $start->copy()->format('Y-m-d'); // untuk validasi dengan data
            $start->addDay();
        }
        // admin
        $karyawans_all = User::where('role', '<=' ,'50')->where('role', '!=', 1)->with(['presensi' => function ($q) {
            $q->orderBy('tanggal'); 
        }])
        ->get()->toArray();
        $presensi_all = Presensi::orderBy('tanggal')->get();
        $sakit_all = Presensi::where('status','3')->count();
        $izin_all = Presensi::where('status','2')->count();          
        // karyawan
        $presensi = Presensi::where('user_id', '166')->orderBy('tanggal')->get();
        $karyawans = User::where('id', \Auth::user()->id)->with(['presensi' => function ($q) {
            $q->orderBy('tanggal'); 
        }])
        ->get()->toArray();
        // dd($dates);
        $sakit = Presensi::where('user_id', \Auth::user()->id)->where('status','3')->count();
        $izin = Presensi::where('user_id', \Auth::user()->id)->where('status','2')->count();     

        $sisa_cuti = 12 - $izin;

        $years = Presensi::selectRaw('year(tanggal) as tahun')->whereNotNull('status')->groupBy('tahun')->orderBy('tahun')->get();

        return view("presensi.index",compact('dates','tanggal','presensi','sakit','izin','sisa_cuti','karyawans','presensi_all','sakit_all','izin_all','karyawans_all','years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Auth::user()->role;
        if ($role == 1) {
            $users = User::where('role', '<', '80')
                ->orderBy('role')
                ->get();
        } else {
            $users = User::find(Auth::id());
        }

        return view("presensi.create", compact('users', 'role'));
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
            'tanggal'=>'required',
            'status'=>'required',
            'user_id'=>'required',
           
        ]);
        $presensi = new Presensi();
        $presensi->tanggal = $request->get('tanggal');
        $presensi->status = $request->get('status');
        $presensi->user_id = $request->get('user_id');
        $presensi->keterangan = $request->get('keterangan');

        $check = Presensi::where('user_id',$request->get('user_id'))
        ->where('tanggal',$request->get('tanggal'))
        ->get();
        // dd(count($check));
        if(count($check) != 0) {
            return redirect('/presensi')->with('error', 'Presensi Sudah Diisi!');
        }

        $file = $request->file('bukti');
        $destinasi = config('app.upload_url').'bukti_ketidakhadiran';

        if ($file) {
            $nama = Auth::id()."_".time().".".$file->getClientOriginalName();
            $img = \Image::make($file->getRealPath());
            $img->save($destinasi.'/'.$nama);

            if ($img) {
                $presensi->bukti = $destinasi.'/'.$nama;
            }
        }

        // dd($file);

        $presensi->save();
        
        return redirect('/presensi')->with('success', 'Presensi Saved!');
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

    public function month($month)
    {
        $month = 10;
        return $month;
    }

    public function year($year)
    {
        $year = 2022;
        return $year;
    }

    public function getpresensi($tahun, $bulan, $id)
    {
        // dd($id);
        // $bulan = 10;
        // dd(substr($id, 0, 4)); //tahun
        // dd(substr($id, 4, 2)); //bulan
        // dd(substr($id, 6)); //user id
        $check = User::find($id);
        // dd($check);
        // $month = Carbon::now()->today()->subMonth()->month;
        // $year = Carbon::now();
        // $month = Carbon::now();
        $year = intval($tahun);
        $month = intval($bulan);
        $start = Carbon::parse($month)->startOfMonth();
        $end = Carbon::parse($month)->endOfMonth();
        // dd($month);
        $dates = [];
        while ($start->lte($end)) {
            $dates[] = $start->copy()->format('Y-m-d');
            $start->addDay();
        }

        if($check->role != 1){
        @$karyawans = User::where('id', $id)->with(['presensi' => function ($q) use ($month, $year) {
            $q->whereYear('tanggal','=',$year)->whereMonth('tanggal','=',$month)->orderBy('tanggal'); 
            // $q->orderBy('tanggal'); 
        }])
        ->get();

        // $presensi = [];
        // $j = 0;
        // for($i=0;$i<count($dates);$i++) {
        //     if($dates[$i]==@$karyawans[0]['presensi'][$j]['tanggal']) {
        //         if($karyawans[0]['presensi'][$j]['status'] == 1) {
        //             // <td class="center"> v </td>
        //             $presensi[$i] = 'v';
        //                 if($j < count($karyawans[0]['presensi'])){
        //                 $j++;
        //             }
        //             }elseif($karyawans[0]['presensi'][$j]['status'] == 2) {
        //             // <td class="center"> i </td>
        //             $presensi[$i] = 'i';
        //                 if($j < count($karyawans[0]['presensi'])) {
        //                 $j++;
        //             }
        //             }else{
        //             // <td class="center"> s </td>
        //             $presensi[$i] = 's';
        //                 if($j < count($karyawans[0]['presensi'])) {
        //                 $j++;
        //             }
        //             }
        //     }else {
        //         // <td class="center"> . </td>
        //         $presensi[$i] = '.';
        //     }
        // }
        return response()->json(@$karyawans);
    } else {
        @$karyawans = User::where('role','<=','50')->where('role','>=','10')->with(['presensi' => function ($q) use ($month, $year) {
            $q->whereYear('tanggal','=',$year)->whereMonth('tanggal','=',$month)->orderBy('tanggal'); 
            // $q->orderBy('tanggal'); 
        }])
        ->get();

        //   $presensi = [];
        //   $j = 0;
        //   for($k=0;$k<count($karyawans);$k++){
        //     for($i=0;$i<count($dates);$i++) {
        //         if(count($karyawans[$k]['presensi']) != 0){
        //         if($dates[$i]==@$karyawans[$k]['presensi'][$j]['tanggal']) {
        //             if($karyawans[$k]['presensi'][$j]['status'] == 1) {
        //                 // <td class="center"> v </td>
        //                 $presensi[$k][$i] = 'v';
        //                     if($j < count($karyawans[$k]['presensi'])){
        //                     $j++;
        //                 }
        //             }elseif($karyawans[$k]['presensi'][$j]['status'] == 2) {
        //                 // <td class="center"> i </td>
        //                 $presensi[$k][$i] = 'i';
        //                     if($j < count($karyawans[$k]['presensi'])) {
        //                     $j++;
        //                 }
        //             }else{
        //                 // <td class="center"> s </td>
        //                 $presensi[$k][$i] = 's';
        //                     if($j < count($karyawans[$k]['presensi'])) {
        //                     $j++;
        //                 }
        //                 }
        //         }else {
        //             // <td class="center"> . </td>
        //             $presensi[$k][$i] = '.';
        //         }
        //         }else{
        //             $presensi[$k][$i] = 'kosong';
        //         }
        //     }
        // }
          return response()->json(@$karyawans);
    }
    }

    public function gettotalizin($id)
    {
        // dd($id);
        $year = intval(substr($id, 0, 4));
        $izin = User::where('id', substr($id, 4))->with(['presensi' => function ($q) use ($year) {
            $q->whereYear('tanggal','=',$year)->where('status','=', 2); 
            // $q->orderBy('tanggal'); 
        }])
        ->get();
        // dd(count($sisa_cuti.['presensi']));
        return response()->json($izin);
    }
}
