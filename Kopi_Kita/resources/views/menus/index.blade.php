
@extends('layouts.app')

@section('title', 'Manajemen Menu')
@section('heading', 'Data menu')

@section('content')

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">

    <div>
        <h1 class="text-2xl font-bold text-[#39412F]">
            Manajemen Menu
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Kelola produk, kategori, harga, dan stok Kopi Kita.
        </p>
    </div>

    <a href="{{ route('menus.create') }}"
       class="bg-[#626F4B] text-white px-5 py-3 rounded-xl text-sm font-semibold text-center">
        + Tambah Menu
    </a>

</div>

<!-- STATISTIK -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

    <div class="bg-white border rounded-xl p-4">
        <p class="text-xs text-gray-500">Total Menu</p>
        <h2 class="text-2xl font-bold mt-2">
            {{ $menus->total() }}
        </h2>
    </div>

    <div class="bg-white border rounded-xl p-4">
        <p class="text-xs text-gray-500">Total Kategori</p>
        <h2 class="text-2xl font-bold mt-2">
            {{ $categories->count() }}
        </h2>
    </div>

    <div class="bg-white border rounded-xl p-4">
        <p class="text-xs text-gray-500">Stok Habis</p>
        <h2 class="text-2xl font-bold text-red-600 mt-2">
            {{ $menus->getCollection()->where('stock', 0)->count() }}
        </h2>
    </div>

</div>

<!-- FILTER -->
<form action="{{ route('menus.index') }}"
      method="GET"
      class="bg-white border rounded-xl p-4 mb-5">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

        <input
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama menu..."
            class="border rounded-lg p-3 text-sm outline-none">

        <select name="category_id"
                class="border rounded-lg p-3 text-sm">
            <option value="">Semua kategori</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach

        </select>

        <button class="bg-[#626F4B] text-white rounded-lg p-3 text-sm">
            Cari Menu
        </button>

    </div>

</form>

<!-- TABEL MENU -->
<div class="bg-white border rounded-xl p-5">

    <h3 class="font-bold mb-5">
        Daftar Produk
    </h3>

    <div class="overflow-x-auto">

        <table class="w-full min-w-[750px] text-left text-xs">

            <thead class="bg-[#F5F3EB] text-gray-500">
                <tr>
                    <th class="p-3">Produk</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Harga</th>
                    <th class="p-3">Stok</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($menus as $menu)

                    <tr class="border-b border-gray-100">

                        <td class="p-3">
                            <div class="flex items-center gap-3">

                                @if($menu->image)
                                    <img src="{{ asset('storage/'.$menu->image) }}"
                                         class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 rounded-lg bg-[#F0EEE5]
                                                flex items-center justify-center">
                                        ☕
                                    </div>
                                @endif

                                <div>
                                    <p class="font-semibold">
                                        {{ $menu->name }}
                                    </p>
                                    <p class="text-gray-400 mt-1">
                                        ID #{{ $menu->id }}
                                    </p>
                                </div>

                            </div>
                        </td>

                        <td class="p-3">
                            {{ $menu->category->name ?? '-' }}
                        </td>

                        <td class="p-3 font-semibold">
                            Rp{{ number_format($menu->price, 0, ',', '.') }}
                        </td>

                        <td class="p-3">
                            @if($menu->stock <= 0)
                                <span class="text-red-600 font-semibold">
                                    Habis
                                </span>
                            @elseif($menu->stock <= 10)
                                <span class="text-orange-600 font-semibold">
                                    {{ $menu->stock }} (Menipis)
                                </span>
                            @else
                                <span class="text-green-600">
                                    {{ $menu->stock }}
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            @if($menu->is_active)
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="p-3">

                            <div class="flex items-center gap-3">

                                <a href="{{ route('menus.show', $menu->id) }}"
                                   class="text-blue-600">
                                    Detail
                                </a>

                                <a href="{{ route('menus.edit', $menu->id) }}"
                                   class="text-[#626F4B]">
                                    Edit
                                </a>

                                <form action="{{ route('menus.destroy', $menu->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus menu ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-600">
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="p-10 text-center text-gray-400">
                            Belum ada produk terdaftar.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-5">
        {{ $menus->links() }}
    </div>

</div>

@endsection
