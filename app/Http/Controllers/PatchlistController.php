<?php

namespace App\Http\Controllers;

use Datatables;
use Carbon\Carbon;
use App\Model\User;
use App\Model\Proyek;
use App\Model\Patchlist;
use Illuminate\Http\Request;
use App\Exports\PatchlistExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Database\Eloquent\Collection;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class PatchlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $klienList = Patchlist::distinct()->pluck('klien_id', 'klien_id');
        $proyekList = Patchlist::distinct()->pluck('proyek_id', 'proyek_id');
        $klienList = $this->getKlienList();
        $proyekList = $this->getProyekList();

        $filterKlien = request()->input('filterKlien');
        $filterProyek = request()->input('filterProyek');
    
        $query = Patchlist::query();

        if ($filterKlien) {
            $query->where('klien_id', $filterKlien);
        }

        if ($filterProyek) {
            $query->where('proyek_id', $filterProyek);
        }

        $filteredData = $query->get();

        $totalPerStatus = Patchlist::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        session(['filteredData' => $filteredData]);

        return view('patchlist.index', compact('klienList', 'proyekList', 'filterKlien', 'filterProyek', 'filteredData', 'totalPerStatus'));
    }

    public function getpatchlist(Request $request)
    {
        if ($request->ajax()) {
            $data = Patchlist::query();
        
            if ($request->has('filterKlien') && !empty($request->input('filterKlien'))) {
                $data->where('klien_id', $request->input('filterKlien'));
            }
                
            if ($request->has('filterProyek') && !empty($request->input('filterProyek'))) {
                $data->where('proyek_id', $request->input('filterProyek'));
            }

            return datatables()->of($data)
                ->addColumn('action', function($row) {
                    $editRoute = route('patchlist.edit', $row->id);
                    $deleteRoute = route('patchlist.destroy', $row->id);

                    $buttons = '<a href="' . $editRoute . '" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>';

                    if (Auth::user()->role == 1) {
                        $buttons .= '<a class="dropdown-item delbutton" data-toggle="modal" data-target="#modal_theme_danger" data-uri="' . $deleteRoute . '"><i class="icon-x"></i> Delete</a>';
                    }

                    return $buttons;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? date('d-m-Y', strtotime($row->created_at)) : '-';
                })
                ->editColumn('tanggal_patch', function ($row) {
                    return $row->tanggal_patch ? date('Y-m-d', strtotime($row->tanggal_patch)) : '-';
                })
                ->make(true);
        }

        return view('patchlist.index');
    }
    
    public function getPatchlistData(Request $request)
    {
        $query = DB::table('patchlists')
            ->select('id', 'patchlist', 'prioritas', 'created_at', 'kesulitan', 'status', 'keterangan')
            ->addSelect(DB::raw("CASE WHEN status = 3 THEN tanggal_patch ELSE NULL END as tanggal_patch"));

        return Datatables::of($query)
            ->editColumn('tanggal_patch', function ($row) {
                if ($row->status == 3 && $row->tanggal_patch) {
                    return \Carbon\Carbon::createFromTimestamp($row->tanggal_patch)->format('Y-m-d');
                } else {
                    return '-';
                }
            })
            ->make(true);
    }

    public function create()
    {
        $klienList = User::has('proyek')->get(['nama', 'id'])->pluck('nama', 'id');
        return view('patchlist.create', compact('klienList'));
    }

    public function getNamaProyekByUserId(Request $request)
    {
        $user_id = $request->input('user_id');

        $namaProyek = Proyek::where('user_id', $user_id)->pluck('nama_proyek', 'id');

        return response()->json($namaProyek);
    }

    public function getNamaProyekFilter(Request $request)
    {
        $user_id = $request->input('user_id');
        if (!$user_id) {
            return response()->json([]);
        }

        $namaProyek = Patchlist::where('klien_id', $user_id)
            ->join('proyeks', 'proyeks.id', '=', 'patchlists.proyek_id')
            ->pluck('proyeks.nama_proyek', 'patchlists.proyek_id');

        return response()->json($namaProyek);
    }

    public function getNamaKlien()
    {
        $namaKlien = User::pluck('nama', 'id');
        return response()->json($namaKlien);
    }

    public function getKlienList()
    {
        $klienList = Patchlist::join('users', 'users.id', '=', 'patchlists.klien_id')
            ->distinct()
            ->pluck('users.nama', 'patchlists.klien_id');
        return $klienList;
    }

    public function getProyekList()
    {
        $proyekList = Patchlist::join('proyeks', 'proyeks.id', '=', 'patchlists.proyek_id')
            ->distinct()
            ->pluck('proyeks.nama_proyek', 'patchlists.proyek_id');
        return $proyekList;
    }

    public function getNamaProyekByKlien($klienId)
    {
        $namaProyek = Patchlist::where('klien_id', $klienId)->pluck('proyek_id', 'id');
        $namaProyekList = [];

        foreach ($namaProyek as $patchlistId => $proyekId) {
            $proyekNama = Proyek::where('id', $proyekId)->value('nama_proyek');
            if ($proyekNama) {
                $namaProyekList[$patchlistId] = $proyekNama;
            }
        }
        return response()->json($namaProyekList);
    }


    public function show($id)
    {
        $patchlist = Patchlist::find($id);

        if (!$patchlist) {
            return redirect()->route('patchlist.index');
        }

        $klienList = $patchlist->user->nama;
        $proyekList = $patchlist->proyek->nama_proyek;

        return view('patchlist.show', compact('patchlist', 'klienList', 'proyekList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patchlist' => 'required|string',
            'prioritas' => 'required|integer',
            'kesulitan' => 'required|integer',
            'status' => 'required|integer',
            'keterangan' => 'required|string',
            'klien' => 'required|integer',
            'nama_proyek' => 'required|integer',
        ]);

        $user_id = User::find($request->input('klien'))->id;
        $keterangan = strip_tags($request->input('keterangan'));

        Patchlist::create([
            'patchlist' => $request->patchlist,
            'prioritas' => $request->prioritas,
            'kesulitan' => $request->kesulitan,
            'status' => $request->status,
            'keterangan' => $keterangan,
            'klien_id' => $user_id,
            'proyek_id' => $request->nama_proyek,
        ]);

        return redirect()->route('patchlist.index')->with('success', 'Data Patchlist berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'patchlist' => 'required|string',
            'prioritas' => 'required|integer',
            'kesulitan' => 'required|integer',
            'status' => 'required|integer',
            'keterangan' => 'required|string',
        ]);

        $patchlist = Patchlist::find($id);

        if (!$patchlist) {
            return redirect()->route('patchlist.index');
        }
        if ($request->status == 3 && $patchlist->status != 3) {
            $patchlist->tanggal_patch = now();
        }

        $patchlist->patchlist = $request->patchlist;
        $patchlist->prioritas = $request->prioritas;
        $patchlist->kesulitan = $request->kesulitan;
        $patchlist->status = $request->status;
        $patchlist->keterangan = $request->keterangan;

        $patchlist->save();

        return redirect()->route('patchlist.index')->with('success', 'Data Patchlist berhasil diperbarui');
    }

    public function edit($id)
    {
        $patchlist = Patchlist::find($id);

        if (!$patchlist) {
            return redirect()->route('patchlist.index');
        }

        $klienList = User::has('proyek')->get(['nama', 'id'])->pluck('nama', 'id');
        $proyekList = Proyek::pluck('nama_proyek', 'id');

        return view('patchlist.edit', compact('patchlist', 'klienList', 'proyekList'));
    }

    public function destroy($id)
    {
        $patchlist = Patchlist::find($id);
        $patchlist->delete();

        return redirect('/patchlist')->with('success', 'Data berhasil dihapus');
    }

    public function exportExcel(Request $request)
    {
        $filterKlien = $request->input('filterKlien');
        $filterProyek = $request->input('filterProyek');

        \Log::info('Filter Klien:', [$filterKlien]);
        \Log::info('Filter Proyek:', [$filterProyek]);
        
        $data = Patchlist::query();

        if ($filterKlien) {
            $data->where('klien_id', $filterKlien);
        }

        if ($filterProyek) {
            $data->where('proyek_id', $filterProyek);
        }

        $filteredData = $data->get();

        $patchlistExport = new PatchlistExport($filteredData);

        return Excel::download($patchlistExport, 'patchlist.xlsx');
    }

}
