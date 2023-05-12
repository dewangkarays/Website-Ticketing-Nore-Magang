<?php

namespace App\Http\Controllers;

use App\Model\TargetMarketing;
use App\Model\User;
use App\Model\Klien;
use App\Model\Payment;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use DatePeriod;

class TargetMarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['marketings'] = User::where('role', 50)->get();

        return view('targetmarketing.index', $result);
    }

    public function targetmarketingdatatable()
    {
        $targetmarketings = TargetMarketing::where('id','>',0);

        $targetmarketings = $targetmarketings->with('marketing')->get();

        $leads = Klien::all();
        $payments = Payment::all();

        foreach ($targetmarketings as $tmarketing) {
            $tmarketing['actual_lead'] = 0;            
            $tmarketing['actual_deal'] = 0;
            $tmarketing['actual_nominal'] = 0;

            foreach ($leads as $lead) {
                $cekperiode = date('Y-m', strtotime($tmarketing->periode)) == date('Y-m', strtotime($lead->created_at)) ? true:false;
                $cekmarketing = $tmarketing->marketing_id == $lead->marketing_id ? true:false;
                $cekstatusdeal = $lead->status == 4 ? true:false;

                if ($cekperiode && $cekmarketing) {
                    $tmarketing['actual_lead'] += 1;
                }
                
                if ($cekperiode && $cekmarketing && $cekstatusdeal) {
                    $tmarketing['actual_deal'] += 1;
                }
            }

            foreach ($payments as $payment) {
                if (!$payment->user) {
                    continue;
                }
                $cekperiodepayment = date('Y-m', strtotime($tmarketing->periode)) == date('Y-m', strtotime($payment->created_at))? true:false;
                $cekmarketingpayment = $tmarketing->marketing_id == $payment->user->marketing_id ? true:false;
                if ($cekperiodepayment && $cekmarketingpayment) {
                    $tmarketing['actual_nominal'] += $payment->nominal;
                }
            }
        }

        return datatables()->of($targetmarketings)->addIndexColumn()->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token', '_method','bulan_dari','tahun_dari','bulan_sampai','tahun_sampai','target_leads','target_deal','target_nominal']);

        $start = new DateTime($request->get('tahun_dari').'-'.$request->get('bulan_dari').'-01');
        $end = (new DateTime($request->get('tahun_sampai').'-'.$request->get('bulan_sampai').'-01'))->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        $data['target_leads'] = (int)str_replace(".", "", $request->get('target_leads'));
        $data['target_deal'] = (int)str_replace(".", "", $request->get('target_deal'));
        $data['target_nominal'] = (int)str_replace(".", "", $request->get('target_nominal'));

        // dd($period);
        foreach ($period as $dt) {
            $data['periode'] = $dt->format("Y-m-01");
            $target = Targetmarketing::updateOrCreate(
            [
                'marketing_id' => $data['marketing_id'],
                'periode' => $data['periode'],
            ],
            [
                'target_leads' => $data['target_leads'],
                'target_deal' => $data['target_deal'],
                'target_nominal' => $data['target_nominal'],
            ]);
        }

        return redirect('/targetmarketing')->with('success', 'Target Marketing saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\TargetMarketing  $targetMarketing
     * @return \Illuminate\Http\Response
     */
    public function show(TargetMarketing $targetMarketing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\TargetMarketing  $targetMarketing
     * @return \Illuminate\Http\Response
     */
    public function edit(TargetMarketing $targetMarketing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\TargetMarketing  $targetMarketing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TargetMarketing $targetMarketing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\TargetMarketing  $targetMarketing
     * @return \Illuminate\Http\Response
     */
    public function destroy(TargetMarketing $targetMarketing)
    {
        //
    }
}
