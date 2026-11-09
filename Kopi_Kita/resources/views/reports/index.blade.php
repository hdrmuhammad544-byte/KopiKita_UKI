
@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('heading', 'Laporan & Struk')

@section('content')

<!-- HEADER -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-[#39412F]">
        Laporan & Struk
    </h1>

    <p class="text-sm text-gray-500 mt-1">
        Pantau penjualan dan riwayat transaksi Kopi Kita.
    </p>
</div>

<!-- FILTER TANGGAL -->
<form action="{{ route('reports.index') }}"
      method="GET"
      class="bg-white border rounded-xl p-4 mb-6">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

        <div>
            <label class="text-xs font-semibold block mb-2">
                Tanggal Mulai
            </label>

            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}"
                class="w-full border rounded-lg p-3 text-sm focus:ring-2 focus:ring-[#626F4B] outline-none"
            >
        </div>

        <div>
            <label class="text-xs font-semibold block mb-2">
                Tanggal Akhir
            </label>

            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}"
                class="w-full border rounded-lg p-3 text-sm focus:ring-2 focus:ring-[#626F4B] outline-none"
            >
        </div>

        <div class="flex items-end gap-2">

            <button
                type="submit"
                class="flex-1 bg-[#626F4B] text-white rounded-lg p-3 text-sm hover:bg-[#4F5B3C] transition">
                Terapkan Filter
            </button>

            <a
                href="{{ route('reports.index') }}"
                class="border rounded-lg p-3 text-sm text-gray-500 hover:bg-gray-50">
                Reset
            </a>

        </div>

    </div>
</form>

<!-- RINGKASAN PENJUALAN -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <div class="bg-white border rounded-xl p-5">
        <div class="flex justify-between items-center">
            <p class="text-xs text-gray-500">
                Total Penjualan
            </p>

            <i data-lucide="wallet" class="w-5 h-5 text-[#626F4B]"></i>
        </div>

        <h2 class="text-xl font-bold mt-3 text-[#626F4B]">
            Rp{{ number_format($totalSales ?? 0, 0, ',', '.') }}
        </h2>
    </div>

    <div class="bg-white border rounded-xl p-5">
        <div class="flex justify-between items-center">
            <p class="text-xs text-gray-500">
                Jumlah Transaksi
            </p>

            <i data-lucide="receipt" class="w-5 h-5 text-[#626F4B]"></i>
        </div>

        <h2 class="text-xl font-bold mt-3">
            {{ $totalTransactions ?? 0 }}
        </h2>
    </div>

    <div class="bg-white border rounded-xl p-5">
        <div class="flex justify-between items-center">
            <p class="text-xs text-gray-500">
                Rata-rata Transaksi
            </p>

            <i data-lucide="chart-no-axes-combined" class="w-5 h-5 text-[#626F4B]"></i>
        </div>

        <h2 class="text-xl font-bold mt-3">
            Rp{{ number_format($averageTransaction ?? 0, 0, ',', '.') }}
        </h2>
    </div>

</div>

<!-- RIWAYAT TRANSAKSI -->
<div class="bg-white border rounded-xl p-5">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-5">

        <div>
            <h3 class="font-bold text-[#39412F]">
                Riwayat Transaksi
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Daftar transaksi yang tercatat dalam sistem.
            </p>
        </div>

        <div class="text-xs text-gray-500">
            Total: {{ $transactions->total() ?? 0 }} transaksi
        </div>

    </div>

    <!-- TABEL -->
    <div class="overflow-x-auto">

        <table class="w-full min-w-[850px] text-xs text-left">

            <thead class="bg-[#F5F3EB] text-gray-500">

                <tr>
                    <th class="p-3">Invoice</th>
                    <th class="p-3">Kasir</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Pembayaran</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($transactions as $transaction)

                    <tr class="border-b border-gray-100 hover:bg-[#FAFAF7] transition">

                        <!-- INVOICE -->
                        <td class="p-3 font-semibold text-[#39412F]">
                            {{ $transaction->invoice }}
                        </td>

                        <!-- KASIR -->
                        <td class="p-3">
                            {{ $transaction->user?->name ?? '-' }}
                        </td>

                        <!-- TANGGAL -->
                        <td class="p-3 whitespace-nowrap">
                            {{ $transaction->transaction_date?->format('d/m/Y H:i') }}
                        </td>

                        <!-- METODE PEMBAYARAN -->
                        <td class="p-3 uppercase">
                            {{ $transaction->payment_method }}
                        </td>

                        <!-- TOTAL -->
                        <td class="p-3 font-semibold whitespace-nowrap">
                            Rp{{ number_format($transaction->total, 0, ',', '.') }}
                        </td>

                        <!-- STATUS -->
                        <td class="p-3">

                            @if($transaction->status === 'paid')

                                <span class="bg-green-100 text-green-700 rounded-full px-2 py-1">
                                    Lunas
                                </span>

                            @else

                                <span class="bg-yellow-100 text-yellow-700 rounded-full px-2 py-1">
                                    {{ ucfirst($transaction->status) }}
                                </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td class="p-3">

                            <div class="flex items-center gap-3">

                                <!-- DETAIL -->
                                <a
                                    href="{{ route('reports.show', $transaction->id) }}"
                                    class="text-[#626F4B] font-semibold hover:underline whitespace-nowrap">

                                    <i data-lucide="eye" class="w-3 h-3 inline"></i>
                                    Detail

                                </a>

                                <!-- PDF -->
                                <a
                                    href="{{ route('reports.pdf', $transaction->id) }}"
                                    target="_blank"
                                    class="text-blue-600 font-semibold hover:underline whitespace-nowrap">

                                    <i data-lucide="file-down" class="w-3 h-3 inline"></i>
                                    PDF

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="p-10 text-center">

                            <div class="flex flex-col items-center gap-2">

                                <i data-lucide="receipt" class="w-10 h-10 text-gray-300"></i>

                                <p class="text-gray-500 font-medium">
                                    Belum ada riwayat transaksi.
                                </p>

                                <p class="text-xs text-gray-400">
                                    Transaksi yang berhasil akan muncul di sini.
                                </p>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    @if($transactions->hasPages())

        <div class="mt-5">
            {{ $transactions->links() }}
        </div>

    @endif

</div>

@endsection
