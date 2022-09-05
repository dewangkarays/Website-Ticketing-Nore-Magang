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
        <td style="text-transform: uppercase;">
            {{$rekapdp->nama_tertagih}}
        </td>
    </tr>
    <tr style="width: 200px;">
        <td>
            {{$rekapdp->alamat}}
        </td>
    </tr>
@endsection

@section('deskripsi-proyek')
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
@endsection

@section('nominal-bayar')
    <table style="line-height: 1.5; padding: 5px 10px;">
        <tr>
            <th style="width: 45%; height: 30px"></th>
            <th align="left" style="width: 40%">TOTAL</th>
            <th align="right" style="width: auto">@angka($invoices->sum('nominal'))</th>
        </tr>
        <tr>
            <td></td>
            <td align="left">Potongan Harga</td>
            <td align="right">@angka($invoices->sum('diskon'))</td>
        </tr>
        <tr>
            <td></td>
            <td align="left">Uang Muka</td>
            <td align="right">@angka($invoices->sum('uang_muka'))</td>
        </tr>
        <tr>
            <td></td>
            <td align="left">PPN 11%</td>
            <td align="right">0</td>
        </tr>
        <tr style="line-height: 2;">
            <td></td>
            <td align="left">
                <b class="nore-fontcolor" style="font-size: 12px">TOTAL YANG HARUS DIBAYAR</b>
            </td>
            <td align="right">
                <b class="nore-fontcolor" style="font-size: 12px">@angka($rekapdp->total)</b>
            </td>
        </tr>
    </table>
@endsection
