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
        }
        .from-table {
            line-height: .1 !important;
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
            background-color: #f3f3f3;
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
            position: fixed;
            left: 0;
            bottom: 0;
        }
    </style>
</head>

<body style="background-color:#ffffff;">
    <header>
        
    </header>
    <footer>
        
    </footer>
    <main>
        <table style="margin-bottom: 10px;">
            <tr>
                <td class="nore-bgcolor">&nbsp;</td>
            </tr>
        </table>
        <table>
            <tr>
                <td rowspan="4" style="vertical-align: top">
                    <h2 class="nore-fontcolor">NORE Inovasi</h2>
                    <p>Gedung Setos Lantai 3 R1, Jalan Inspeksi Gajahmada No. 6
                        <br>
                        Semarang, 50133</p>
                        <p>+62 813 3562 5529</p>
                    </td>
                    
                    <td align="right" colspan="2" style="font-size: 32px; font-weight: bold">
                        <img src="{{asset('/global_assets/images/logo_nore_1000px.png')}}" alt="logo" height="50px">
                    </td>
                </tr>
                
            </table>
            
            <h1 class="nore-fontcolor">Payment Receipt</h1>
            <h2 style="color:#fabf16">Tanggal : {{date('Y F d')}} </h2>
            
            <table style="margin-top: 20px" class="from-table">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <table style="padding-right: 50px">
                            <tr>
                                <td style="width: 20%"><b><h3>Diterima Dari</h3></b></td>
                                <td style="width: 80%" align="left"><b><h3>: {{$receipt->user->nama}}</h3></b></td>
                            </tr>
                            
                            <tr>
                                <td style="width: 20%"><b><h3>Uang Sebesar</h3></b></td>
                                <td style="width: 80%" align="left"><b><h3>: Rp @angka($receipt->nominal)</h3></b></td>
                            </tr>
                            
                            <tr>
                                <td style="width: 20%"><b><h3>Terbilang</h3></b></td>
                                
                                <td style="width: 80%" align="left"><b><h3>: 
                                @php
                                    use App\Http\Controllers\PaymentController;
                                    $nilai = $receipt->nominal;
                                    echo PaymentController::terbilang($nilai, $style=3);
                                @endphp    
                                Rupiah</h3></b></td>
                            </tr>
                        </table>
                    </td>
                    
                </tr>
            </table>
            <br>
            <br>
            
            <hr style="">
            
            <table class="main-table" style="margin-top: 30px">
                <tr>
                    <th align="left" class="nore-fontcolor">No. Invoice</th>
                    <th>Jumlah</th> 
                    <th>Status</th> 
                    <th>Keterangan</th> 
                </tr>
                
                <tbody> 
                    
                    <tr>
                        <td>{{$receipt->tagihan->invoice}} </td>
                        <td>Rp @angka($receipt->nominal) </td>
                        <td>{{config('custom.tagihan_status.'.$receipt->tagihan->status)}} </td>
                        <td>{{$receipt->keterangan}} </td>
                    </tr>
                    
                </tbody>
                <tfoot >
                    
                    
                </tfoot>
            </table>
            <br>
            <hr style=""><br>
            
            <table>
                <tr>
                    <td><h3><b>Tanggal</b></h3></td>
                    <td style="width: 80%" align="left  "><h3><b>: {{date('Y F d')}}</b></h3></td>
                </tr>
                <tr>
                    <td><h3><b>Diterima Oleh</b></h3></td>
                    <td style="width: 80%" align="left  "><h3><b>: Noer Prajitno</b></h3></td>
                </tr>
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
                    <td align="center" style="width:20%"><h3><b>
                        Noer Prajitno,<br>CEO/Direktur
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
    