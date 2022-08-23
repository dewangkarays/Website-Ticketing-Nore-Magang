<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rekap Tagihan</title>

    <style type="text/css">

        @page {
            margin: 2.54cm 2.55cm 2.54cm 2.54cm;
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
            /* margin-left: 20px;
            margin-right: 20px; */
        }

        ul {
            width: 75%;
            list-style: none;
            word-break: break-all;
        }
        ul li::before {
            content: '- ';
            margin-left: -20px;
            margin-right: 10px;
        }
        li.note1::before {
            content: '(*) ';
            font-style: normal;
        }
        li.note2::before {
            content: '(**) ';
            font-style: normal;
        }
        li.note3:before {
            content: '(***) ';
            font-style: normal;
        }
        li.note4::before {
            content: '(****) ';
            font-style: normal;
        }
        li.note1,li.note2,li.note3,li.note4 {
            font-style: italic;
            font-weight: normal;
        }
        li.pay::before {
            content: '- ';
        }
        li.pay1::before {
            list-style-type: none;
        }
        li.pay,li.pay1 {
            font-style: italic;
            font-weight: normal;
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
            border: 1px solid #f3f3f3;
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
        {{--  <table class="head-block" style="margin-bottom: 10px;">
            <tr>
                <td class="nore-bgcolor" style="height: 23px">&nbsp;</td>
            </tr>
        </table>--}}
        <table>
            <tr>
                <td align="left" rowspan="5" style="vertical-align: top">
                    <img src="{{url($setting->logo)}}" alt="logo" height="68px">
                    <figcaption class="nore-fontcolor" style="font-weight: lighter; letter-spacing: 1px;">&nbsp;&nbsp;&nbsp;&nbsp;CV. NORE INOVASI</figcaption>
                    <p style="margin-top: 17px">@nore.web.id</p>
                    {!! $setting->alamat !!}
                    <p> +{{$setting->no_telp}} </p>
                </td>

                <td align="right" colspan="2" style="vertical-align: top;">
                    <p style="margin-bottom: 30px">
                        DOKUMEN PENTING<br>
                        <b class="nore-fontcolor font-weight-bold" style="font-size: 29px">Invoice</b>
                        {{-- <p class="nore-fontcolor font-weight-bold" style="font-size: 40px;"><b>Rekap Invoice</b></p> --}}
                    </p>
                    {{-- <br> --}}
                    <p>
                        <b>Nomor: <br></b>
                        {{ $rekap->invoice }}
                    </p>
                    <p>
                        <b>Tanggal: <br></b>
                        {{ date('d/m/Y') }}
                    </p>
                    <p>
                        <b>Jatuh Tempo: <br></b>
                        {{ date('d/m/Y', strtotime($rekap->jatuh_tempo)) }}
                    </p>
                </td>
            </tr>

        </table>

        <hr style="margin-top: -130px;margin-bottom: -8px">

            <table style="margin-top: 20px;margin-bottom: 8px;font-size: 15px !important">
                <tr>
                    <td style="width: 50%; vertical-align: top">
                        <table style="padding-right: 50px; line-height: 1.75;">
                            {{-- @foreach ($invoices as $invoice) --}}
                            <tr>
                                <td><b>Kepada Yth.</b></td>
                            </tr>

                            <tr>
                                <td style="text-transform: uppercase;">
                                    {{$rekap->nama_tertagih}}
                                </td>
                            </tr>

                            {{-- <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr> --}}

                            {{-- <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr> --}}

                            <tr style="width: 200px;">
                                <td>
                                    {{$rekap->alamat}}
                                </td>
                            </tr>
                            {{-- @endforeach --}}
                        </table>
                    </td>
                </tr>
            </table>

            <table class="main-table" style="margin-top: 15px; line-height: 1">
                <tr>
                    <th align="left" style="width: 15%; height: 20px" class="nore-fontcolor">PROYEK</th>
                    <th align="left" style="width: 20%; height: 20px" class="nore-fontcolor">DESKRIPSI</th>
                    <th align="left" style="width: 50%" class="nore-fontcolor">KETERANGAN</th>
                    <th align="right" style="width: auto" class="nore-fontcolor">JUMLAH (Rp)</th>
                </tr>

                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td>
                            @if ($invoice->nama_proyek)
                            {{$invoice->nama_proyek}}
                            @elseif ($invoice->proyek->website)
                            {{$invoice->proyek->website}}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            Layanan {{ config('custom.jenis_proyek.' .@$invoice->proyek->jenis_proyek) }}
                            {{ config('custom.kelas_layanan.' .@$invoice->proyek->kelas_layanan) }}
                            {{ config('custom.jenis_layanan.' .@$invoice->proyek->jenis_layanan) }}
                            <br/> {{ $invoice->proyek->website ? '('.$invoice->proyek->website.')': ''}}
                        </td>
                        {{-- <td><b>{{$invoice->invoice}}</b></td> --}}
                        <td>{!! $invoice->keterangan !!}</td>
                        <td align="right">@angka($invoice->nominal)</td>
                    </tr>
                    {{-- <tr>
                        <td colspan="2" style="background-color: white">&nbsp;</td>
                    </tr> --}}
                    @endforeach
                    {{-- @php
                        dd($invoice);
                    @endphp --}}
                </tbody>
            </table>

            <hr style="margin-bottom: -5px">

            <table style="line-height: 1.5; padding: 5px 10px;">
                <tr>
                    <th style="width: 45%; height: 30px"></th>
                    <th align="left" style="width: 40%">TOTAL</th>
                    <th align="right" style="width: auto">@angka($invoices->sum('nominal'))</th>
                </tr>
                <tr>
                    <td></td>
                    <td align="left">Pembayaran Uang Muka</td>
                    <td align="right">@angka($invoices->sum('uang_muka'))</td>
                </tr>
                <tr>
                    <td></td>
                    <td align="left">Sisa Tagihan</td>
                    <td align="right">@angka($invoices->sum('jml_tagih'))</td>
                </tr>
                <tr>
                    <td></td>
                    <td align="left">PPN 10%</td>
                    <td align="right">0</td>
                </tr>
                <tr style="line-height: 2;">
                    <td></td>
                    <td align="left">
                        <b class="nore-fontcolor" style="font-size: 12px">TOTAL YANG HARUS DIBAYAR</b>
                    </td>
                    <td align="right">
                        <b class="nore-fontcolor" style="font-size: 12px">@angka($rekap->total)</b>
                    </td>
                </tr>
            </table>

            <table style="margin-top: 20px; line-height: 1.3;">
                <tr>
                    <th align="left" style="font-weight: bold; width:50%">Catatan:</th>
                    <th style="width:18%"></th>
                    <th align="center" style="font-size: 12px; font-weight: normal; width:25%; margin-left:6px">Semarang, {{ date('d') }} {{ config('custom.bulan.' .date('n')) }} {{ date('Y') }}</th>
                </tr>
                <tr>
                    <td align="left" rowspan="5" style="vertical-align: top;">
                        {{-- <span style="font-weight:bold">Catatan:</span> --}}
                        <li class="note1" style="list-style-type: none;">Jika pembayaran dilakukan melalui transfer bank, <b>mohon untuk menyertakan nomor invoice sebagai keterangan</b> kemudian kirimkan bukti pembayaran via Whatsapp/E-Mail agar pelunasan dapat segera kami catat.</li>
                        <li class="note2" style="list-style-type: none;">Biaya transfer menjadi tanggung jawab pelanggan/pengirim dana.</li>
                        <li class="note3" style="list-style-type: none;">Untuk layanan berlangganan perlu diketahui bahwa aset-code adalah hak milik CV. Nore Inovasi dan hanya dapat digunakan selama berlangganan.</li>
                        <li class="note4" style="list-style-type: none;">Pastikan data pembayaran sudah benar, <b> dana yang telah dibayarkan tidak dapat ditarik kembali</b>.</li> <br>

                        <span style="font-weight:bold">Pembayaran dapat dilakukan melalui:</span>
                        <li class="pay" style="list-style-type: none;">NORE INOVASI CV</li>
                        <li class="pay1" style="list-style-type: none; margin-left:6px;">BCA KCP Puri Anjasmoro</li>
                        <li class="pay1" style="list-style-type: none; margin-left:6px;"><b>Acc. Number 898 589 9955</b></li>
                        <li class="pay" style="list-style-type: none;">Nomor NPWP 95.225.490.2-503.000 a/n CV NORE INOVASI</li>
                        {{-- {!! $setting->catatan_tagihan !!} --}}
                    </td>
                    <td></td>
                    <td align="center" style="vertical-align: top;">
                        {{-- <p align="center" style="font-size: 12px">Semarang, {{ date('d F Y') }}</p> --}}
                        <br style="line-height: 11;">
                        <p align="center" style="font-size: 12px"><b>
                            {{$invoice->penagih ? $invoice->penagih : $setting->penagih}}</b> <br> {{$invoice->pospenagih ? $invoice->pospenagih : $setting->pospenagih}}
                        </p>
                        <i align="center" style="color: #918d8b;">"Terima kasih atas kerja sama Anda"</i>
                    </td>
                </tr>

            </table>

            @if (count($lampirans)>0)
            <table class="page-break">
                @else

                <table style="margin-right: 60px; margin-top: 20px;">
                    @endif
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
