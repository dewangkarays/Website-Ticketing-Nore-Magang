<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rekap Tagihan</title>
    
    
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
            font-size: 10px;
        }
        body{
            font-family:Arial, Helvetica, sans-serif;
            color: #595657;
            background-color:#ffffff;
            margin-left: 20px;
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
            /* margin-left: -40px !important; */
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
            background-color: white;
        }
        .main-table th{
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
            /* background-color: #1C2555; */
            color: #39b873
        }
        .main-table th {
            background-color: #f3f3f3;
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
                    <img src="{{url($setting->logo)}}" alt="logo" height="60px">
                    <h4 class="nore-fontcolor" style="font-weight: lighter">CV. NORE Inovasi</h4>
                    <p><?php echo $setting->alamat ?></p>
                    <p> +{{$setting->no_telp}} </p>
                </td>
                
                <td align="right" colspan="2" style="vertical-align: top">
                    <p>
                        <b class="nore-fontcolor font-weight-bold" style="font-size: 30px">Rekap Invoice</b>
                        {{-- <p class="nore-fontcolor font-weight-bold" style="font-size: 40px;"><b>Rekap Invoice</b></p> --}}
                    </p>
                    <br>
                    <p>
                        <b>Nomor: <br></b>
                        Nomor Invoice
                    </p>
                    <p>
                        <b>Tanggal: <br></b>
                        {{ date('d F Y') }}
                    </p>
                    <p>
                        <b>Jatuh Tempo: <br></b>
                        Tanggal Jatuh Tempo
                    </p>
                </td>
            </tr>
            
        </table>
        
        <hr style="margin-top: -130px;margin-bottom: -8px">

            <table style="margin-top: 20px;margin-bottom: 8px;font-size: 15px !important">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <table style="padding-right: 50px">
                            <tr>
                                <td><b>Kepada Yth.</b></td>
                            </tr>
                            
                            <tr>
                                <td style="text-transform: uppercase;">
                                    {{$invoices[0]->nama ? $invoices[0]->nama : $invoices[0]->user->nama}}
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                            </tr>

                            {{-- <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr> --}}
                            
                            <tr>
                                <td>
                                    {{$invoices[0]->username ? $invoices[0]->username : $invoices[0]->user->username}}
                                </td>
                            </tr>
                            
                            <tr>
                                <td></td>
                            </tr>
                            
                            <tr style="width: 200px">
                                <td style="font-size: 12px;">
                                    <span style="font-size: 12px !important">
                                        
                                        {{$invoices[0]->user->alamat}} 
                                    </span>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <table class="main-table" style="margin-top: 30px;margin-bottom: 5px;line-height: 0.7">
                <tr>
                    {{-- <th align="left" style="width: 30%" class="nore-fontcolor">No Invoices</th> --}}
                    <th align="left" style="width: 20%" class="nore-fontcolor">Proyek</th>
                    <th align="left" style="width: 65%" class="nore-fontcolor">Keterangan</th>
                    <th align="right" style="width: auto" class="nore-fontcolor">Total</th> 
                </tr>
                
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        {{-- <td><b>{{$invoice->invoice}}</b></td> --}}
                        <td>
                            @if ($invoice->nama_proyek)
                            {{$invoice->nama_proyek}} 
                            @elseif ($invoice->user->website)
                            {{$invoice->user->website}}
                            @else
                            -
                            @endif
                        </td>
                        <td>{{$invoice->keterangan}}</td>
                        <td align="right">Rp @angka($invoice->nominal)</td>
                    </tr>
                    {{-- <tr>
                        <td colspan="2" style="background-color: white">&nbsp;</td>
                    </tr> --}}
                    @endforeach
                    <tr>
                        <td></td>
                        <td align="right" class="nore-fontcolor"><span class="nore-fontcolor" style="float: right">Subtotal</span>&nbsp;</td>
                        <td align="right"><b>Rp @angka($invoice->sum('nominal'))</b></td>
                    </tr> 
                </tbody>
            </table>
            
            <table style="line-height: 1.3;">
                <tr>
                    <td style="vertical-align: top;">
                        <span style="font-size: 12px;color: #b1acaa">Catatan :</span> <br>
                        <span style="font-size: 13px">
                            <table>
                                <tbody>
                                    <tr style="height: 21px;">
                                        <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom; color: rgb(67, 67, 67);">- Pembayaran dapat dilakukan ke nomor rekening</td>
                                    </tr>
                                    <tr style="height: 22px;">
                                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; font-weight: bold; color: rgb(67, 67, 67); white-space: nowrap; overflow: hidden; position: relative; width: 319px; left: 3px; float: left;">
                                            BCA a/n Noer Tjahja Moekthi Prajitno 8985181108
                                        </td>
                                    </tr>
                                    <tr style="height: 21px;">
                                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; color: rgb(67, 67, 67); white-space: nowrap; overflow: hidden; position: relative; width: 218px; left: 3px; float: left;">
                                            - Bukti pengerjaan terlampir
                                        </td>
                                    </tr>
                                    <tr style="height: 21px;">
                                        <td style="border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; color: rgb(67, 67, 67); white-space: nowrap; overflow: hidden; position: relative; width: 319px; left: 3px; float: left;">
                                            - Nomor NPWP 95.225.490.2-503.000
                                        </td>
                                    </tr>
                                    <tr style="height: 21px;">
                                        <td style="font-size: 13.3333px; border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; color: rgb(67, 67, 67); white-space: nowrap; overflow: hidden; position: relative; width: 218px; left: 3px; float: left;">
                                            a/n CV Nore Inovasi
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <google-sheets-html-origin>
                                <table xmlns="http://www.w3.org/1999/xhtml" cellspacing="0" cellpadding="0" dir="ltr" style="table-layout: fixed; font-size: 10pt; font-family: Arial; width: 0px;">
                                    <colgroup>
                                        <col width="81"><col width="141"><col width="100"><col width="100"> 
                                    </colgroup>
                                    <tbody>
                                        <tr style="height: 21px;">
                                            <td rowspan="1" colspan="4" data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;- Pembayaran dapat dilakukan ke nomor rekening &quot;}" style="overflow: hidden; padding: 2px 3px; vertical-align: bottom; color: rgb(67, 67, 67);">- Pembayaran dapat dilakukan ke nomor rekening</td>
                                        </tr>
                                        <tr style="height: 22px;">
                                            <td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;  BCA a/n Noer Tjahja Moekthi Prajitno 8985181108&quot;}" style="border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; font-weight: bold; color: rgb(67, 67, 67);">
                                                <div style="white-space: nowrap; overflow: hidden; position: relative; width: 319px; left: 3px;">
                                                    <div style="float: left;">BCA a/n Noer Tjahja Moekthi Prajitno 8985181108</div>
                                                </div>
                                            </td>
                                            <td style="border-right: 1px solid transparent; overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                            <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                            <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                        </tr>
                                        <tr style="height: 21px;">
                                            <td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;- Bukti pengerjaan terlampir&quot;}" style="border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; color: rgb(67, 67, 67);">
                                                <div style="white-space: nowrap; overflow: hidden; position: relative; width: 218px; left: 3px;">
                                                    <div style="float: left;">- Bukti pengerjaan terlampir</div>
                                                </div>
                                            </td>
                                            <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                            <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                            <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                        </tr>
                                        <tr style="height: 21px;">
                                            <td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;- Nomor NPWP 95.225.490.2-503.000&quot;}" style="border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; color: rgb(67, 67, 67);">
                                                <div style="white-space: nowrap; overflow: hidden; position: relative; width: 319px; left: 3px;">
                                                    <div style="float: left;">- Nomor NPWP 95.225.490.2-503.000</div>
                                                </div>
                                            </td>
                                            <td style="border-right: 1px solid transparent; overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                            <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                            <td style="overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                        </tr>
                                        <tr style="height: 21px;">
                                            <td data-sheets-value="{&quot;1&quot;:2,&quot;2&quot;:&quot;  a/n CV Nore Inovasi&quot;}" style="font-size: 13.3333px; border-right: 1px solid transparent; overflow: visible; padding: 2px 0px; vertical-align: bottom; color: rgb(67, 67, 67);">
                                                <div style="white-space: nowrap; overflow: hidden; position: relative; width: 218px; left: 3px;">
                                                    <div style="float: left;">a/n CV Nore Inovasi</div>
                                                </div>
                                            </td>
                                            <td style="color: rgb(0, 0, 0); font-size: 13.3333px; overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                            <td style="color: rgb(0, 0, 0); font-size: 13.3333px; overflow: hidden; padding: 2px 3px; vertical-align: bottom;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </google-sheets-html-origin> --}}
                        </span>
                    </td>
                    <td align="right" style="color:#fabf16;vertical-align: top;font-size: 25px;font-weight: bold"><span>Rp @angka($invoices[0]->sum('nominal')) </span></td>
                    
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
        