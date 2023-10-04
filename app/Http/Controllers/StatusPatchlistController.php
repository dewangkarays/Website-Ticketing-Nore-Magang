<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Model\User;
use App\Model\Proyek;
use App\Model\Patchlist;
use App\Model\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        $newStatus = $request->input('newStatus');
        $patchName = $request->input('patchName');

        $patchlist = Patchlist::where('patchlist', $patchName)->first();
        if ($patchlist) {
            $previousStatus = $patchlist->status;
            
            if ($previousStatus == 3 && $newStatus != 3) {
                $tanggalPatchTerakhir = $patchlist->tanggal_patch;
            }

            $patchlist->status = $newStatus;
            $patchlist->save();
            
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity_type' => 'edit',
                'patch_name' => $patchName,
                'activity_details' => 'Mengedit status patchlist ' . $patchName,
            ]);

            if ($newStatus == 3) {
                $patchlist->tanggal_patch = now();
            } elseif ($previousStatus == 3 && $newStatus != 3) {
                $patchlist->tanggal_patch = $tanggalPatchTerakhir;
            }
            
            $patchlist->save();

            $query = DB::table('patchlists')
                ->select('id', 'patchlist', 'prioritas', 'created_at', 'kesulitan', 'status', 'keterangan')
                ->addSelect(DB::raw("CASE WHEN status = 3 THEN tanggal_patch ELSE NULL END as tanggal_patch"))
                ->where('patchlist', $patchName)
                ->first();

            if ($previousStatus == 3) {
                $query->tanggal_patch = $tanggalPatchTerakhir;
            }

            return response()->json($query);
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
        $activityLogs = ActivityLog::where('patch_name', $patchName)->get();

        return view('statuspatchlist.index', compact('patchData', 'activityLogs'));
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

    public function getActivityLogByPatchName(Request $request)
    {
        $patchName = $request->input('patchName');
        $activityLogs = ActivityLog::where('patch_name', $patchName)->get();

        return response()->json($activityLogs);
    }

    public function getUserNameById(Request $request)
    {
        $userId = $request->input('userId');
        $user = User::find($userId);

        if ($user) {
            return response()->json(['userName' => $user->nama]);
        } else {
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }
    }

}
