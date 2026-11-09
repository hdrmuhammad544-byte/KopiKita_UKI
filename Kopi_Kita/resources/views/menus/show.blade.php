
@extends('layouts.app')

@section('title', 'Detail Menu')
@section('heading', 'Data menu')

@section('content')

<div class="max-w-3xl mx-auto">

    <a href="{{ route('menus.index') }}"
       class="text-sm text-[#626F4B]">
        ← Kembali ke daftar menu
    </a>

    <div class="bg-white border rounded-xl overflow-hidden mt-5">

        @if($menu->image)
            <img src="{{ asset('storage/'.$menu->image) }}"
                 class="w-full h-64 object-cover">
        @else
            <div class="h-64 flex items-center justify-center bg-[#EDEAE0] text-6xl">
                ☕
            </div>
        @endif

        <div class="p-6">

            <span class="text-xs text-[#626F4B] font-semibold">
                {{ $menu->category->name ?? 'Tanpa Kategori' }}
            </span>

            <h1 class="text-2xl font-bold mt-2">
                {{ $menu->name }}
            </h1>

            <p class="text-sm text-gray-500 mt-3">
                {{ $menu->description ?: 'Tidak ada deskripsi.' }}
            </p>

            <div class="grid grid-cols-2 gap-4 mt-7">

                <div class="bg-[#F5F3EB] rounded-xl p-4">
                    <p class="text-xs text-gray-500">Harga</p>
                    <p class="text-xl font-bold mt-2">
                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                    </p>
                </div>

                <div class="bg-[#F5F3EB] rounded-xl p-4">
                    <p class="text-xs text-gray-500">Stok</p>
                    <p class="text-xl font-bold mt-2">
                        {{ $menu->stock }}
                    </p>
                </div>

            </div>

            <div class="mt-5 text-sm">
                Status:
                <strong>
                    {{ $menu->is_active ? 'Aktif' : 'Nonaktif' }}
                </strong>
            </div>

            <a href="{{ route('menus.edit', $menu->id) }}"
               class="inline-block bg-[#626F4B] text-white px-5 py-3 rounded-lg mt-6 text-sm">
                Edit Menu
            </a>

        </div>

    </div>

</div>

@endsection
