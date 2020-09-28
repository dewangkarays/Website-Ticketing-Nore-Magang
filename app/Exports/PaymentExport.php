<?php

namespace App\Exports;

use App\Model\Payment;
use Illuminate\Contracts\View\View;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

// class PaymentExport implements FromCollection
// {
//     public function collection()
//     {
//         return Payment::all();
//     }
// }
class PaymentExport implements FromView, ShouldAutoSize
{
    public function view(): View
    {
        return view('payments.paymentexcel', [
            'payments' => Payment::all()
        ]);
    }
}