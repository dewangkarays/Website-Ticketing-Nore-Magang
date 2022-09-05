<?php

namespace App\Http\Controllers;

use App\Model\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        // $setting = strip_tags($setting);
    
        return view('settings', compact('setting'));
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        $file = Setting::first();
        // $file = $request->file('logo');
        
        $tujuan_upload = config('app.upload_url').'global_assets/images';
        $files = [];
        if ($request->file('logo')) {
                $files[] = $request->file('logo');
            }
        if ($request->file('npwp')) {
                $files[] = $request->file('npwp');
            }
        if ($request->file('umkm')) {
                $files[] = $request->file('umkm');
            }
            // dd($request);
            $i = 1;
            foreach ($files as $test) 
        {
            if(!empty($test)){
                $name = \Auth::user()->id."_".$i."_".time().".".$test->getClientOriginalExtension();
                // $filename = $tujuan_upload.'/'.$name;
                $test->move($tujuan_upload,$name);
                $data[$i] = $tujuan_upload.'/'.$name;
                $i++;
        }
    }

    // dd($data);
    $total = count($files);
    // dd($total);
    if($total == 3)
    {
        $data['logo'] = $data[$i - 3];
        $data['npwp'] = $data[$i - 2];
        $data['umkm'] = $data[$i - 1];
    }
    elseif($total == 2)
    {
        if(empty($data['logo']))
        {
            $data['logo'] = $file->logo;
            $data['npwp'] = $data[$i-2];
            $data['umkm'] = $data[$i-1];
        }
        elseif(empty($data['npwp']))
        {
            $data['logo'] = $data[$i-2];
            $data['npwp'] = $file->npwp;
            $data['umkm'] = $data[$i-1];
        }
        elseif(empty($data['umkm']))
        {
            $data['logo'] = $data[$i-2];
            $data['npwp'] = $data[$i-1];
            $data['umkm'] = $file->umkm;
        }
    }
    elseif($total == 1)
    {
        if(!empty($data['logo']))
        {
            $data['npwp'] = $file->npwp;
            $data['umkm'] = $file->umkm;
            $data['logo'] = $data[$i-1];
        }
        elseif(!empty($data['npwp']))
        {
            $data['logo'] = $file->logo;
            $data['npwp'] = $data[$i-1];
            $data['umkm'] = $file->umkm;
        }
        elseif(!empty($data['umkm']))
        {
            $data['logo'] = $file->logo;
            $data['npwp'] = $file->npwp;
            $data['umkm'] = $data[$i-1];
        }
    }
    else
    {
        $data['logo'] = $file->logo;
        $data['npwp'] = $file->npwp;
        $data['umkm'] = $file->umkm;
    }
        // if($file){
        //         $name = \Auth::user()->id."_".time().".".$file->getClientOriginalExtension();
        //         $up1 = $file->move($tujuan_upload,$name);
        //         if($up1){
        //             $data['logo'] = $tujuan_upload.'/'.$name;
        //         }
        //     }
        // else{
        //     $data['logo'] = $logo->logo;
        // }
        // dd($data);
        Setting::updateOrInsert(
            ['id' => 1],[
            'logo' => $data['logo'],
            'npwp' => $data['npwp'],
            'umkm' => $data['umkm'],
            'alamat' => $data['alamat'],
            'no_telp' => $data['no_telp'],
            'email' => $data['email'],
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
