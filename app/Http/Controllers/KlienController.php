<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Klien;
use App\Model\Proyek;
use App\Model\Historyklien;
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
        $json_data = Klien::where('member_created',false)
                ->orderBy('id', 'desc')
                ->with('marketing')
                ->get();
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
        $tanggal= date('Y-m-d');


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
        return view('klien.createmember', compact('klien', 'marketings'));
    }

    public function savecreateMember(Request $request, $id)
    {
        // dd($request);
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
        }

        if ($request->tipe_web != '') {
            $kelaslayanan = $request->tipe_web;
        } else if ($request->tipe_app != '') {
            $kelaslayanan = $request->tipe_app;
        } else if ($request->tipe_ulo != '') {
            $kelaslayanan = $request->tipe_ulo;
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


        $klien = Klien::find($id);
        $klien->update([
            'member_created' => true
        ]);
        return redirect('/members')->with('success', 'User saved!');
    }

}
