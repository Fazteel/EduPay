<?php

namespace App\Exports;

use App\Models\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    public function view(): View
    {
        return view('pages.report', [
            'payments' => Payment::select('student_id', 'amount', 'payment_date', 'payment_month', 'payment_year', 'is_paid')->get()
        ]);
    }
}
