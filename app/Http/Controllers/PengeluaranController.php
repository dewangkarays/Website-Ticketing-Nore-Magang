<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Pengeluaran;
use App\Exports\PengeluaranExport;
use App\Model\User;
use Maatwebsite\Excel\Facades\Excel;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluarans = Pengeluaran::all()->sortByDesc('created_at');

        return view('pengeluarans.index', compact('pengeluarans'));
    }

    public function create()
    {
        $users = User::where('role','<=',20)->get();
        return view('pengeluarans.create', compact('users'));
    }

    public function edit($id)
    {
        $epengeluaran = Pengeluaran::find($id);
        $users = User::where('role', '<=', 20)->get();
        return view('pengeluarans.edit', compact('epengeluaran', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'=>'required',
            'user_id'=>'required',
            'jenis_pengeluaran'=>'required',
            'nominal'=>'required',
            'keterangan'=>'required'

        ]);
        $data = $request->except(['_token', '_method']);
        $finduser = User::find($data['user_id']);
        $data['tanggal'] = $request->get('tanggal');
        $data['user_id'] = $request->get('user_id');
        $data['nama_pj'] = $finduser->nama;
        $data['jenis_pengeluaran'] = $request->get('jenis_pengeluaran');
        $data['nominal'] = $request->get('nominal');
        $data['keterangan'] = $request->get('keterangan');
        // $pengeluaran = new Pengeluaran([
        //     'tanggal' => $request->get('tanggal'),
        //     'user_id' => $request->get('user_id'),
        //     'nama_pj' => $request->get('nama_pj'),
        //     'jenis_pengeluaran' => $request->get('jenis_pengeluaran'),
        //     'nominal' => $request->get('nominal'),
        //     'keterangan' => $request->get('keterangan'),

        //     ]);

        // dd($data);
        
        // simpan data
        $pengeluaran = Pengeluaran::create($data);
        $pengeluaran->save();
        return redirect('/pengeluarans')->with('success', 'Data Pengeluaran saved!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'tgl_pengeluaran'=>'required',
            // 'nama_pengeluaran'=>'required',
            // 'jenis_pengeluaran'=>'required',
            // 'nominalp'=>'required',
            // 'keterangan'=>'required'
        ]);
        
        // update data
        
        $pengeluaranup = Pengeluaran::find($id);
        $data = $request->except(['_token', '_method']);
        $finduser = User::find($data['user_id']);
        $data['nama_pj'] = $finduser->nama;
        // dd($data);

        $pengeluaranup->update($data);
        return redirect('/pengeluarans')->with('success', 'Data Updated!');
    }

    public function destroy($id)
    {
        $dpengeluaran = Pengeluaran::find($id);
        $dpengeluaran->delete();
        
        return redirect('/pengeluarans')->with('success', 'Data Deleted!');
    }

    public function export_excel_pengeluaran() 
    {
        return Excel::download(new PengeluaranExport, 'Pengeluaran '.(date('Y-m-d')).'.xlsx' );
    }

    

}
