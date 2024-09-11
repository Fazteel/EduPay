<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Payment;
use App\Exports\PaymentExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $paymentsQuery = Payment::with('student');
        $payments = $paymentsQuery->get();

        $students = Student::where('name', 'like', "%$query%")
            ->orWhere('id', 'like', "%$query%")
            ->get();
        return view('pages.transaction', compact('students', 'payments'));
    }

    public function store(Request $request, $studentId)
    {
        $request->validate([
            'price' => 'required|numeric',
            'payment_month' => 'required|array',
        ]);

        $amount = $request->price;

        foreach ($request->payment_month as $month) {
            Payment::create([
                'student_id' => $studentId,
                'amount' => $amount, 
                'payment_date' => Carbon::now(),
                'payment_month' => $month,
                'payment_year' => Carbon::now()->year,
                'is_paid' => true,
            ]);
        }

        return redirect()->route('transaction')->with('success', 'Pembayaran berhasil.');
    }

    public function indexHome()
    {
        $payments = Payment::with('student')->latest()->take(10)->get();

        $totalSaldo = Payment::sum('amount');
        $saldoHarian = Payment::whereDate('created_at', Carbon::today())->sum('amount');
        $totalSiswa = Student::count();

        return view('dashboard', compact('payments', 'totalSaldo', 'saldoHarian', 'totalSiswa'));
    }

    public function indexReport(Request $request)
    {
        $query = $request->input('query');
        $filterClass = $request->input('filter_class');
    
        $saldoHarian = Payment::whereDate('created_at', Carbon::today())->sum('amount');
        $saldoMingguan = Payment::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
        $saldoBulanan = Payment::whereMonth('created_at', Carbon::now()->month)->sum('amount');
        
        $paymentsQuery = Payment::with('student');
        
        if ($query) {
            $paymentsQuery->whereHas('student', function($q) use ($query) {
                $q->where('name', 'like', "%$query%")
                  ->orWhere('nis', 'like', "%$query%")
                  ->orWhere('class', 'like', "%$query%");
            });
        }
    
        if ($filterClass) {
            $paymentsQuery->whereHas('student', function($q) use ($filterClass) {
                $q->where('class', 'like', "%$filterClass%");
            });
        }
        
        $payments = $paymentsQuery->get();
        
        return view('pages.report', compact('payments', 'saldoHarian', 'saldoMingguan', 'saldoBulanan'));
    }

    public function export()
    {
        return Excel::download(new PaymentExport, 'payment.xlsx');
    }
}    
