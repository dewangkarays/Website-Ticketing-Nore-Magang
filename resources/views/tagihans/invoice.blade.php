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
            color: #595657;
            background-color:#ffffff;
            margin-left: 60px;
            margin-right: 20px;
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
        
        .head-block {
            margin-left: -40px !important;
            margin-right: -20px !important;
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

<body>
    
    <main>
        <table class="head-block" style="margin-bottom: 10px;">
            <tr>
                <td class="nore-bgcolor" style="height: 23px">&nbsp;</td>
            </tr>
        </table>
        <table>
            <tr>
                <td rowspan="4" style="vertical-align: top">
                    <h2 class="nore-fontcolor" style="font-weight: lighter">NORE Inovasi</h2>
                    <p><?php echo $setting->alamat ?></p>
                    <p style="margin-top: -2"> +{{$setting->no_telp}} </p>
                </td>
                
                <td align="right" colspan="2" style="font-size: 32px; font-weight: bold">
                    <img src="{{url($setting->logo)}}" alt="logo" height="60px">
                </td>
            </tr>
            
        </table>
        <div style="line-height: 0.1">
            <h1 class="nore-fontcolor font-weight-bold" style="font-size: 40px;"><b>Invoice</b></h1>
            <h4 style="color:#fabf16">Tanggal : {{date('d F Y')}} </h4>
        </div>
        
        <table style="margin-top: 20px;margin-bottom: 8px;font-size: 15px !important">
            <tr>
                <td style="width: 50%; vertical-align: top">
                    <table style="padding-right: 50px">
                        <tr>
                            <td><b>Ditujukan Kepada</b></td>
                        </tr>
                        
                        <tr>
                            <td>
                                {{$invoice->nama ? $invoice->nama : $invoice->user->nama}}
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        
                        <tr style="width: 200px">
                            <td style="font-size: 12px;">
                                <span style="font-size: 12px !important">
                                    
                                    {{$invoice->user->alamat}} 
                                </span>
                                
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top">
                    <table style="padding-left: 50px;">
                        <tr>
                            <td><b>Invoice</b>
                                <br> <span style="font-size: 12px !important;">{{$invoice->invoice}}</span>
                            </td>
                            </tr>
                            
                            <tr>
                                <td><b></b></td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td style="line-height: 0.5;">
                                    <b>Proyek</b>
                                    {{-- <p>{{$invoice->nama_proyek ? $invoice->nama_proyek : $invoice->user->website}}</p> --}}
                                    <p>
                                        @if ($invoice->nama_proyek)
                                        {{$invoice->nama_proyek}} 
                                        @elseif ($invoice->user->website)
                                        {{$invoice->user->website}}
                                        @else
                                        -
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <hr style="margin-top: -8px;margin-bottom: -8px">
            
            <table class="main-table" style="margin-top: 30px;margin-bottom: 5px;line-height: 0.7">
                <tr>
                    <th align="left" style="width: 65%" class="nore-fontcolor">Deskripsi</th>
                    
                    <th align="right" style="width: 35%">Total</th> 
                </tr>
                
                <tbody> 
                    
                    <tr>
                        <td><b>{{$invoice->keterangan}}</b></td>
                        <td align="right">Rp @angka($invoice->jml_tagih)</td> 
                    </tr>
                    <tr>
                        <td colspan="2" style="background-color: white">&nbsp;</td>
                    </tr>
                    <tr>
                        <td align="right" class="nore-fontcolor">&nbsp;</td>
                        <td align="right"><span class="nore-fontcolor" style="float: left">Subtotal</span> <b>Rp @angka($invoice->jml_tagih)</b></td> 
                    </tr> 
                </tbody>
                
            </table>
            
            <table style="line-height: 1.3;">
                <tr>
                    <td style="vertical-align: top;">
                        <span style="font-size: 12px;color: #b1acaa">Catatan :</span> <br>
                        <span style="font-size: 13px"><?php echo $setting->catatan_tagihan ?></span>
                    </td>
                    <td align="right" style="color:#fabf16;vertical-align: top;font-size: 25px;font-weight: bold"><span>Rp @angka($invoice->jml_tagih) </span></td>
                    
                </tr>
                
            </table>
            
            @if (count($lampirans)>0)
            <table class="page-break">
                @else
                
                <table style="margin-right: 60px;">
                    @endif
                    <tr>
                        <td>&nbsp;</td>
                        <td align="center" style="width:20%">Semarang,</td>
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
                        <td align="center" style="width:20%;font-weight: bold">{{$invoice->penagih ? $invoice->penagih : $setting->penagih}},
                            <br> {{$invoice->pospenagih ? $invoice->pospenagih : $setting->pospenagih}} </td>
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
            
            <script>
                $(".phone").text(function(i, text) {
                    text = text.replace(/(\d{2})(\d{3})(\d{4})(\d{4})/, "$1 $2 $3 $4");
                    return text;
                });
            </script>
            
        </body>
        
        
        </html>
        