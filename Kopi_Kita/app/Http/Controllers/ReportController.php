<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Menampilkan riwayat transaksi
    public function index(Request $request)
    {
        $query = Transaction::with('user', 'details')
            ->latest('transaction_date');

        // Filter tanggal awal
        if ($request->filled('start_date')) {
            $query->whereDate(
                'transaction_date',
                '>=',
                $request->start_date
            );
        }

        // Filter tanggal akhir
        if ($request->filled('end_date')) {
            $query->whereDate(
                'transaction_date',
                '<=',
                $request->end_date
            );
        }

        // Pencarian nomor invoice
        if ($request->filled('search')) {
            $query->where(
                'invoice',
                'like',
                '%' . $request->search . '%'
            );
        }

        $transactions = $query
            ->paginate(10)
            ->withQueryString();

        $totalSales = Transaction::where('status', 'paid')
            ->when($request->filled('start_date'), function ($q) use ($request) {
                $q->whereDate('transaction_date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                $q->whereDate('transaction_date', '<=', $request->end_date);
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('invoice', 'like', '%' . $request->search . '%');
            })
            ->sum('total');

                return view('reports.index', compact(
                    'transactions',
                    'totalSales'
                ));
    }

    // Menampilkan detail transaksi dan struk
    public function show($id)
    {
        $transaction = Transaction::with([
            'user',
            'details'
        ])->findOrFail($id);

        return view('reports.receipt', compact(
            'transaction'
        ));
    }

    // Cetak struk PDF
    public function pdf($id)
    {
        $transaction = Transaction::with([
            'user',
            'details'
        ])->findOrFail($id);

        // Sementara menampilkan halaman struk untuk dicetak
        return view('reports.receipt', compact(
            'transaction'
        ));
    }
}
