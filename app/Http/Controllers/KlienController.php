<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Klien;
use Datatables;

class KlienController extends Controller
{
    public function index(){

        return view('klien.index');
    }

    public function getData(Request $request)
    {
        // $limit =$request->length;
        // $start =$request->start;
        // $page  =$start+1;
        // $search=$request->search['value'];

        // $dbquery = Klien::select('*');
        // $dbquery->orderBy('id','desc');

        // if($search) {
        //     $dbquery->where(function ($query) use ($search){
        //         $query->orWhere('nama_calonklien','LIKE',"%{$search}%");
        //         $query->orWhere('nama_perusahaan','LIKE',"%{$search}%");
            
        //     });
        // }


        // $totalData                   =$dbquery->get()->count();
        // $totalFilter                 =$dbquery->get()->count();  
        // $dbquery->limit($limit);
        // $dbquery->offset($start);
        // $data = $dbquery->get();

        
       
        // $json_data = array(
        //     "recordsTotal"    => intval($totalData),
        //     "recordsFiltered" => intval($totalFilter),
        //     "data"            => $data
        //     );

        $json_data = Klien::all();
        // return json_encode($json_data);
        return Datatables::of($json_data)->addIndexColumn()->make(true);
    }   

     //CREATE
     public function create(Request $request){
        $marketings= User::where('role','50')->get();
        return view('klien.create', compact('marketings'));
    }

    public function saveCreate(Request $request){

       
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

       return redirect('/klien')->with('success', 'Klien saved!');
    }
    
    //Show
    public function show($id){
        $klien = Klien::find($id);
        return view('klien.show',compact('klien'));
    }

    //DELETE
    public function delete($id){
        $klien = Klien::find($id);
        $klien->delete();
       
        return redirect('/klien')->with('success', 'Klien deleted!');
    }

    //EDIT
    public function edit($id){
        $klien = Klien::find($id);
        $marketings= User::where('role','50')->get();
        return view('klien.edit', compact('klien','marketings'));
    }

    public function saveEdit(Request $request,$id){
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

        return redirect('/klien')->with('success', 'Klien updated!');
    }

}
