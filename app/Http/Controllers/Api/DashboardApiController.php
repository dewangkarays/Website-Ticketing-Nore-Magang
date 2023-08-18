<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Klien;

class DashboardApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $data = Klien::all();

    // Mendapatkan data sebelumnya dari cache atau database
    $previousData = // Dapatkan data sebelumnya di sini

    $response = [
        'Deal' => 0,
        'Pending' => 0,
        'Live' => 0,
    ];

    foreach($data as $dt){
        if($dt->status == 4){
            $response['Deal'] += 1;
        }
        if($dt->status == 5){
            $response['Pending'] += 1;
        }
        if($dt->status == 8){
            $response['Live'] += 1;
        }
    }

    // Kenaikan jumlah dari data sebelumnya ke data sekarang
    $increaseDeal = $response['Deal'] - $previousData['Deal'];
    $increasePending = $response['Pending'] - $previousData['Pending'];
    $increaseLive = $response['Live'] - $previousData['Live'];

    $totalCount = count($data);

    // Menghitung persentase kenaikan
    $percentageDeal = ($totalCount !== 0) ? (($response['Deal'] / $totalCount) * 100) : 0;
    $percentagePending = ($totalCount !== 0) ? (($response['Pending'] / $totalCount) * 100) : 0;
    $percentageLive = ($totalCount !== 0) ? (($response['Live'] / $totalCount) * 100) : 0;

    return response()->json([
        'status' => true,
        'message' => 'Data Ditemukan',
        'data' => [
            'status' => [
                'Deal' => [
                    'count' => $response['Deal'],
                    'increase' => $increaseDeal,
                    'percentage' => $percentageDeal . '%',
                ],
                'Pending' => [
                    'count' => $response['Pending'],
                    'increase' => $increasePending,
                    'percentage' => $percentagePending . '%',
                ],
                'Live' => [
                    'count' => $response['Live'],
                    'increase' => $increaseLive,
                    'percentage' => $percentageLive . '%',
                ],
            ],
        ],
    ], 200);
}

    public function getMarketingData()
{
    $penmark = [];
    $klien = Klien::selectRaw('users.id, users.nama, COUNT(kliens.id) as jumlah')
        ->leftJoin('users', 'users.id', '=', 'kliens.marketing_id')
        ->groupBy('users.id', 'users.nama')
        ->get();

    foreach ($klien as $klienData) {
        $penmark[$klienData->nama] = $klienData->jumlah;
    }

    return $penmark;
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
