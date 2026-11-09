
@extends('layouts.app')

@section('title', 'Edit Menu')
@section('heading', 'Data menu')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">
        <a href="{{ route('menus.index') }}"
           class="text-sm text-[#626F4B]">
            ← Kembali ke daftar menu
        </a>

        <h1 class="text-2xl font-bold mt-3">
            Edit Menu
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Perbarui informasi produk {{ $menu->name }}.
        </p>
    </div>

    <div class="bg-white border rounded-xl p-6">

        <form action="{{ route('menus.update', $menu->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @method('PUT')

            @include('menus.form')

            <div class="flex justify-end gap-3 mt-7">

                <a href="{{ route('menus.index') }}"
                   class="border px-5 py-3 rounded-lg text-sm">
                    Batal
                </a>

                <button class="bg-[#626F4B] text-white px-6 py-3 rounded-lg text-sm">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
