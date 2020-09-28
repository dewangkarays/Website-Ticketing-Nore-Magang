<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pengeluaran</th>
            <th>Jenis Pengeluaran</th>
            <th>Nominal</th>
            <th>Keterangan</th>
            <th>Created At</th>
            <th>Updated At</th>
            
        </tr>
    </thead>
    <tbody>
        @php ($i = 1)
        @foreach ($pengeluarans as $pengeluaran)
        <tr>
            <td> {{$i}} </td>
            <td> {{$pengeluaran->tanggal}} </td>
            <td> {{$pengeluaran->pengeluaran}} </td>
            <td> {{config('custom.pengeluaran.'.$pengeluaran->jenis_pengeluaran)}} </td>
            <td> Rp @angka($pengeluaran->nominal) </td>
            <td> {{$pengeluaran->keterangan}} </td>
            <td> {{$pengeluaran->created_at}} </td>
            <td> {{$pengeluaran->updated_at}} </td>
        </tr>
        @php ($i++)
        @endforeach
    </tbody>
</table>