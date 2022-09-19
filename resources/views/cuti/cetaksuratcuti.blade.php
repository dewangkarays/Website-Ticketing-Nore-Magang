<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @page {
            margin: 2cm 2.54cm 2cm 2.54cm;
        }
        *{
            box-sizing: border-box;
        }
        table{
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        body{
            font-family:Arial, Helvetica, sans-serif;
            color: #595657;
            font: 9pt;
            background-color:white;
        }
        footer {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            overflow: hidden;
            text-align: center;
            font-size: 8pt;
        }
        .kop-surat-table {
            margin-bottom: 5px;
        }
        .kop-surat__deskripsi {
            font-size: 7pt;
            padding: 0;
            margin: 0;
            border-collapse: collapse;
            width: auto !important;
        }
        .kop-surat__deskripsi tr td {
            margin: 0px;
        }
        .kop-surat__deskripsi p {
            margin: 0;
            padding: 0;
        }
        .kop-surat__dokumen {
            vertical-align: top;
            font-size: 8pt;
        }
        .main__header {
            text-align: center;
        }
        .main__header h5 {
            font-size: 11pt;
            margin-bottom: 0;
        }
        .main__header p {
            font-size: 10pt;
            margin-top: 0;
        }
        .main-table {
            margin-top: 30px;
        }
        .main-table td {
            vertical-align: top;
        }
        .main-table td p {
            padding: 1px;
            margin: 0;
        }
        .detail-table {
            margin-top: 20px;
        }
        .permohonan {
            text-align: justify;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .main__tandatangan {
            margin-top: 40px;
            text-align: center;
        }
        .main__notes {
            margin-top: 50px;
        }
        .main__notes .notes {
            font-size: 7pt;
            text-align: justify;
        }
    </style>
    <title>Surat Permohonan Cuti</title>
</head>
<body>
    <header class="kop-surat">
        <table class="kop-surat-table">
            <tr>
                <td style="width: 22.5%">
                    <table>
                        <tr>
                            <td style="vertical-align: top; margin-bottom: 7.5px">
                                <img src="{{url($setting->logo)}}" alt="Nore Inovasi" height="64px">
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="kop-surat__deskripsi">
                        <tr>
                            <td style="vertical-align:center">
                                <img src="{{asset('/global_assets/images/icons/instagram.png')}}" height="10pt" alt="">
                            </td>
                            <td>{{$setting->instagram}}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">
                                <img src="{{asset('/global_assets/images/icons/building.png')}}" height="10pt" alt="">
                            </td>
                            <td>{!! $setting->alamat !!}</td>
                        </tr>
                        <tr>
                            <td style="vertical-align:center">
                                <img src="{{asset('/global_assets/images/icons/phone.png')}}" height="10pt" alt="">
                            </td>
                            <td style="vertical-align:center">
                                +{{$setting->no_telp}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="{{asset('/global_assets/images/icons/mail.png')}}" height="10pt" alt="">
                            </td>
                            <td>
                                {{$setting->email}}
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="right" class="kop-surat__dokumen">
                    DOKUMEN RAHASIA
                </td>
            </tr>
        </table>
        <hr />  
    </header>
    <main>
        <div class="main__header">
            <h5>
                <u>SURAT PERMOHONAN CUTI</u>
            </h5>
            <p>
                Nomor: 
            </p>
        </div>
        <table class="main-table">
            <tr>
                <td align="left" class="main__receiver">
                    <p>Kepada Yth.</p>
                    <p>Pimpinan Nore Inovasi</p>
                    <p>Di Semarang</p>
                </td>
                <td align="right" class="main__date">
                    Semarang, {{date('d F Y')}}
                </td>
            </tr>
        </table>
        <table class="detail-table">
            <tr>
                <td>Yang bertanda tangan di bawah ini:</td>
            </tr>
            <tr>
                <td>
                    <table class="main__detail">
                        <tr>
                            <td>
                                Nama
                            </td>
                            <td>
                                : {{$cuti->karyawan->nama}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Divisi
                            </td>
                            <td>
                                : {{$cuti->karyawan->divisi}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Jabatan
                            </td>
                            <td>
                                : {{$cuti->karyawan->jabatan}}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                NIP
                            </td>
                            <td>
                                : {{$cuti->karyawan->nip}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="permohonan">
            <p>
                Dengan ini saya mengajukan permohonan izin cuti selama 3 (tiga) hari kerja pada tanggal {{date('d F Y', strtotime($cuti->tanggal_mulai))}} - {{date('d F Y', strtotime($cuti->tanggal_akhir))}} dikarenakan acara keluarga. Adapun tentang tugas dan tanggung jawab pekerjaan selama cuti akan saya kerjakan sesudah saya kembali masuk kerja. Demikian surat izin ini dibuat untuk di pertimbangkan sebagaimana mestinya.
            </p>
        </div>
        <table class="main__tandatangan">
            <tr>
                <td width="30%">
                    <p>Mengetahui,</p>
                    <br><br><br>
                    <p><b>{{$cuti->verifikator2->nama}}</b></p>
                    <p>{{$cuti->verifikator2->jabatan}}</p>
                </td>
                <td width="40%">
                </td>
                <td width="30%">
                    <p>Hormat saya,</p>
                    <br><br><br>
                    <p><b>{{$cuti->karyawan->nama}}</b></p>
                    <p>{{$cuti->karyawan->jabatan}}</p>
                </td>
            </tr>
            <tr>
                <td width=30%></td>
                <td width=40%%>
                    <p>Menyetujui,</p>
                    <br><br><br>
                    <p><b>{{$cuti->verifikator1->nama}}</b></p>
                    <p>{{$cuti->verifikator1->jabatan}}</p>
                </td>
                <td width=30%></td>
            </tr>
        </table>
        <div class="main__notes">
            Catatan:
            <div class="notes">
                <ul>
                    @if ($cuti->cataten_ver_2)
                    <li>{{$cuti->catatan_ver_2}}</li>
                    @endif
                    @if ($cuti->catatan_ver_1)
                    <li>{{$cuti->catatan_ver_1}}</li>
                    @endif
                </ul>
            </div>
        </div>
    </main>
    <footer>
        <hr />
        <p><b>CV. NORE INOVASI</b> | PERMOHONAN IZIN CUTI | TAHUN {{date('Y')}}</p>
    </footer>
</body>
</html>