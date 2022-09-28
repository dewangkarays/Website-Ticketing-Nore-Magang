<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Model\User;
use App\Model\Proyek;
use Carbon\Carbon;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Datatables;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::today();
        $expired = Carbon::today()->addDays(-1);
        $dateline = Carbon::today()->addDays(14);
        $null = Proyek::whereNull('masa_berlaku')
                        ->with('user')
                        ->orderBy('jenis_proyek')
                        ->get();
        $yellow = Proyek::whereNotNull('masa_berlaku')
                        ->whereDate('masa_berlaku', '>=', $date)
                        ->whereDate('masa_berlaku', '<=', $dateline)
                        ->with('user')
                        ->orderBy('masa_berlaku')
                        ->get();
        $green = Proyek::whereNotNull('masa_berlaku')
                        ->whereDate('masa_berlaku', '>', $dateline)
                        ->with('user')
                        ->orderBy('masa_berlaku')
                        ->get();
        $red = Proyek::whereNotNull('masa_berlaku')
                        ->whereDate('masa_berlaku', '<', $date)
                        ->with('user')
                        ->orderBy('masa_berlaku')
                        ->get();

        $allItems = new Collection;
        $allItems = $allItems->merge($yellow);
        $allItems = $allItems->merge($green);
        $allItems = $allItems->merge($null);
        $allItems = $allItems->merge($red);
        // dd($allItems);
        //dd($proyeks, $yellow, $green, $red);
        // dd($allItems->toJson());
        return view('proyeks.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $users = User::where('id', '=', \Auth::user()->id)->get();
        $users = User::where('role','>=','80')->get();
        $karyawans = User::where('role','=','50')->get();

       
        return view('proyeks.create', compact('users','karyawans'));
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

        $data = $request->except(['_token', '_method']);

        if($request->get('tipe_web')!=''){
            $data['tipe'] = $request->get('tipe_web');
        }
        if($request->get('tipe_app')!=''){
            $data['tipe'] = $request->get('tipe_app');
        }
        if($request->get('jl_web')!=''){
            $data['jenis_layanan'] = $request->get('jl_web');
        }
        if($request->get('jl_app')!=''){
            $data['jenis_layanan'] = $request->get('jl_app');
        }

        $proyek = new Proyek($data);
        $proyek->save();

        $user = User::find($proyek->user_id);
        $user->task_count = $user->proyek->sum('task_count');
        $user->save();

        return redirect('/proyeks')->with('success', 'Proyek saved!');
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
        $proyek = Proyek::find($id);
        // $users = User::where('role','>','20')->get();
        // $users = User::where('id', '=', \Auth::user()->id)->get();
        $users = User::where('role','>=','80')->get();
        $karyawans = User::where('role','=','50')->get();

        return view('proyeks.edit', compact(['proyek','users','karyawans']));
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
        $proyek = Proyek::find($id);
        $data = $request->except(['_token', '_method']);


        if($request->get('new_mb')!=''){
            $data['masa_berlaku'] = $request->get('new_mb');
        }
        if($request->get('tipe_web')!=''){
            $data['tipe'] = $request->get('tipe_web');
        }
        if($request->get('tipe_app')!=''){
            $data['tipe'] = $request->get('tipe_app');
        }
        if($request->get('tipe_app')=='' && $request->get('tipe_web')==''){
            $data['tipe'] = null;
        }
        if($request->get('jl_web')!=''){
            $data['jenis_layanan'] = $request->get('jl_web');
        }
        if($request->get('jl_app')!=''){
            $data['jenis_layanan'] = $request->get('jl_app');
        }
        if($request->get('jl_app')=='' && $request->get('jl_web')==''){
            $data['jenis_layanan'] = null;
        }


        $proyek->update($data);

        $user = User::find($proyek->user_id);
        $user->task_count = $user->proyek->sum('task_count');
        $user->save();

        return redirect('/proyeks')->with('success', 'Proyek updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyek = Proyek::find($id);
        $proyek->delete();

        return redirect('/proyeks')->with('success', 'Proyek deleted!');
    }

    public function getproyeks() {
        $date = Carbon::today();
        $expired = Carbon::today()->addDays(-1);
        $dateline = Carbon::today()->addDays(14);
        $null = Proyek::whereNull('masa_berlaku')
                        ->with('user')
                        ->orderBy('jenis_proyek')
                        ->get();
        $yellow = Proyek::whereNotNull('masa_berlaku')
                        ->whereDate('masa_berlaku', '>=', $date)
                        ->whereDate('masa_berlaku', '<=', $dateline)
                        ->with('user')
                        ->orderBy('masa_berlaku')
                        ->get();
        $green = Proyek::whereNotNull('masa_berlaku')
                        ->whereDate('masa_berlaku', '>', $dateline)
                        ->with('user')
                        ->orderBy('masa_berlaku')
                        ->get();
        $red = Proyek::whereNotNull('masa_berlaku')
                        ->whereDate('masa_berlaku', '<', $date)
                        ->with('user')
                        ->orderBy('masa_berlaku')
                        ->get();
                        
        $allItems = new Collection;
        $allItems = $allItems->merge($yellow);
        $allItems = $allItems->merge($green);
        $allItems = $allItems->merge($null);
        $allItems = $allItems->merge($red);

        // $collections = collect([
        //     $yellow, $green, $null, $red
        // ]);
        // dd($allItems);
        // foreach ($allItems as $item) {
        //     dump($item->nama_proyek);
        // }
        // die;
        // $allItems = $collections->values()->all();
        

        return Datatables::of($allItems)
            ->addColumn('expired', $expired)
            ->addColumn('dateline', $dateline)
            ->addIndexColumn()
            ->make(true);
    }
}
