<h3><b>LAPORAN KEUANGAN CV. NORE INOVASI 01 {{ $bulan }} - {{ $lastdate }} {{ $bulan }} {{ $tahun }}</b></h3><br>

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
                        {{ strip_tags($data->keterangan) }}
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
<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b>ASET</b>
        </td>
        <td align="right">
            <b>@angka($aset)</b>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            PENDAPATAN JASA
        </td>
        <td align="right">
            @angka($p_jasa)
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            PENDAPATAN BUNGA
        </td>
        <td align="right">
            @angka($p_bunga)
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            PENDAPATAN LAIN-LAIN
        </td>
        <td align="right">
            @angka($p_lain2)
        </td>
    </tr>
    <tr class="bg-green">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b>TOTAL PENDAPATAN</b>
        </td>
        <td align="right">
            <b>@angka($pend_total)</b>
        </td>
    </tr>
</table>
<table>
    @foreach (config("custom.kat_pengeluaran") as $key => $value)
        @if ($key == 15) {
            @break
        }
        @endif
        <tr>
            <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
                {{ strtoupper($value) }}
            </td>
            <td align="right">
                @angka($pengeluaran->where('jenis_pengeluaran', $key)->sum('nominal'))
            </td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b>TOTAL PENGELUARAN</b>
        </td>
        <td align="right">
            <b>@angka($peng_total)</b>
        </td>
    </tr>
</table>
<table>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b>TOTAL PENDAPATAN</b>
        </td>
        <td align="right">
            <b>@angka($pend_total)</b>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b>TOTAL PENGELUARAN</b>
        </td>
        <td align="right">
            <b>@angka($peng_total)</b>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>
            <b>LABA/RUGI</b>
        </td>
        <td align="right">
            <b>@angka($labarugi)</b>
        </td>
    </tr>
</table>
<table>
