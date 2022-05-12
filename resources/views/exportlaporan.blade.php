<h3><b>LAPORAN KEUANGAN CV. NORE INOVASI 01 {{ $bulan }} - {{ $lastdate }} {{ $bulan }} {{ $tahun }}</b></h3>

<table>
    <thead>
        <tr>
            <th align="center" width= 100px ><b>Tanggal</b></th>
            <th align="center" width= 300px ><b>Keterangan</b></th>
            <th align="center" width= 200px ><b>Kategori</b></th>
            <th align="center" width= 150px ><b>Pendapatan (Rp)</b></th>
            <th align="center" width= 150px ><b>Pengeluaran (Rp)</b></th>
            <th align="center" width= 150px ><b>Inventaris (Rp)</b></th>
        </tr>
    </thead>

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
