<?php

namespace App\Http\Controllers\Api;

use Image;
use Carbon\Carbon;
use App\Model\Cuti;
use App\Model\User;
use App\Model\Presensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QrcodeApiController extends Controller
{
    public function index()
    {
        // $month = Carbon::now();
        // $start = Carbon::parse($month)->startOfMonth();
        // $end = Carbon::parse($month)->endOfMonth();

        // $dates = [];
        // while ($start->lte($end)) {
        //     $dates[] = [
        //         'tanggal' => $start->copy()->format('Y-m-d'),
        //         'day' => $start->copy()->format('d'), // for display purposes
        //     ];
        //     $start->addDay();
        // }

        // // Get data for all users
        // $karyawans_all = User::where('role', '<=' ,'50')
        //     ->where('role', '!=', 1)
        //     ->with(['presensi' => function ($q) {
        //         $q->orderBy('tanggal'); 
        //     }])
        //     ->get()
        //     ->toArray();

        // $presensi_all = Presensi::orderBy('tanggal')->get();
        // $sakit_all = Presensi::where('status', '3')->count();
        // $izin_all = Presensi::where('status', '2')->count();          
        // $WFH_all = Presensi::where('status', '4')->count();

        // Get data for the authenticated user
        $presensi = Presensi::where('user_id', \Auth::user()->id)->orderBy('tanggal')->get();
        $karyawans = User::where('id', \Auth::user()->id)
            ->with(['presensi' => function ($q) {
                $q->orderBy('tanggal'); 
            }])
            ->first();
            // ->toArray();

        $hadir = Presensi::where('user_id', \Auth::user()->id)->where('status', '1')->count();
        $sakit = Presensi::where('user_id', \Auth::user()->id)->where('status', '3')->count();
        $izin = Presensi::where('user_id', \Auth::user()->id)->where('status', '2')->count();     
        $WFH = Presensi::where('user_id', \Auth::user()->id)->where('status', '4')->count(); 
        $sisa_cuti = 12 - $izin;
        $user = auth()->user();
        $roleId = $user->role;
        $user->divisi = config('custom.role.' . $roleId, null);
        // $namaDandivisi = [
        //     'nama' => $user->nama,
        //     'divisi' => $user->divisi,
        // ];

        $years = Presensi::selectRaw('year(tanggal) as tahun')
            ->whereNotNull('status')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $data = [
            // 'dates' => $dates,
            // 'presensi' => $presensi,
            'nama' => $user->nama,
            'divisi' => $user->divisi,
            // 'user' => $namaDandivisi,
            'Hadir'=> $hadir,
            'sakit' => $sakit,
            'izin' => $izin,
            'WFH' => $WFH,
            'sisa_cuti' => $sisa_cuti,
            'presensi' =>  $presensi->map(function ($item) {
                $statusMap = [
                    '1' => 'Hadir',
                    '2' => 'Izin',
                    '3' => 'Sakit',
                    '4' => 'WFH',
                    
                ];
        
                $item->status_kehadiran = $statusMap[$item->status];
                return $item;
                
            }),
            //     'izin'=> $karyawans->izin,
            //     'sakit'=>
            // ],
            // 'presensi_all' => $presensi_all,
            // 'sakit_all' => $sakit_all,
            // 'izin_all' => $izin_all,
            // 'karyawans_all' => $karyawans_all,
            'years' => $years,
            'WFH' => $WFH,
            'id'     => auth()->user()->status,
            'status' => config('custom.status_presensi'.auth()->user()->status),
            // 'presensi' => $presensi->map(function ($item) {
            //     $statusMap = [
            //         '1' => 'Hadir',
            //         '2' => 'Izin',
            //         '3' => 'Sakit',
            //         '4' => 'WFH',
            //     ];
        
            //     $item->status_label = $statusMap[$item->status];
            //     return $item;
            // }),
        ];

         return response()->json([
            'code'=>200, 
            'status'=>'Success', 
            'message'=>'Get data attachment success', 
            'data'=> $data
        ]);
    }


    public function create()
    {
        $role = Auth::user()->role;
        $users = [];

        if ($role == 1) {
            $users = User::where('role', '<', 80)
                ->orderBy('role')
                ->get();
        } else {
            $user = User::find(Auth::id());
            if ($user) {
                $users[] = $user;
            }
        }

        return response()->json(['users' => $users, 'role' => $role], 200);
    }


        public function store(Request $request)
    {
       
        $request->validate([
            'tanggal' => 'required',
            'status' => 'required',
            'user_id' => 'required',
        ]);
        // dd($request);
        $check = Presensi::where('user_id', $request->get('user_id'))
            ->where('tanggal', $request->get('tanggal'))
            ->get();

        $cuti = Cuti::where('user_id', $request->get('user_id'))
            ->where('tanggal_mulai', '<=', $request->get('tanggal'))
            ->where('tanggal_akhir', '>=', $request->get('tanggal'))
            ->get();
        
        if (count($check) != 0) {
            return response()->json(['error' => 'Presensi Sudah Diisi!'], 422);
        }

        if (count($cuti) != 0) {
            return response()->json(['error' => 'Karyawan Sedang Cuti!'], 422);
        }
        // dd($request);
        $presensi = new Presensi();
        $presensi->tanggal = $request->get('tanggal');
        $presensi->status = $request->get('status');
        $presensi->user_id = $request->get('user_id');

        if ($presensi->status != 1) {
            $presensi->keterangan = $request->get('keterangan');

            $file = $request->file('bukti');
            $destination = config('app.upload_url') . 'attachment/bukti_ketidakhadiran';

            if ($file) {
                $nama = Auth::id() . "_" . time() . "." . $file->getClientOriginalName();
                $img = Image::make($file->getRealPath());
                $img->save($destination . '/' . $nama);

                if ($img) {
                    $presensi->bukti = $destination . '/' . $nama;
                }
            }

            $user = User::find($presensi->user_id);

            $content = null;
            $content['user'] = $user;
            $content['status'] = $presensi->status;
            $content['keterangan'] = $presensi->keterangan;

            sendWebhookAbsensi($content);
            // dd($request);
        }

        $presensi->save();

        return response()->json(['message' => 'Presensi Saved!'], 201);
     }

}

