<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Invoice</th>
            <th>Proyek</th>
            <th>Langganan</th>
            <th>Ads</th>
            <th>Lainnya</th>
            <th>Jumlah Tagihan</th>
            <th>Jumlah Terbayar</th>
            <th>Status Pembayaran</th>
            <th>Penagih</th>
            <th>Keterangan</th>
            
        </tr>
    </thead>
    <tbody>
        @php ($i = 1)
        @foreach ($tagihans as $tagihan)
        <tr>
            <td> {{$i}} </td>
            <td> {{$tagihan->nama}} </td>
            <td> {{$tagihan->invoice}} </td>
            <td> {{$tagihan->nama_proyek}} </td>
            <td> Rp @angka($tagihan->langganan) </td>
            <td> Rp @angka($tagihan->ads) </td>
            <td> Rp @angka($tagihan->lainnya) </td>
            <td> Rp @angka($tagihan->jml_tagih) </td>
            <td> Rp @angka($tagihan->jml_bayar) </td>
            <td> {{config('custom.tagihan_status.'.$tagihan->status)}} </td>
            <td> {{$tagihan->penagih}} </td>
            <td> {{$tagihan->keterangan}} </td>
        </tr>
        @php ($i++)
        @endforeach
    </tbody>
</table>