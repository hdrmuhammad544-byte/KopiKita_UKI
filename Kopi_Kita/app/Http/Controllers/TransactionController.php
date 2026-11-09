<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman POS
     */
    public function index()
    {
        $menus = Menu::with('category')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('pos.index', compact(
            'menus',
            'categories'
        ));
    }

    /**
     * Menyimpan transaksi pembayaran
     */
    public function store(Request $request)
    {
        // Validasi input transaksi
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',

            'paid_amount' => 'required|integer|min:0',

            'payment_method' => 'required|in:cash,qris',

            'service_type' => 'required|in:dine_in,takeaway',

            'table_number' => 'nullable|string|max:20',
        ]);

        // Validasi nomor meja
        if ($validated['service_type'] === 'dine_in') {
            $request->validate([
                'table_number' => 'required|string|max:20',
            ]);
        }

        // Proses transaksi menggunakan database transaction
        $transaction = DB::transaction(function () use ($validated) {

            $subtotal = 0;
            $details = [];

            // Memeriksa menu dan stok
            foreach ($validated['items'] as $item) {

                $menu = Menu::where('id', $item['menu_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$menu->is_active) {
                    throw ValidationException::withMessages([
                        'items' => "Menu {$menu->name} sedang tidak tersedia.",
                    ]);
                }

                if ($menu->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Stok {$menu->name} tidak mencukupi.",
                    ]);
                }

                // Menghitung subtotal produk
                $itemSubtotal = $menu->price * $item['quantity'];

                $subtotal += $itemSubtotal;

                $details[] = [
                    'menu' => $menu,
                    'quantity' => $item['quantity'],
                    'price' => $menu->price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            // Menghitung pajak 10%
            $tax = (int) round($subtotal * 0.10);

            // Menghitung total pembayaran
            $total = $subtotal + $tax;

            // Memeriksa nominal pembayaran
            if ($validated['paid_amount'] < $total) {
                throw ValidationException::withMessages([
                    'paid_amount' => 'Uang pembayaran masih kurang.',
                ]);
            }

            // Membuat nomor invoice
            $invoice = 'INV-' . now()->format('YmdHis')
                . '-' . Str::upper(Str::random(4));

            // Menyimpan transaksi utama
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'invoice' => $invoice,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => $validated['paid_amount'] - $total,
                'payment_method' => $validated['payment_method'],
                'service_type' => $validated['service_type'],
                'table_number' => $validated['service_type'] === 'dine_in'
                    ? $validated['table_number']
                    : null,
                'status' => 'paid',
                'transaction_date' => now(),
            ]);

            // Menyimpan detail transaksi dan mengurangi stok
            foreach ($details as $detail) {

                $transaction->details()->create([
                    'menu_id' => $detail['menu']->id,
                    'menu_name' => $detail['menu']->name,
                    'quantity' => $detail['quantity'],
                    'price' => $detail['price'],
                    'subtotal' => $detail['subtotal'],
                ]);

                $detail['menu']->decrement(
                    'stock',
                    $detail['quantity']
                );
            }

            return $transaction;
        });

        // Mengarahkan kasir ke halaman struk
        return redirect()
            ->route('reports.show', $transaction->id)
            ->with('success', 'Transaksi berhasil disimpan!');
    }
}
