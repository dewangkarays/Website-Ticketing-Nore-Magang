<?php

namespace App\Http\Controllers;

use App\Model\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stoks = Stok::orderBy('id', 'desc')->get();

        return view('stoks.index', compact('stoks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stok = Stok::find($id);

        return view('stoks.show', compact('stok'));
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
        $stok = Stok::find($id);
        if ($stok) {

            if ($stok->status == 2 || $stok->penawaran_id != null) {
                return redirect('/stoks')->with('error', 'Stok tidak bisa di delete,karena stok sedang proses verifikasi!');  
            } else {
                $stok->delete();
                return redirect('/stoks')->with('success', 'Stok deleted!');
            }
            
        } else {

            return redirect('/stoks')->with('error', 'Stok not found!');
        }
    }

    public function batalverifikasistok($id, Request $request)
    {
        
        $stok = Stok::find($id);
        if ($stok) {
            
            $stok->status = 2;
            $stok->is_verified = 0;
            $stok->update();
            
            // $sumber = '';
            // $harga = '';
            // $berat = '';
            // $keterangan = '';
            // if ($stok->sumberstok) {
            //     $sumber = @$stok->sumberstok->sumber_beli;
            //     $harga = @$stok->sumberstok->harga_beli;
            //     $berat = @$stok->sumberstok->berat_beli;
            //     $keterangan = @$stok->sumberstok->keterangan;
            // }

            // $param = '';
            // $param .= '?statusStok='.$stok->status;
            // $param .= '&isPenawaran='.$statepenawaran;
            // $param .= '&sumberBeli='.$sumber;
            // $param .= '&hargaBeli='.$harga;
            // $param .= '&beratBeli='.$berat;
            // $param .= '&keterangan='.$keterangan;
            
            // $judul_push_notif = "Pengajuan Verifikasi Stok";
            // $pesan_push_notif = "Ada Stok yang batal verifikasi.";
            // // $link = 'digiwalet:///stock-verifikator';
            // $link = 'digiwalet:///stock/'.$stok->id.$param;
            // // dd($link);
            // // cari user role 30 / verifikator untuk batch notif firebase
            // $user_device = DeviceId::select('device_id')
            //                         ->where('role', 30)
            //                         ->pluck('device_id');
            // newfireBase($judul_push_notif, $pesan_push_notif, $link, $user_device);

            // // $verif_user_devices = DeviceId::where('role', 30)->get();
            // $verif_user_devices = User::where('role', 30)->get();
            //     foreach ($verif_user_devices as $verifs) {
            //         $datanotif = [];
            //         // $datanotif['user_id'] = $verifs->user_id;
            //         $datanotif['user_id'] = $verifs->id;
            //         $datanotif['judul'] = $judul_push_notif;
            //         $datanotif['pesan'] = $pesan_push_notif;
            //         $datanotif['link'] = $link;
    
            //         $savenotification = Notification::create($datanotif);
            //     }
            
            
            return redirect('/stoks')->with('success', 'Verifikasi Stok dibatalkan');
        } else {
            
            return redirect('/stoks')->with('error', 'Stok tidak ditemukan');
        }

    }
}
