<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tagihan;
use App\Model\User;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagihans = Tagihan::orderBy('id')->get();
       
        return view('tagihans.index', compact('tagihans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role','>=',80)->get();

        return view('tagihans.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            //
        ]);

        $data = $request->except(['_token', '_method']);

        if($request->get('langganan')==''){
            $data['langganan'] = 0;
        }
        if($request->get('ads')==''){
            $data['ads'] = 0;
        }
        if($request->get('lainnya')==''){
            $data['lainnya'] = 0;
        }

        $data['invoice'] = 'INV'.date('YmdHis');
        $data['jml_tagih'] = $data['langganan'] + $data['ads'] + $data['lainnya'];

        $tagihan = Tagihan::create($data);
        
        return redirect('/tagihans')->with('success', 'Tagihan saved!');
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
        $users = User::where('role','>=',80)->get();
        $tagihan = Tagihan::find($id);

        return view('tagihans.edit', compact('tagihan','users')); 
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
        $request->validate([
            //
        ]);

        $data = $request->except(['_token', '_method']);
        $tagihan = Tagihan::find($id);

        if($request->get('langganan')==''){
            $data['langganan'] = 0;
        }
        if($request->get('ads')==''){
            $data['ads'] = 0;
        }
        if($request->get('lainnya')==''){
            $data['lainnya'] = 0;
        }
        if($request->get('jml_bayar')==''){
            $data['jml_bayar'] = 0;
        }

        $data['jml_tagih'] = $data['langganan'] + $data['ads'] + $data['lainnya'];

        $tagihan->update($data);
        
        return redirect('/tagihans')->with('success', 'Tagihan updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tagihan = Tagihan::find($id);
        $tagihan->delete();

        return redirect('/tagihans')->with('success', 'Tagihan deleted!');
    }
    
    public function getTagihan($id)
    {
        $tagihans = Tagihan::where('user_id', $id)->get();
        $html = '<option value="">-- Pilih Tagihan --</option>';
        foreach ($tagihans as $tagihan) {
            $html .= '<option value="'.$tagihan->id.'" data-tagihan="'.$tagihan->jml_tagih.'" >'.$tagihan->invoice.' ('.number_format($tagihan->jml_tagih,0,',','.').')</option>';
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
                <td>'.number_format($tagihan->langganan,0,',','.').'</td>
                <td>'.number_format($tagihan->ads,0,',','.').'</td>
                <td>'.number_format($tagihan->lainnya,0,',','.').'</td>
                <td>'.number_format($tagihan->jml_bayar,0,',','.').'</td>
                <td>'.number_format($tagihan->jml_tagih,0,',','.').'</td>
            </tr>
        </table>';

        return $html;
    }

    public function tagihanuser()
    {
        $tagihans = Tagihan::where('user_id',\Auth::user()->id)->get( );
       
        return view('tagihanuser', compact('tagihans'));
    }

    public function bayaruser($id)
    {
        $tagihanuser = Tagihan::where('user_id',\Auth::user()->id)->get( );
        $users = User::where('role','>=',80)->get();
        $tagihanuser2 = Tagihan::find($id);
        // dd($tagihanuser2);
        // dd($tagihan);
        return view('payments.create', compact('users', 'tagihanuser', 'tagihanuser2'));
    }
}
