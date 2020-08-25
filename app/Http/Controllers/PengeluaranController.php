<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Pengeluaran;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluarans = Pengeluaran::orderBy('id')->get();

        return view('pengeluarans.index', compact('pengeluarans'));
    }

    public function create()
    {
        return view('pengeluarans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_pengeluaran'=>'required',
            'nama_pengeluaran'=>'required',
            // 'jenis_pengeluaran'=>'required',
            'nominalp'=>'required',
            // 'keterangan'=>'required'

            ]);
            
        // simpan data
        $pengeluaran = new Pengeluaran([
            'tanggal' => $request->get('tgl_pengeluaran'),
            'pengeluaran' => $request->get('nama_pengeluaran'),
            'jenis_pengeluaran' => $request->get('jenis_pengeluaran'),
            'nominal' => $request->get('nominalp'),
            'keterangan' => $request->get('keterangan'),

            ]);
            
            $pengeluaran->save();
            return redirect('/pengeluarans')->with('success', 'Data Pengeluaran saved!');
    }

    public function destroy($id)
    {
        $dpengeluaran = Pengeluaran::find($id);
        $dpengeluaran->delete();
        
        return redirect('/pengeluarans')->with('success', 'Data Deleted!');
    }

}
