<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Laporan Keuangan</title>

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

        .head-block {
            /* margin-left: -40px !important; */
            margin-right: -20px !important;
        }

        .main-table{
            width: 100%;
            table-layout: fixed;
        }
        .main-table td, .main-table th{
            border: 1px solid black;
            padding: 5px 3px;
        }
        .main-table th{
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
            /* background-color: #1C2555;
            color: #595657 */
        }
        .page-break {
            page-break-after: always;
        }

        .main-color th{
            background-color: #34A853;
            color: white;
            font-size: 9px;
        }
        .main-font td{
            background-color: white;
            font-size: 8px;
        }

        .total-table{
            width: 100%;
            table-layout: fixed;
            margin-bottom: 10px;
        }
        .total-table td{
            border: 1px solid black;
            padding: 2px 5px;
            font-size: 8px;
        }

        .bg-yellow {
            background-color: #FFF2CC;
        }
        .bg-green {
            background-color: #D9EAD3;
        }
        .bg-pink {
            background-color: #F4CCCC;
        }
        .bg-blue {
            background-color: #C9DAF8;
        }

    </style>


</head>

<body>

    <main>
        <table>
            <tr>
                <td align="center" style="vertical-align: top;">
                    <p style="margin-bottom: 15px; font-size: 12px;">
                        <b>LAPORAN KEUANGAN CV. NORE INOVASI<br>
                        01 {{ $bulan }} - {{ $lastdate }} {{ $bulan }} {{ $tahun }}</b>
                    </p>
                    <table class="main-table main-color">
                        <tr>
                            <th align="center" style="border-bottom: 0px" >LAPORAN PENDAPATAN DAN PENGELUARAN BULAN {{ $bulan }} {{ $tahun }} CV. NORE INOVASI</th>
                        </tr>
                    </table>
                    <table class="main-table main-color main-font">
                        <tr align="center">
                            <th style="width: 11%;" >Tanggal</th>
                            <th style="width: 28%;" >Keterangan</th>
                            <th style="width: 19%" >Kategori</th>
                            <th style="width: auto" >Pendapatan (Rp)</th>
                            <th style="width: auto" >Pengeluaran (Rp)</th>
                            <th style="width: auto" >Inventaris (Rp)</th>
                        </tr>

                        <tbody>
                            @if(!$allItems->isEmpty())
                                @foreach ($allItems as $data)
                                    <tr>
                                        <td align="center">
                                            {{ date('d/m/Y', strtotime($data->tanggal)) }}
                                        </td>
                                        <td>
                                            {!! $data->keterangan !!}
                                        </td>
                                        <td>
                                            {{ $data->jenis_pengeluaran ? config('custom.kat_pengeluaran.'.$data->jenis_pengeluaran) : 'Pendapatan Jasa' }}
                                        </td>
                                        <td align="right">
                                            @angka($data->status==1 ? $data->nominal : '0')
                                        </td>
                                        <td align="right">
                                            @angka($data->jenis_pengeluaran ? $data->nominal : '0')
                                        </td>
                                        <td align="right">
                                            0
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
                <td style="width: 1.5%;"></td>
                <td align="center" style="vertical-align: bottom; width: 30%;">
                    <table class="total-table bg-yellow" style="margin-top: 113px;">
                        <tr>
                            <td>
                                ASET
                            </td>
                            <td align="right" style="width : 40%">
                                @angka($pengeluaran->where('jenis_pengeluaran', 14)->sum('nominal'))
                            </td>
                        </tr>
                    </table>
                    <table class="total-table">
                        <tr>
                            <td>
                                PENDAPATAN JASA
                            </td>
                            <td align="right" style="width : 40%">
                                @angka($p_jasa)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                PENDAPATAN BUNGA
                            </td>
                            <td align="right" style="width : 40%">
                                @angka($p_bunga)
                            </td>
                        </tr>
                        <tr>
                            <td>
                                PENDAPATAN LAIN-LAIN
                            </td>
                            <td align="right" style="width : 40%">
                                @angka($p_lain2)
                            </td>
                        </tr>
                        <tr class="bg-green">
                            <td>
                                <b>TOTAL PENDAPATAN</b>
                            </td>
                            <td align="right" style="width : 40%">
                                <b>@angka($pend_total)</b>
                            </td>
                        </tr>
                    </table>
                    <table class="total-table" style="margin-bottom: 10px;">
                        @foreach (config("custom.kat_pengeluaran") as $key => $value)
                            <tr>
                                <td>
                                    {{ strtoupper($value) }}
                                </td>
                                <td align="right" style="width : 40%">
                                    @angka($pengeluaran->where('jenis_pengeluaran', $key)->sum('nominal'))
                                </td>
                            </tr>
						@endforeach
                        <tr class="bg-pink">
                            <td>
                                <b>TOTAL PENGELUARAN</b>
                            </td>
                            <td align="right" style="width : 40%">
                                <b>@angka($peng_total)</b>
                            </td>
                        </tr>
                    </table>
                    <table class="total-table" style="margin-bottom: 10px;">
                        <tr class="bg-green">
                            <td>
                                <b>TOTAL PENDAPATAN</b>
                            </td>
                            <td align="right" style="width : 40%">
                                <b>@angka($pend_total)</b>
                            </td>
                        </tr>
                        <tr class="bg-pink">
                            <td>
                                <b>TOTAL PENGELUARAN</b>
                            </td>
                            <td align="right" style="width : 40%">
                                <b>@angka($peng_total)</b>
                            </td>
                        </tr>
                        <tr class="bg-blue">
                            <td>
                                <b>LABA/RUGI</b>
                            </td>
                            <td align="right" style="width : 40%">
                                <b>@angka($labarugi)</b>
                            </td>
                        </tr>
                    </table>
                    <p align="center" style="font-size: 12px; margin-bottom: 100px; margin-top: 25px">Semarang, {{ date('d') }} {{ config('custom.bulan.' .date('n')) }} {{ date('Y') }}</p>
                    <p align="center" style="font-size: 12px;">
                        <b>{{$setting->penagih}}</b><br>
                        {{$setting->pospenagih}}
                    </p>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>
