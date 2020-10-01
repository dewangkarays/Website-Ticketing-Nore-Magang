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
            line-height: 1.2;
        }
        table tr td,
        table tr th{
            font-size: 10pt;
        }
        body{
            font-family:Arial, Helvetica, sans-serif;
        }
        
        ul {
            width: 75%;
            list-style: none;
            word-break: break-all;
        }
        ul li:before {
            content: '- ';
            margin-left: -20px;
            margin-right: 10px;
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
                <p style="width: 200px;word-wrap: break-word;">{{$setting->alamat}}</p>
                <p> +{{$setting->no_telp}} </p>
                    </td>
                    
                    <td align="right" colspan="2" style="font-size: 32px; font-weight: bold">
                    <img src="{{url($setting->logo)}}" alt="logo" height="50px">
                    </td>
                </tr>
                
            </table>
            
            <h1 class="nore-fontcolor">Invoice</h1>
            <h2 style="color:#fabf16">Tanggal : {{date('Y F d')}} </h2>
            
            <table style="margin-top: 20px">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <table style="padding-right: 50px">
                            <tr>
                                <td><b>Ditujukan Kepada</b></td>
                            </tr>
                            
                            <tr>
                                <td>{{$invoice->user->nama}}</td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>
                            
                            <tr style="width: 200px">
                                <td style="font-size: 12px;">
                                    {{$invoice->user->alamat}} 
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top">
                        <table style="padding-left: 50px">
                            <tr>
                                <td><b>Invoice#</b>
                                    <br> {{$invoice->invoice}} </td>
                                </tr>
                                
                                <tr>
                                    <td><b></b></td>
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr>
                                    <td style="font-size: 12px;">
                                        <b>Proyek</b>
                                        <br>{{$invoice->nama_proyek}}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                
                <hr>
                
                <table class="main-table" style="margin-top: 30px">
                    <tr>
                        <th align="left" style="width: 65%" class="nore-fontcolor">Deskripsi</th>
                        
                        <th style="width: 35%">Total</th> 
                    </tr>
                    
                    <tbody> 
                        
                        <tr>
                            <td>{{$invoice->keterangan}}</td>
                            <td align="right">Rp @angka($invoice->jml_tagih)</td> 
                        </tr>
                        <tr>
                            <td colspan="2" style="background-color: white">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right" class="nore-fontcolor">Subtotal</td>
                            <td align="right"> <b>Rp @angka($invoice->jml_tagih)</b></td> 
                        </tr> 
                    </tbody>
                    <tfoot >
                        <tr>
                            <td rowspan="7" style="vertical-align: top;">
                                <span style="font-size: 18px">Catatan :</span> <br>
                                <p style="width: 320px;word-wrap: break-word;line-height: 1.2"> {{$setting->catatan_tagihan}} </p>
                                
                                    </td>
                                    <td align="right" style="color:#fabf16"><h1>Rp @angka($invoice->jml_tagih) </h1></td>
                                    
                                </tr>
                                
                            </tfoot>
                        </table>
                        
                        @if (count($lampirans)>0)
                        <table class="page-break">
                            @else
                            
                            <table>
                                @endif
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="center" style="width:20%">Semarang</td>
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
                                    <td>&nbsp;</td>
                                    <td align="center" style="width:20%">{{$invoice->penagih}},<br> {{$invoice->pospenagih}} </td>
                                </tr>
                            </table>
                            
                            
                            <br>
                            @if ($lampirans != null)
                            
                            <table>
                                @php ($i = 1)
                                @foreach ($lampirans as $lampiran)
                                <tr>
                                    <td>
                                        Lampiran {{$i}} : {{ $lampiran->keterangan}} 
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <img src="{{url($lampiran->gambar)}}" style="width:50%;object-fit: cover;">
                                        
                                    </td>
                                </tr>
                                <br>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                
                                @php ($i++)
                                @endforeach
                            </table>
                            @endif
                            
                            
                            
                            
                        </main>
                        
                        
                    </body>
                    </html>
                    