<?php

namespace App\Http\Controllers\Api;

use Image;
use Carbon\Carbon;
use App\Model\Cuti;
use App\Model\User;
use Ramsey\Uuid\Uuid;
use App\Model\Presensi;
use App\Model\PresensiQR;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class QrcodeApiController extends Controller
{
    public function index()
    {
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
      
        $years = Presensi::selectRaw('year(tanggal) as tahun')
            ->whereNotNull('status')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $data = [
          
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
     
            'years' => $years,
            'WFH' => $WFH,
            'id'     => auth()->user()->status,
            'status' => config('custom.status_presensi'.auth()->user()->status),
           
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
            return response()->json([
                'code'=>400, 
                'status' => 'Gagal',
                'message' => 'Presensi Sudah Diisi!'
            ],400);
        }

        if (count($cuti) != 0) {
            return response()->json([
                'code'=>400, 
                'status' => 'Gagal',
                'message' => 'Karyawan Sedang Cuti!'
            ], 422);
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

        return response()->json([
            'code' => 201,
            'status' => 'Success',
            'message' => 'Presensi Berhasil!'
        ], 201);
     }

     public function storeqr(Request $request)
     {  
        // dd($request);
        if (\Auth::check()) {
            $user = \Auth::user();
            $request->validate([
                'uuid' => 'required',
                 
            ]);
            $cacheKey = 'uuid_' . now()->toDateString();

            $uuid = Cache::remember($cacheKey, now()->addDay(), function () {
            return Uuid::uuid4()->toString();
            });
            
            $uuidcheck = PresensiQR::orderBy('id', 'desc')->first();
            // dd($uuidcheck);
            if (!$uuidcheck || $request->uuid !== $uuidcheck->uuid) {
                return response()->json([
                    'code' => 400,
                    'status' => 'Gagal',
                    'message' => 'UUID tidak valid',
                ], 400);
            }
        
            $existingPresensi = Presensi::where('user_id', $user->id)
                ->whereDate('tanggal', now())
                ->first();
        
            if ($existingPresensi) {
                return response()->json([
                    'code' => 400,
                    'status' => 'Gagal',
                    'message' => 'Presensi untuk tanggal ini sudah diisi',
                ], 400);
            }
        
            $presensi = Presensi::create([
                'tanggal' => now(),
                'status' => 1,
                'user_id' => $user->id,
                'uuid' => $uuid,
            ]);
        
            return response()->json([
                'code' => 200,
                'status' => 'Success',
                'message' => 'Presensi berhasil disimpan dengan UUID',
                'uuid' => $uuid,
                'presensi' => $presensi,
            ], 200);
        } 
        else {
            return response()->json([
                'code' => 400,
                'message' => 'Anda tidak terautentikasi',
            ], 400); 
        }
        
     }

     public function userinfo()
     {
        $user = auth()->user();
        $roleId = $user->role;
        $user->divisi = config('custom.role.' . $roleId, null);

        $today = now()->format('Y-m-d');

        $hadir = Presensi::where('user_id', \Auth::user()->id)->where('status', '1')->whereDate('tanggal', $today)->count();
        $sakit = Presensi::where('user_id', \Auth::user()->id)->where('status', '3')->whereDate('tanggal', $today)->count();
        $izin = Presensi::where('user_id', \Auth::user()->id)->where('status', '2')->whereDate('tanggal', $today)->count();
        $WFH = Presensi::where('user_id', \Auth::user()->id)->where('status', '4')->whereDate('tanggal', $today)->count();
        $sisa_cuti = 12 - $izin;

        $validasipresensi = ($hadir + $sakit + $izin + $WFH) > 0;

        $user->hadir = $hadir;
        $user->sakit = $sakit;
        $user->izin = $izin;
        $user->WFH = $WFH;
        $user->sisa_cuti = $sisa_cuti;
        $user->validasi_presensi = $validasipresensi;

        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'message' => 'User Info Diterima',
            'user' => $user
            
        ]);

    }

    public function statuspresensi()
    {

        $statusPresensi = Config::get('custom.status_presensi');

        $statusArray = [];
        foreach ($statusPresensi as $id => $nama) {
            $statusArray[] = [
                'id' => $id,
                'nama' => $nama,
            ];
        }

        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'message' => 'Status Presensi Diterima',
            'user' => $statusArray
            
        ]);
    }

}

