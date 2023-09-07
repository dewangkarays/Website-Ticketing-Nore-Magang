<?php

namespace App\Http\Controllers\Api;

use DateTime;
use Carbon\Carbon;
use App\Model\Cuti;
use App\Model\User;
use App\Model\Nomor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;


class CutiApiController extends Controller
{

//     public function index(Request $request)
// {
//     $currentUserId = Auth::id();
//     $today = Carbon::today();
//     if ($request->has('status') && $request->status == 'aktif') {
//         if (Auth::user()->role == 1) {
//             $cuti = Cuti::where('status', '<', '3')
//                 ->where('tanggal_akhir', '>=', $today)
//                 ->orderByDesc('id')
//                 ->with('karyawan')
//                 ->with('verifikator2')
//                 ->with('verifikator1')
//                 ->get();
//         } else {
//             $cuti = Cuti::where('status', '<', '3')
//                 ->where('tanggal_akhir', '>=', $today)
//                 ->where('user_id', $currentUserId)
//                 ->orderByDesc('id')
//                 ->with('karyawan')
//                 ->with('verifikator2')
//                 ->with('verifikator1')
//                 ->get();
//         }

//         return response()->json(['data' => $cuti], 200);
//     }

//     return response()->json(['error' => 'Invalid request'], 400);
// }
    // public function create1()
    // {
    //     $users = User::where('id', '=', Auth::user()->id)->get();
    //     $karyawans = User::where('role', '<=', '50')->get();
    //     if (auth()->user()->role != 1) {
    //         $karyawan = User::find(auth()->id());
    //         $sisa_cuti = $karyawan->sisa_cuti;
            
       
        
    //         // dd($users);
    //     // $data = [
    //     //     'user' => $users,
    //     //     'karyawan' => $karyawans,
    //     //     'sisa_cuti' => $sisa_cuti,
            

    //     //         ];

    //         return response()->json(compact('users', 'karyawan', 'sisa_cuti',), 200);
    //     }

    //     return response()->json(compact('users', 'karyawans'), 200);
    // }


    public function create(Request $request)
    {
        $users = User::where('id', '=', Auth::user()->id)->get();
        $karyawans = User::where('role', '<=', '50')->get();
        if (auth()->user()->role != 1) {
            $karyawan = User::find(auth()->id());
            $sisa_cuti = $karyawan->sisa_cuti;
            $cuti = new Cuti();
            $verifikator2 = $request->get('verifikator_2');
            $verifikator1 = $request->get('verifikator_1');
            
            
            // dd($users);
        // $data = [
        //     'user' => $users,
        //     'karyawan' => $karyawans,
        //     'sisa_cuti' => $sisa_cuti,
        //     'presensi' =>  $presensi->map(function ($item) {
        //         $statusMap = [
        //             '1' => 'Hadir',
        //             '2' => 'Izin',
        //             '3' => 'Sakit',
        //             '4' => 'WFH',
                    
        //         ];
        
        //         $item->status_kehadiran = $statusMap[$item->status];
        //         return $item;
                
        //     }),
            

        //         ];

        // return response()->json(compact('users', 'karyawan', 'sisa_cuti', 'verifikator2'), 200);
    }

        return response()->json(compact('users', 'karyawan', 'verifikator2'), 200);
    }

    public function store(Request $request) {
        $request->validate([
            'verifikator_2' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'alasan' => 'required'
        ]);

        // $tanggal_mulai = new DateTime($request->input('tanggal_mulai'));
        // $tanggal_akhir = new DateTime($request->input('tanggal_akhir'));
        
        // $check = Cuti::where('user_id', \Auth::user()->id)
        //     ->where('status', '<>', 0)
        //     ->where(function ($query) use ($tanggal_mulai, $tanggal_akhir) {
        //         $query->where(function ($q) use ($tanggal_mulai, $tanggal_akhir) {
        //             $q->where('tanggal_mulai', '<=', $tanggal_mulai)
        //                 ->where('tanggal_akhir', '>=', $tanggal_mulai);
        //         })->orWhere(function ($q) use ($tanggal_mulai, $tanggal_akhir) {
        //             $q->where('tanggal_mulai', '<=', $tanggal_akhir)
        //                 ->where('tanggal_akhir', '>=', $tanggal_akhir);
        //         });
        //     })
        //     ->exists();
        
        // if ($check) {
        //     return response()->json(['error' => 'Permohonan cuti doubleh dengan cuti sebelumnya'], 400);
        // }
        

    
        $cuti = new Cuti();
        $verifikator2 = $request->input('verifikator_2');
        $verifikator1 = $request->input('verifikator_1');
    
        $cuti->status = 1;
    
        if ($request->input('tanggal_mulai') == null || $request->input('tanggal_akhir') == null) {
            return response()->json(['error' => 'Tanggal Tidak Boleh Kosong!'], 400);
        }
    
        $start = new DateTime($request->input('tanggal_mulai'));
        $end = new DateTime($request->input('tanggal_akhir'));
        $interval = $start->diff($end);
        $check = $interval->invert;
    
        if ($check == 1) {
            return response()->json(['error' => 'Tanggal Tidak Sesuai!'], 400);
        }
    
        $cuti->tanggal_mulai = $request->input('tanggal_mulai');
        $cuti->tanggal_akhir = $request->input('tanggal_akhir');
        $cuti->alasan = $request->input('alasan');
    
        $nama_verif2 = User::where('id', $verifikator2)->first();
    
        if ($nama_verif2) {
            $cuti->verifikator_2 = $nama_verif2->nama;
            $cuti->verifikator_2_id = $verifikator2;
        } else {
            return response()->json(['error' => 'Verifikator 2 not found'], 404);
        }
    
        // dd($nama_verif2);
        $nama_verif1 = null;
        $cuti->verifikator_1 = null;
        $cuti->verifikator_1_id = null;
    
        if ($verifikator1 != null) {
            $nama_verif1 = User::where('id', $verifikator1)->first();
            if ($nama_verif1) {
                $cuti->verifikator_1 = $nama_verif1->nama;
                $cuti->verifikator_1_id = $verifikator1;
            } else {
                return response()->json(['error' => 'Verifikator 1 not found'], 404);
            }
        }
    
        if (\Auth::user()->id == 1) {
            $cuti->user_id = $request->input('name');
        } else {
            $cuti->user_id = \Auth::user()->id;
        }
    
        $cuti->jumlah_hari = $request->input('jumlah_hari');
    
        // Nomor Permohonan Izin Cuti
        $nomor = Nomor::first();
        $npic = $nomor->npic;
    
        if ($npic == null || $npic == 0) {
            $npic = 1;
        } else {
            $npic++;
        }
    
        $npic_pad = str_pad($npic, 3, 0, STR_PAD_LEFT);
    
        $cuti->nomor_permohonan_cuti = 'NI/PIC/' . $npic_pad . '/' . date('dmY');
    
        $nomor->npic = $npic;
        $nomor->update();
    
        $cuti->save();
    
        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'message' => 'Cuti Saved!',
            'cuti' => $cuti
            
            ]);
    }

        public function getverifikator(Request $request, $id)
        {
            $user = \Auth::user(); 

    if ($user->atasan_id != null) {
        $verifs = User::where('role', '<=', '50')
            ->where('role', '>=', '10')
            ->get();

        $atasan_id = $user->atasan_id;
        $data = [];
        $j = 0;

        while ($atasan_id) {
            $verif = $verifs->where('id', $atasan_id)->first();
            if ($verif) {
                $data[$j]['id'] = $verif->id; 
                $data[$j]['nama'] = $verif->nama; 
                $atasan_id = $verif->atasan_id;
                $j++;
            } else {
                break; 
            }
        }

        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'message' => 'Get data verifikator success',
            'data' => $data
        ]);
    } elseif ($user->atasan_id == null && $user->id != 1) {
        $verifs = User::where('role', '<=', '50')
            ->where('role', '>=', '10')
            ->whereNotNull('atasan_id')
            ->get();

        $formattedVerifs = $verifs->map(function ($verif) {
            return [
                'id' => $verif->id,
                'nama' => $verif->nama,
            ];
        });

        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'message' => 'Get data verifikator success',
            'data' => $formattedVerifs
        ]);
    } else {
        $verifs = User::where('role', '<=', '50')
            ->where('role', '>=', '10')
            ->get();

        $formattedVerifs = $verifs->map(function ($verif) {
            return [
                'id' => $verif->id,
                'nama' => $verif->nama,
            ];
        });

        return response()->json([
            'code' => 200,
            'status' => 'Success',
            'message' => 'Get data verifikator success',
            'data' => $formattedVerifs
        ]);
    }
            
        }

    public function getcuti($status)
    {
        $currentUserId = Auth::id();
        $today = Carbon::today();
        $user = Auth::user();

        $cuti = $user->cuti()->orderByDesc('id');

        if ($status == 'aktif') {
            $cuti->where('status', '<', '3')
                ->where('tanggal_akhir', '>=', $today);
                
            if (Auth::user()->role != 1) {
                $cuti->where('user_id', $currentUserId);
            }
        } elseif ($status == 'history') {
            $cuti->where(function ($q) use ($today) {
                $q->where('status', '>', '2')
                    ->orWhere('tanggal_akhir', '<', $today);
            });
            
            if (Auth::user()->role != 1) {
                $cuti->where(function ($q) use ($currentUserId) {
                    $q->where('user_id', $currentUserId)
                        ->orWhere('verifikator_2_id', $currentUserId)
                        ->orWhere('verifikator_1_id', $currentUserId);
                });
            }
        } elseif ($status == 'verifikasi') {
            $cuti->where(function ($q) {
                $q->where('verifikasi_2', '<', '2')
                    ->orWhere('verifikasi_1', '<', '2');
            })
            ->where('status', '<', '3')
            ->where('tanggal_akhir', '>=', $today);
            
            if (Auth::user()->role != 1) {
                $cuti->where(function ($q) use ($currentUserId, $today) {
                    $q->where(function ($q1) use ($currentUserId, $today) {
                            $q1->where('verifikator_2_id', $currentUserId)
                                ->where('verifikasi_2', '<', '3')
                                ->where('tanggal_akhir', '>=', $today);
                        })
                        ->orWhere(function ($q2) use ($currentUserId, $today) {
                            $q2->where('verifikator_1_id', $currentUserId)
                                ->where('verifikasi_2', '2')
                                ->where('tanggal_akhir', '>=', $today);
                        });
                });
            }
        }

        $cuti = $cuti->get();

        $statuscuti = Config::get('custom.status_cuti');

        foreach ($cuti as &$cutiItem) {
            $cutiItem['status_cuti'] = $statuscuti[$cutiItem['status']];
        }


       return response()->json([
        'code' => 200, 
        'status' => 'Success', 
        'message' => 'Get data cuti success', 
        'data' => $cuti
    ]);
    }

    public function statuscuti()
    {

        $statuscuti = Config::get('custom.status_cuti');

        $statusArray = [];
        foreach ($statuscuti as $id => $nama) {
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
