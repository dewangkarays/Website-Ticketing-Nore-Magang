<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Proyek;
use App\Model\Patchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StatusPatchlistController extends Controller
{
    public function index()
    {
        $patchlist = Patchlist::all();
        $statuss = [
            '0' => 'Hold',
            '1' => 'Queue',
            '2' => 'In Progress',
            '3' => 'Done Test Server',
            '4' => 'Production',
        ];

        return view('statuspatchlist.index', compact('patchlist', 'statuss'));
    }

    public function updateStatus(Request $request)
    {
        // Pastikan hanya data status yang dikirim
        $newStatus = $request->input('newStatus');
        $patchName = $request->input('patchName');

        Log::info("Received patchName: $patchName, newStatus: $newStatus");

        // Validasi jika diperlukan

        // Update kolom status pada entitas yang sesuai berdasarkan $patchName
        $patchlist = Patchlist::where('patchlist', $patchName)->first();
        if ($patchlist) {
            $patchlist->status = $newStatus;
            $patchlist->save();
            
            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Data patch tidak ditemukan.'], 404);
        }
    }

    public function getDataByStatus(Request $request)
    {
        $status = (int)$request->input('status'); 
        $patchlist = Patchlist::where('status', $status)->pluck('patchlist')->toArray();

        return response()->json(['patches' => $patchlist]);
    }

    public function showPatchDetail($patchName)
    {
        $patchData = Patchlist::where('patchlist', $patchName)->first();
    
        return view('statuspatchlist.detail', compact('patchData'));
    }

    public function getDetailPatchData(Request $request)
    {
        $patchName = $request->input('patchName');
        $patch = Patchlist::where('patchlist', $patchName)->first();

        if ($patch) {
            $formattedCreatedDate = date('Y-m-d', strtotime($patch->created_at));

            if ($patch->tanggal_patch !== null) {
                $formattedTanggalPatch = date('Y-m-d', strtotime($patch->tanggal_patch));
            } else {
                $formattedTanggalPatch = '-';
            }

            $namaKlien = User::find($patch->klien_id);
            $namaKlien = $namaKlien ? $namaKlien->nama : '-';
            $namaProyek = Proyek::find($patch->proyek_id);
            $namaProyek = $namaProyek ? $namaProyek->nama_proyek : '-';

            return response()->json([
                "namaKlien" => $namaKlien,
                "namaProyek" => $namaProyek,
                "patchName" => $patch->patchlist,
                "prioritas" => $patch->prioritas,
                "tanggalRequest" => $formattedCreatedDate,
                "kesulitan" => $patch->kesulitan,
                "status" => $patch->status,
                "tanggal_patch" => $formattedTanggalPatch,
                "keterangan" => $patch->keterangan,
            ]);
        } else {
            return response()->json(["error" => "Data detail patch untuk $patchName tidak ditemukan."], 404);
        }
    }

}
