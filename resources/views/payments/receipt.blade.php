<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nore</title>
    
    <style type="text/css">
        
        @page {
            margin: 50px 50px;
        }
        *{
            box-sizing: border-box;
        }
        table{
            border-collapse: collapse;
            width: 100%;
            line-height: 1;
            color: #595657;
        }
        table tr td,
        table tr th{
            font-size: 9pt;
        }
        body{
            font-family:Arial, Helvetica, sans-serif;
            margin-left: 60px;
            margin-right: 80px;
        }

        hr {
            border-top: .1px solid #595657;
        }
        
        .head-block {
            margin-left: -40px !important;
            margin-right: -80px !important;
        }

        .from-table {
            line-height: 1.2 !important;
            font-weight: bold;
            font-size: 14px !important;
        }
        
        .main-table{
            width: 100%;
            table-layout: fixed;
        }
        .main-table td, .main-table th{
            border: 2px solid white;
            padding: 5px 10px;
        }
        .main-table tbody td{
            background-color: #d8ead2;
            font-weight: bold;
            font-size: 11px;
        }
        .main-table th{
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
            /* background-color: #1C2555; */
            color: #39b873
        }
        .page-break {
            page-break-after: always;
        }
        
        .nore-bgcolor {
            background-color: #39b873;
        }
        
        .nore-fontcolor {
            color: #39b873;
        }
        
        .footer {
            /* position: fixed; */
            /* left: 0;
            bottom: 0; */
            margin-left: -40px !important;
            margin-right: -80px !important;
        }
    </style>
</head>

<body style="background-color:#ffffff;">
    <header>
        
    </header>
    <footer>
        
    </footer>
    <main>
        <table class="head-block" style="margin-bottom: 10px;">
            <tr>
                <td class="nore-bgcolor">&nbsp;</td>
            </tr>
        </table>
        <table>
            <tr>
                <td rowspan="4" style="vertical-align: top">
                    <h2 class="nore-fontcolor">NORE Inovasi</h2>
                <p><?php echo $setting->alamat ?></p>
                <p>{{$setting->no_telp}} </p>
                    </td>
                    
                    <td align="right" colspan="2" style="font-size: 32px; font-weight: bold">
                        <img src="{{url($setting->logo)}}" alt="logo" height="60px">
                    </td>
                </tr>
                
            </table>
            
            <div style="line-height: 0.1">
                <h1 class="nore-fontcolor font-weight-bold" style="font-size: 40px;">Payment Receipt</h1>
                <h4 style="color:#fabf16">Tanggal : {{date('d F Y')}} </h4>
            </div>
            
            
            <table style="margin-top: 10;line-height: 0.6 !important">
                <tr>
                    <td colspan="2">
                        <h3><b>Receipt No:</b></h3>
                        <p>{{$receipt->receipt_no}}</p>
                    </td>
                </tr>
            </table>

            <table style="margin-top: 20px" class="from-table">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <table style="padding-right: 50px">
                            <tr>
                                <td style="width: 20%">Diterima Dari</td>
                                <td style="width: 80%" align="left">: {{$receipt->nama ? $receipt->nama : $receipt->user->nama}}</td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Uang Sebesar</td>
                                <td style="width: 80%" align="left">: Rp @angka($receipt->nominal)</td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Terbilang</td>
                                
                                <td style="width: 80%" align="left">: 
                                    @php
                                    use App\Http\Controllers\PaymentController;
                                    $nilai = $receipt->nominal;
                                    echo PaymentController::terbilang($nilai, $style=3);
                                    @endphp    
                                    Rupiah</td>
                                </tr>
                            </table>
                        </td>       
                    </tr>
                </table>
                <br>
                
                
                <hr style="">
                
                <table class="main-table" style="margin-top: 10px">
                    <tr>
                        <th align="left" class="nore-fontcolor">No. Invoice</th>
                        <th>Jumlah</th> 
                        <th>Status</th> 
                        <th>Keterangan</th> 
                    </tr>
                    
                    <tbody> 
                        
                        <tr>
                            <td>{{@$receipt->tagihan->invoice}} </td>
                            <td align="right">Rp @angka($receipt->nominal) </td>
                            <td>{{config('custom.tagihan_status.'.@$receipt->tagihan->status)}} </td>
                            <td>{{$receipt->keterangan}} </td>
                        </tr>
                        
                    </tbody>
                    <tfoot >
                        
                        
                    </tfoot>
                </table>
                <br>
                <hr style=""><br>
                
                <table style="line-height: 0.1">
                    <tr>
                        <td><h3><b>Tanggal</b></h3></td>
                        <td style="width: 80%" align="left  "><h3><b>: {{date('d F Y')}}</b></h3></td>
                    </tr>
                    <tr>
                        <td><h3><b>Diterima Oleh</b></h3></td>
                    <td style="width: 80%" align="left  "><h3><b>: {{$receipt->penerima ? $receipt->penerima : $setting->penerima}}</b></h3></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="width:20%">Semarang</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" style="width:30%"><h3><b>
                            {{$receipt->ttd_penerima ? $receipt->ttd_penerima : $setting->ttd_penerima}},
                            <br>{{$receipt->ttd_pospenerima ? $receipt->ttd_pospenerima : $setting->ttd_pospenerima}}
                        </b></h3>
                    </td>
                    <td>&nbsp;</td>
                </tr>
                
                
                
            </main>
            
            <div class="footer">
                <table>
                    <tr>
                        <td class="nore-bgcolor">&nbsp;</td>
                    </tr>
                </table>
            </div>
        </body>
        </html>
        