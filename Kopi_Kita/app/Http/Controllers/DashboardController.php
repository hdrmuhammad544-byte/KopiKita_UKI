<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Total penjualan hari ini
        $totalSales = Transaction::whereDate(
            'transaction_date',
            today()
        )->where('status', 'paid')->sum('total');

        // Jumlah seluruh menu
        $totalMenus = Menu::count();

        // Jumlah kategori
        $totalCategories = Category::count();

        // Jumlah transaksi hari ini
        $totalTransactions = Transaction::whereDate(
            'transaction_date',
            today()
        )->where('status', 'paid')->count();

        // Transaksi terbaru
        $recentTransactions = Transaction::with('user')
            ->latest('transaction_date')
            ->take(5)
            ->get();

        // Data penjualan 7 hari terakhir
        $salesChart = Transaction::selectRaw(
            'DATE(transaction_date) as date, SUM(total) as total'
        )
            ->where('status', 'paid')
            ->whereDate('transaction_date', '>=', today()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard.index', compact(
            'totalSales',
            'totalMenus',
            'totalCategories',
            'totalTransactions',
            'recentTransactions',
            'salesChart'
        ));
    }
}
