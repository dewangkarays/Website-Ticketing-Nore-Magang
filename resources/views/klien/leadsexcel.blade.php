<table>
    <thead>
        <tr>
            <th colspan="4"></th>
            <th colspan="3" style="text-align: center;"><strong>Data Leads</strong></th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th style="text-align: center;">No</th>
            <th style="text-align: center;">Nama Calon Klien</th>
            <th style="text-align: center;">Nama Perusahaan</th>
            <th style="text-align: center;">Jenis Perusahaan</th>
            <th style="text-align: center;">Potensi</th>
            <th style="text-align: center;">Status</th>
            <th style="text-align: center;">Source</th>
            <th style="text-align: center;">Alamat</th>
            <th style="text-align: center;">Marketing</th>
            <th style="text-align: center;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @php ($i = 1)
        @foreach ($kliens as $klien)
        <tr>
            {{-- <td> {{$payment->id}} </td> --}}
            <td> {{$i}} </td>
            <td> {{@$klien->nama_calonklien}} </td>
            <td> {{@$klien->nama_perusahaan}} </td>
            <td> {{@$klien->jenis_perusahaan}} </td>
            <td> {{config('custom.jenis_proyek.'.$klien->potensi)}} </td>
            <td> {{config('custom.status_klien.'.$klien->status)}} </td>
            <td> {{config('custom.source.'.$klien->source)}} </td>
            <td> {{@$klien->alamat}} </td>
            <td> {{@$klien->marketing->nama}} </td>
            <td> {{strip_tags(@$klien->keterangan_lain)}} </td>
        </tr>
        @php ($i++)
        @endforeach
    </tbody>
</table>
