
@extends('layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')

<div class="mb-7">
    <h1 class="text-2xl font-bold text-[#39412F]">
        Dashboard
    </h1>

    <p class="text-sm text-gray-500 mt-1">
        Selamat datang di sistem pengelolaan Kopi Kita.
    </p>
</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    @php
        $stats = [
            [
                'title' => 'Penjualan Hari Ini',
                'value' => 'Rp'.number_format($totalSales ?? 0, 0, ',', '.'),
                'icon' => 'wallet',
                'color' => 'bg-[#E7EDDF]'
            ],
            [
                'title' => 'Jumlah Menu',
                'value' => $totalMenus ?? 0,
                'icon' => 'coffee',
                'color' => 'bg-[#F2EBDD]'
            ],
            [
                'title' => 'Kategori Menu',
                'value' => $totalCategories ?? 0,
                'icon' => 'layers',
                'color' => 'bg-[#E8EAF0]'
            ],
            [
                'title' => 'Transaksi Hari Ini',
                'value' => $totalTransactions ?? 0,
                'icon' => 'shopping-bag',
                'color' => 'bg-[#F3E8E3]'
            ]
        ];
    @endphp

    @foreach($stats as $stat)

        <div class="bg-white border border-[#E8E5DC] rounded-xl p-5">

            <div class="flex justify-between items-center">

                <div>
                    <p class="text-xs text-gray-500">
                        {{ $stat['title'] }}
                    </p>

                    <h2 class="text-xl font-bold mt-3 text-[#39412F]">
                        {{ $stat['value'] }}
                    </h2>
                </div>

                <div class="{{ $stat['color'] }} p-3 rounded-xl text-[#626F4B]">
                    <i data-lucide="{{ $stat['icon'] }}"></i>
                </div>

            </div>

        </div>

    @endforeach

</div>

<!-- GRAFIK -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">

    <div class="xl:col-span-2 bg-white border border-[#E8E5DC] rounded-xl p-5">

        <h3 class="font-bold text-[#39412F]">
            Grafik Penjualan
        </h3>

        <p class="text-xs text-gray-400 mt-1">
            Perkembangan penjualan selama 7 hari terakhir.
        </p>

        <div class="mt-6">
            <canvas
            id="salesChart"
            height="120"
            data-sales="{{ json_encode($salesChart ?? []) }}">
            </canvas>
        </div>

    </div>

    <!-- INFORMASI -->
    <div class="bg-[#626F4B] text-white rounded-xl p-5">

        <div class="flex justify-between">
            <div>
                <p class="text-xs text-white/70">
                    Informasi Gerai
                </p>

                <h3 class="text-xl font-bold mt-2">
                    Kopi Kita
                </h3>
            </div>

            <i data-lucide="coffee" class="w-7 h-7"></i>
        </div>

        <div class="mt-8 space-y-4 text-sm">

            <div class="flex justify-between">
                <span class="text-white/70">Cabang</span>
                <span>Pati · Pusat</span>
            </div>

            <div class="flex justify-between">
                <span class="text-white/70">Jam operasional</span>
                <span>08.00–22.00</span>
            </div>

            <div class="flex justify-between">
                <span class="text-white/70">Status</span>
                <span class="bg-white/20 px-2 py-1 rounded">
                    Aktif
                </span>
            </div>

        </div>

    </div>

</div>

<!-- TRANSAKSI TERBARU -->
<div class="bg-white border border-[#E8E5DC] rounded-xl p-5">

    <div class="flex justify-between items-center mb-5">

        <div>
            <h3 class="font-bold text-[#39412F]">
                Transaksi Terbaru
            </h3>

            <p class="text-xs text-gray-400 mt-1">
                Aktivitas transaksi yang baru dilakukan.
            </p>
        </div>

        <a href="{{ route('reports.index') }}"
           class="text-xs text-[#626F4B] font-semibold">
            Lihat semua →
        </a>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-left text-xs min-w-[600px]">

            <thead class="bg-[#F5F3EB] text-gray-500">
                <tr>
                    <th class="p-3">Invoice</th>
                    <th class="p-3">Kasir</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Total</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($recentTransactions ?? [] as $transaction)

                    <tr class="border-b border-gray-100">

                        <td class="p-3 font-semibold">
                            {{ $transaction->invoice }}
                        </td>

                        <td class="p-3">
                            {{ $transaction->user?->name ?? '-' }}
                        </td>

                        <td class="p-3">
                            {{ $transaction->transaction_date?->format('d/m/Y H:i') }}
                        </td>

                        <td class="p-3 font-semibold">
                            Rp{{ number_format($transaction->total, 0, ',', '.') }}
                        </td>

                        <td class="p-3">
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5"
                            class="p-8 text-center text-gray-400">
                            Belum ada transaksi.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const canvas = document.getElementById('salesChart');

    const salesData = JSON.parse(
        canvas.dataset.sales || '[]'
    );

    new Chart(canvas, {
        type: 'line',

        data: {
            labels: salesData.map(item => item.date),

            datasets: [{
                label: 'Penjualan',
                data: salesData.map(item => item.total),

                borderColor: '#626F4B',
                backgroundColor: 'rgba(98,111,75,.12)',

                fill: true,
                tension: 0.4
            }]
        },

        options: {
            responsive: true,

            plugins: {
                legend: {
                    display: false
                }
            },

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush