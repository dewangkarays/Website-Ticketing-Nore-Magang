@extends('printlayout')
@section('sub-0')
    <td align="right" colspan="2" style="vertical-align: top;">
        <p style="margin-bottom: 30px">
            DOKUMEN PENTING<br>
            <b class="nore-fontcolor font-weight-bold" style="font-size: 29px">Invoice</b>
            {{-- <p class="nore-fontcolor font-weight-bold" style="font-size: 40px;"><b>Rekap Invoice</b></p> --}}
        </p>
        {{-- <br> --}}
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
    </td>
@endsection
@section('sub-1')
    {{-- Sub 1 --}}
    <tr>
        <td><b>Kepada Yth.</b></td>
    </tr>

    <tr>
        <td style="text-transform: uppercase;">
            {{$rekapdp->nama_tertagih}}
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
            {{$rekapdp->alamat}}
        </td>
    </tr>
    <tr>
        <td class="nore-fontcolor">
            <b>Proyek</b>
        </td>
    </tr>
    <tr>
        <td>
            @foreach ($invoices as $invoice)
                @if ($invoice->nama_proyek)
                    {{$invoice->nama_proyek}}
                @elseif ($invoice->proyek->website)
                    {{$invoice->proyek->website}}
                @else
                    -
                @endif
            @endforeach
        </td>
    </tr>
@endsection

@section('sub-2')
    <tbody>
        @foreach ($invoices as $invoice)
        <tr>
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

@section('sub-3')
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
