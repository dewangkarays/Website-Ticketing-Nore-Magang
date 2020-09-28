<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Pengeluaran;
use App\Exports\PengeluaranExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function edit($id)
    {
        $epengeluaran = Pengeluaran::find($id);
        return view('pengeluarans.edit', compact('epengeluaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'=>'required',
            'pengeluaran'=>'required',
            // 'jenis_pengeluaran'=>'required',
            'nominal'=>'required',
            // 'keterangan'=>'required'

            ]);
            
        // simpan data
        $pengeluaran = new Pengeluaran([
            'tanggal' => $request->get('tanggal'),
            'pengeluaran' => $request->get('pengeluaran'),
            'jenis_pengeluaran' => $request->get('jenis_pengeluaran'),
            'nominal' => $request->get('nominal'),
            'keterangan' => $request->get('keterangan'),

            ]);
            
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
