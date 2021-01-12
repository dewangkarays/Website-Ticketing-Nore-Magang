<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tagihan;
use App\Model\Payment;

class TagihanClient extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tagihans = Tagihan::orderBy('created_at')->get();
        $tagihanactives = Tagihan::where('user_id',\Auth::user()->id)->where('status','!=','2')->get()->count();
        $tagihanhistories = Tagihan::where('user_id',\Auth::user()->id)->where('status','=','2')->get()->count();

        return view('client.tagihan.tagihan',compact('tagihans','tagihanactives','tagihanhistories'));
    }

    public function active()
    {
        //
        $tagihans = Tagihan::orderBy('created_at')->get();
        return view('client.tagihan.tagihanaktif',['tagihans'=>$tagihans]);
    }

    public function history()
    {
        //
        $tagihans = Tagihan::orderBy('created_at')->get();
        return view('client.tagihan.tagihanriwayat',['tagihans'=>$tagihans]);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function getTagihan($id)
    {
        $tagihans = Tagihan::where('user_id', $id)->get();
        $html = '<option value="">-- Pilih Tagihan --</option>';
        foreach ($tagihans as $tagihan) {
            $html .= '<option value="'.$tagihan->id.'" data-tagihan="'.$tagihan->jml_tagih.'" >'.$tagihan->invoice.' ('.$tagihan->jml_tagih.')</option>';
        }

        return $html;
    }
    
    public function detailTagihan($id)
    {
        $tagihan = Tagihan::find($id);
        $html = '
        <table class="table table-striped">
            <tr>
                <td>Langganan</td>
                <td>Ads</td>
                <td>Lainnya</td>
                <td>Sudah Dibayar</td>
                <td>Total Tagihan</td>
            </tr>
            <tr>
                <td>'.$tagihan->langganan.'</td>
                <td>'.$tagihan->ads.'</td>
                <td>'.$tagihan->lainnya.'</td>
                <td>'.$tagihan->jml_bayar.'</td>
                <td>'.$tagihan->jml_tagih.'</td>
            </tr>
        </table>';

        return $html;
    }


}
