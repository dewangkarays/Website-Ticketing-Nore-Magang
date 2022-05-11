<table>
    <thead>
        <tr>
            {{-- <th>ID</th> --}}
            <th>No</th>
            <th>Nama</th>
            <th>Keterangan</th>
            <th>Nominal</th>
            <th>Kadaluarsa</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Tanggal Bayar</th>
            <th>Status</th>
            <th>Role User</th>
            <th>Task Count</th>
            <th>ID Tagihan - Invoice</th>
        </tr>
    </thead>
    <tbody>
        @php ($i = 1)
        @foreach ($payments as $payment)
        <tr>
            {{-- <td> {{$payment->id}} </td> --}}
            <td> {{$i}} </td>
            <td> {{$payment->user->nama}} </td>
            <td> {{$payment->keterangan}} </td>
            <td> Rp @angka($payment->nominal) </td>
            <td> {{$payment->kadaluarsa}} </td>
            <td> {{$payment->created_at}} </td>
            <td> {{$payment->updated_at}} </td>
            <td> {{$payment->tanggal}} </td>
            <td> {{config('custom.payment.'.$payment->status)}} </td>
            <td> {{config('custom.role.'.$payment->user_role)}} </td>
            <td> {{$payment->task_count}} </td>
        <td> {{$payment->tagihan_id}} - {{@$payment->tagihan->invoice }}</td>
        </tr>
        @php ($i++)
        @endforeach
    </tbody>
</table>
