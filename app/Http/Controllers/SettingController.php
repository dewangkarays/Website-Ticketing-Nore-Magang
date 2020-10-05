<?php

namespace App\Http\Controllers;

use App\Model\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
       
        return view('settings', compact('setting'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method','logo']);
        $logo = Setting::first();
        $file = $request->file('logo');
        
        $tujuan_upload = config('app.upload_url').'global_assets/images';
        if($file){
                $name = \Auth::user()->id."_".time().".".$file->getClientOriginalName();
                // $name = \Auth::user()->id."_".time().".".$file->getClientOriginalExtension();
                $up1 = $file->move($tujuan_upload,$name);
                if($up1){
                    $data['logo'] = $tujuan_upload.'/'.$name;
                }
        }else{
            $data['logo'] = $logo->logo;
        }
        // dd($data);
        Setting::updateOrInsert(
            ['id' => 1],[
            'logo' => $data['logo'],
            'alamat' => $data['alamat'],
            'no_telp' => $data['no_telp'],
            'penerima' => $data['penerima'],
            'ttd_penerima' => $data['ttd_penerima'],
            'ttd_pospenerima' => $data['ttd_pospenerima'],
            'penagih' => $data['penagih'],
            'pospenagih' => $data['pospenagih'],
            'catatan_tagihan' => $data['catatan_tagihan']
        ]);

        return redirect()->back()->with('success', 'Setting Updated');
    }
}
