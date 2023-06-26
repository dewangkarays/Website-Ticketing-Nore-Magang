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
        $marketings = User::where('role', '=', '50')->get();
        //dd($marketings);

        return view('proyeks.index', compact('marketings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $users = User::where('id', '=', \Auth::user()->id)->get();
        $users = User::where('role', '>=', '80')->get();
        $marketings = User::where('role', '=', '50')->get();

        // dd($marketings);

        return view('proyeks.create', compact('users', 'marketings'));
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

        // if($request->get('tipe_web')!=''){
        //     $data['tipe'] = $request->get('tipe_web');
        // }
        // if($request->get('tipe_app')!=''){
        //     $data['tipe'] = $request->get('tipe_app');
        // }

        if ($request->tipe_web != '') {
            $data['tipe'] = $request->tipe_web;
        } else if ($request->tipe_app != '') {
            $data['tipe'] = $request->tipe_app;
        } else if ($request->tipe_ulo != '') {
            $data['tipe'] = $request->tipe_ulo;
        }

        // if($request->get('jl_web')!=''){
        //     $data['jenis_layanan'] = $request->get('jl_web');
        // }
        // if($request->get('jl_app')!=''){
        //     $data['jenis_layanan'] = $request->get('jl_app');
        // }

        if ($request->jl_web != '') {
            $data['jenis_layanan'] = $request->jl_web;
        } else if ($request->jl_app != '') {
            $data['jenis_layanan'] = $request->jl_app;
        } else if ($request->jl_ulo != '') {
            $data['jenis_layanan'] = $request->jl_ulo;
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
        $users = User::where('role', '>=', '80')->get();
        $marketings = User::where('role', '=', '50')->get();

        return view('proyeks.edit', compact(['proyek', 'users', 'marketings']));
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
        // dd($request);
        $proyek = Proyek::find($id);
        $data = $request->except(['_token', '_method']);


        // if($request->get('new_mb')!=''){
        // $data['masa_berlaku'] = $request->get('new_mb');
        // }

        // if($request->get('tipe_web')!=''){
        //     $data['tipe'] = $request->get('tipe_web');
        // }
        // if($request->get('tipe_app')!=''){
        //     $data['tipe'] = $request->get('tipe_app');
        // }
        // if($request->get('tipe_app')=='' && $request->get('tipe_web')==''){
        //     $data['tipe'] = null;
        // }

        if ($request->tipe_web != '') {
            $data['tipe'] = $request->tipe_web;
        } else if ($request->tipe_app != '') {
            $data['tipe'] = $request->tipe_app;
        } else if ($request->tipe_ulo != '') {
            $data['tipe'] = $request->tipe_ulo;
        } else {
            $data['tipe'] = null;
        }

        // if($request->get('jl_web')!=''){
        //     $data['jenis_layanan'] = $request->get('jl_web');
        // }
        // if($request->get('jl_app')!=''){
        //     $data['jenis_layanan'] = $request->get('jl_app');
        // }
        // if($request->get('jl_app')=='' && $request->get('jl_web')==''){
        //     $data['jenis_layanan'] = null;
        // }

        if ($request->jl_web != '') {
            $data['jenis_layanan'] = $request->jl_web;
        } else if ($request->jl_app != '') {
            $data['jenis_layanan'] = $request->jl_app;
        } else if ($request->jl_ulo != '') {
            $data['jenis_layanan'] = $request->jl_ulo;
        } else {
            $data['tipe'] = null;
        }

        if ($request->marketing_id_baru != '') {
            $data['marketing_id'] = $data['marketing_id_baru'];
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

    public function getproyeks(Request $request)
    {

        // dd($request->marketing);
        $marketing = null;
        if ($request->marketing) {

            $marketing = $request->marketing;
        }
        $date = Carbon::today();
        $expired = Carbon::today()->addDays(-1);
        $dateline = Carbon::today()->addDays(14);
        $null = Proyek::whereNull('masa_berlaku');
        //->where('marketing_id', $request->marketing)
        if ($request->marketing) {
            $null = $null->where('marketing_id', $marketing);
        }
        $null = $null->with('user')
            ->orderBy('jenis_proyek')
            ->get();
        //dd($null);
        foreach ($null as $nullItem) {
            $nullItem['nama_user'] = @$nullItem->user->nama;
        }
        $yellow = Proyek::whereNotNull('masa_berlaku');
        if ($request->marketing) {
            $yellow = $yellow->where('marketing_id', $marketing);
        }
        $yellow = $yellow->with('user')
            // ->where('marketing_id', $marketing)
            ->whereDate('masa_berlaku', '>=', $date)
            ->whereDate('masa_berlaku', '<=', $dateline)
            ->with('user')
            ->orderBy('masa_berlaku')
            ->get();
        foreach ($yellow as $yellowItem) {
            $yellowItem['nama_user'] = @$yellowItem->user->nama;
        }
        $green = Proyek::whereNotNull('masa_berlaku');
        //->where('marketing_id', $marketing)
        if ($request->marketing) {
            $green = $green->where('marketing_id', $marketing);
        }
        $green = $green->with('user')
            ->whereDate('masa_berlaku', '>', $dateline)
            ->with('user')
            ->orderBy('masa_berlaku')
            ->get();
        foreach ($green as $greenItem) {
            $greenItem['nama_user'] = @$greenItem->user->nama;
        }
        $red = Proyek::whereNotNull('masa_berlaku');
        //->where('marketing_id', $marketing)
        if ($request->marketing) {
            $red = $red->where('marketing_id', $marketing);
        }
        $red = $red->with('user')
            ->whereDate('masa_berlaku', '<', $date)
            ->with('user')
            ->orderBy('masa_berlaku')
            ->get();
        foreach ($red as $redItem) {
            $redItem['nama_user'] = @$redItem->user->nama;
        }

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
