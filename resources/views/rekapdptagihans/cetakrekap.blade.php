@extends('printlayout')
@section('keterangan-invoice')
    <p>
        <b>Nomor: <br></b>
        {{ $rekapdp->invoice }}
    </p>
    <p>
        <b>Tanggal: <br></b>
        {{ date('d/m/Y') }}
    </p>
    <p>
        <b>Jatuh Tempo: <br></b>
        {{ date('d/m/Y', strtotime($rekapdp->jatuh_tempo)) }}
    </p>
@endsection
@section('tertagih')
    <tr>
        <td><b>Kepada Yth.</b></td>
    </tr>
    <tr>
        <td style="text-transform: capitalize;">
            {{$rekapdp->nama_tertagih}}
        </td>
    </tr>
    <tr>
        <td style="width: 40%;">
            {{$rekapdp->alamat}}
        </td>
        <td style="width:auto;">
        </td>
    </tr>
@endsection

@section('deskripsi-proyek')
    <tbody>
        @foreach ($invoices as $invoice)
        <tr>
            <td>
                @if ($invoice->proyek->nama_proyek)
                {{$invoice->proyek->nama_proyek}}
                @elseif ($invoice->proyek->website)
                {{$invoice->proyek->website}}
                @else
                -
                @endif
            </td>
            <td>
                {{-- Layanan {{ config('custom.jenis_proyek.' .@$invoice->proyek->jenis_proyek) }}
                {{ config('custom.kelas_layanan.' .@$invoice->proyek->kelas_layanan) }}
                {{ config('custom.jenis_layanan.' .@$invoice->proyek->jenis_layanan) }} --}}
                {{-- <br/> --}}
                {{-- {{ $invoice->proyek->website ? '('.$invoice->proyek->website.')': ''}} --}}
                @if ($invoice->keterangan != null)
                {!! $invoice->keterangan !!}
                @else
                <p></p>
                @endif
            {{-- </td> --}}
            {{-- <td><b>{{$invoice->invoice}}</b></td> --}}
            {{-- <td> --}}
                @if ($invoice->keterangan_tambahan != null)
                {!! $invoice->keterangan_tambahan !!}
                @else
                <p></p>
                @endif
            </td>
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
@endsection

@section('nominal-bayar')
    <table style="line-height: 1.5; padding: 5px 10px;">
        <tr>
            <th style="width: 45%; height: 30px"></th>
            <th align="left" style="width: 40%">TOTAL</th>
            <th align="right" style="width: auto">@angka($invoices->sum('nominal'))</th>
        </tr>
        @if ($invoices->sum('diskon') > 0)
        <tr>
            <td></td>
            <td align="left">Potongan Harga</td>
            <td align="right">@angka($invoices->sum('diskon'))</td>
        </tr>
        @endif
        <tr>
            <td></td>
            <td align="left">Uang Muka</td>
            <td align="right">@angka($rekapdp->total)</td>
        </tr>
        @if ($rekapdp->jml_terbayar > 0 && $rekapdp->jml_terbayar < $rekapdp->total)
        <tr>
            <td></td>
            <td align="left">Uang Muka Sudah Terbayar</td>
            <td align="right">@angka($rekapdp->jml_terbayar)</td>
        </tr>  
        @endif
        <tr>
            <td></td>
            <td align="left">PPN 11%</td>
            <td align="right">0</td>
        </tr>
        <tr style="line-height: 2;">
            <td></td>
            <td align="left">
                <b class="nore-fontcolor" style="font-size: 14px">TOTAL YANG HARUS DIBAYAR</b>
            </td>
            <td align="right">
                <b class="nore-fontcolor" style="font-size: 14px">@angka($rekapdp->total - $rekapdp->jml_terbayar)</b>
            </td>
        </tr>
    </table>
    @php
        $jenis_rekap = "dp_tagihan";
    @endphp
@endsection

@section('lampiran')
@if (count($lampirans) != 0)
<table style="margin-right: 60px; margin-top: 20px;">
    @php ($jenis_terakhir = '')
    @php ($i = 1)
    <h5>Lampiran {{$i}} - NPWP CV.NORE INOVASI</h5>
    <div align="center">
        @if ($setting->npwp)
            <img src="{{ url($setting->npwp) }}" alt="" style="max-width:60%;object-fit: cover;">
        @else
            <h2><em>Lampiran NPWP Belum di upload!</em></h2>
        @endif
    </div>
    <div class="page-break"></div>  
    @php ($i++)
    @foreach ($lampirans as $rekapdpindex => $lampiran)
    @if (!$loop->first)
        @if ($lampiran->jenis_lampiran != $jenis_terakhir)
        <div class="page-break"></div>   
        @endif
    @endif
    
    @if ($lampiran->jenis_lampiran != $jenis_terakhir)
        @if ($lampiran->jenis_lampiran == 1)
        <h5>Lampiran {{$i}} - {{ $lampiran->judul }} {{ $lampiran->keterangan}}</h5>
        @else
        <h5>Lampiran {{$i}} - {{ config('custom.jenis_lampiran.'.$lampiran->jenis_lampiran) }} {{ $lampiran->keterangan}}</h5>
        @endif
    @endif
    @if($lampiran->jenis_lampiran != 2)
        <div align="center">
            <img src="{{url($lampiran->gambar)}}" style="max-width:110%;max-height:300px;object-fit: cover;margin-bottom: 16px;page-break-inside:avoid; ">
        </div>
        {{-- @if (!$loop->last) --}}
        @if (($rekapdpindex +1) % 3 == 0)
        <div class="page-break"></div>   
        @endif
        {{-- @endif --}}
        @else
        <div align="center">
            <img src="{{url($lampiran->gambar)}}" style="max-width:90%;max-height:300px;object-fit: cover;margin-bottom: 16px;">
        </div>
    @endif
    @if ($lampiran->jenis_lampiran != $jenis_terakhir)
    @php ($i++)
    @endif

    @php ($jenis_terakhir = $lampiran->jenis_lampiran)
    @endforeach

    <div class="page-break"></div>   
    <h5>Lampiran {{$i}} - Keterangan UMKM</h5>
    <div align="center">
        @if ($setting->umkm)
            <img src="{{ url($setting->umkm) }}" alt="" style="max-width:110%;object-fit: cover;">
        @else
            <h2><em>Lampiran UMKM Belum di upload!</em></h2>
        @endif
    </div>
</table>
@else
<table style="margin-right: 60px; margin-top: 20px;">
{{-- @php ($i = 1) --}}
    <div class="page-break"></div>  
    <h5>Lampiran 1 - NPWP CV.NORE INOVASI</h5>
    <div align="center">
        @if ($setting->npwp)
            <img src="{{ url($setting->npwp) }}" alt="" style="max-width:60%;object-fit: cover;">
        @else
            <h2><em>Lampiran NPWP Belum di upload!</em></h2>
        @endif
    </div>
    <div class="page-break"></div>  
{{-- @php ($i++) --}}

    <h5>Lampiran 2 - Keterangan UMKM</h5>
    <div align="center">
        @if ($setting->umkm)
            <img src="{{ url($setting->umkm) }}" alt="" style="max-width:110%;object-fit: cover;">
        @else
            <h2><em>Lampiran UMKM Belum di upload!</em></h2>
        @endif
    </div>
</table>
@endif
@endsection