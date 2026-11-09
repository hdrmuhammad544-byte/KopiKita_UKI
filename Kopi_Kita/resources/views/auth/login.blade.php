
@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="min-h-screen flex bg-[#F5F3EB]">

    <!-- FOTO KAFE -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden">

        <img
            src="https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=1200"
            class="absolute inset-0 w-full h-full object-cover"
            alt="Interior Kopi Kita">

        <div class="absolute inset-0 bg-black/45"></div>

        <div class="relative z-10 flex flex-col justify-between p-12 text-white">

            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-xl">
                    <i data-lucide="coffee"></i>
                </div>
                <h1 class="text-3xl font-bold">Kopi Kita</h1>
            </div>

            <div>
                <p class="text-sm tracking-widest uppercase mb-4">
                    Kasir & Penjualan
                </p>

                <h2 class="text-4xl font-bold leading-tight">
                    Setiap cangkir punya cerita.
                </h2>

                <p class="text-sm text-white/80 mt-5 max-w-md">
                    Kelola pesanan, penjualan, dan aktivitas gerai
                    dengan lebih mudah bersama Kopi Kita.
                </p>
            </div>

            <p class="text-xs text-white/70">
                © {{ date('Y') }} Kopi Kita.
            </p>

        </div>

    </div>

    <!-- FORM LOGIN -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6">

        <div class="w-full max-w-md">

            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex p-4 bg-[#626F4B] text-white rounded-2xl mb-3">
                    <i data-lucide="coffee"></i>
                </div>
                <h1 class="text-2xl font-bold">Kopi Kita</h1>
            </div>

            <div class="mb-8">
                <p class="text-sm text-[#71805A] font-semibold">
                    SELAMAT DATANG KEMBALI
                </p>

                <h2 class="text-3xl font-bold text-[#34352D] mt-2">
                    Masuk ke akun
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Silakan masuk untuk mengakses sistem kasir.
                </p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-5">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}"
                  method="POST"
                  class="space-y-5">

                @csrf

                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        required
                        class="w-full border border-gray-200 bg-white rounded-xl p-3 outline-none focus:border-[#71805A]">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">
                        Password
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Masukkan password"
                            required
                            class="w-full border border-gray-200 bg-white rounded-xl p-3 pr-12 outline-none focus:border-[#71805A]">

                        <button type="button"
                                onclick="togglePassword()"
                                class="absolute right-4 top-3 text-gray-400">
                            <i data-lucide="eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="remember"
                               class="accent-[#626F4B]">
                        Ingat saya
                    </label>

                </div>

                <button type="submit"
                        class="w-full bg-[#626F4B] hover:bg-[#4F5D3B]
                               text-white rounded-xl py-3 font-semibold transition">
                    Masuk ke Dashboard
                </button>

            </form>

            <p class="text-center text-xs text-gray-400 mt-8">
                Kopi Kita · Sistem Kasir dan Penjualan
            </p>

        </div>

    </div>

</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        password.type = password.type === 'password'
            ? 'text'
            : 'password';

        icon.setAttribute(
            'data-lucide',
            password.type === 'password' ? 'eye' : 'eye-off'
        );

        lucide.createIcons();
    }
</script>

@endsection
