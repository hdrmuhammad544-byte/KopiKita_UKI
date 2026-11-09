
@extends('layouts.app')

@section('title', 'Detail Struk')
@section('heading', 'Laporan & struk')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="flex flex-col sm:flex-row justify-between gap-3 mb-6">

        <div>
            <a href="{{ route('reports.index') }}"
               class="text-sm text-[#626F4B]">
                ← Kembali ke laporan
            </a>

            <h1 class="text-2xl font-bold mt-3">
                Detail Transaksi
            </h1>
        </div>

        <button onclick="window.print()"
                class="bg-[#626F4B] text-white px-5 py-3 rounded-lg text-sm h-fit">
            <i data-lucide="printer"
               class="w-4 h-4 inline mr-1"></i>
            Cetak Struk
        </button>

    </div>

    <div class="bg-white border rounded-xl p-6" id="receipt">

        <!-- IDENTITAS TOKO -->
        <div class="text-center border-b border-dashed pb-5">

            <div class="inline-flex bg-[#E8EDDF] p-3 rounded-xl text-[#626F4B] mb-3">
                <i data-lucide="coffee" class="w-7 h-7"></i>
            </div>

            <h2 class="text-2xl font-bold">
                Kopi Kita
            </h2>

            <p class="text-xs text-gray-500 mt-2">
                Pati · Pusat
            </p>

            <p class="text-xs text-gray-400 mt-1">
                Terima kasih telah berkunjung.
            </p>

        </div>

        <!-- INFO TRANSAKSI -->
        <div class="py-5 space-y-3 text-xs">

            <div class="flex justify-between">
                <span class="text-gray-500">Invoice</span>
                <strong>{{ $transaction->invoice }}</strong>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>
                <strong>
                    {{ $transaction->transaction_date?->format('d/m/Y H:i') }}
                </strong>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Kasir</span>
                <strong>{{ $transaction->user?->name ?? '-' }}</strong>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Layanan</span>
                <strong>
                    {{ $transaction->service_type === 'dine_in' ? 'Makan di tempat' : 'Bawa pulang' }}
                </strong>
            </div>

            @if($transaction->table_number)
                <div class="flex justify-between">
                    <span class="text-gray-500">Nomor meja</span>
                    <strong>{{ $transaction->table_number }}</strong>
                </div>
            @endif

        </div>

        <!-- DAFTAR PRODUK -->
        <div class="border-y border-dashed py-5">

            <h3 class="font-bold text-sm mb-4">
                Rincian Pesanan
            </h3>

            @foreach($transaction->details as $detail)

                <div class="mb-4">

                    <div class="flex justify-between gap-3 text-xs">

                        <span class="font-semibold">
                            {{ $detail->menu_name }}
                        </span>

                        <strong>
                            Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                        </strong>

                    </div>

                    <p class="text-gray-400 text-xs mt-1">
                        {{ $detail->quantity }} ×
                        Rp{{ number_format($detail->price, 0, ',', '.') }}
                    </p>

                </div>

            @endforeach

        </div>

        <!-- TOTAL -->
        <div class="py-5 space-y-3 text-xs">

            <div class="flex justify-between">
                <span class="text-gray-500">Subtotal</span>
                <span>
                    Rp{{ number_format($transaction->subtotal, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Pajak (10%)</span>
                <span>
                    Rp{{ number_format($transaction->tax, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex justify-between font-bold text-base pt-3 border-t">
                <span>Total</span>
                <span class="text-[#626F4B]">
                    Rp{{ number_format($transaction->total, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Metode pembayaran</span>
                <strong class="uppercase">
                    {{ $transaction->payment_method }}
                </strong>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Uang diterima</span>
                <span>
                    Rp{{ number_format($transaction->paid_amount, 0, ',', '.') }}
                </span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Kembalian</span>
                <strong>
                    Rp{{ number_format($transaction->change_amount, 0, ',', '.') }}
                </strong>
            </div>

        </div>

        <div class="border-t border-dashed pt-5 text-center">
            <p class="font-semibold text-sm">
                Terima kasih!
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Semoga harimu menyenangkan.
            </p>
        </div>

    </div>

</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #receipt, #receipt * {
            visibility: visible;
        }

        #receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }

        button, a {
            display: none !important;
        }

        @page {
            margin: 12mm;
        }
    }
</style>

@endsection
