
@csrf

<div class="space-y-5">

    <div>
        <label class="block text-sm font-semibold mb-2">
            Nama Menu
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $menu->name ?? '') }}"
            required
            placeholder="Contoh: Kopi Susu Gula Aren"
            class="w-full border rounded-xl p-3 text-sm">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-2">
            Kategori
        </label>

        <select name="category_id"
                required
                class="w-full border rounded-xl p-3 text-sm">

            <option value="">Pilih kategori</option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $menu->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-2">
            Deskripsi Menu
        </label>

        <textarea
            name="description"
            rows="3"
            class="w-full border rounded-xl p-3 text-sm"
            placeholder="Tuliskan deskripsi menu...">{{ old('description', $menu->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

        <div>
            <label class="block text-sm font-semibold mb-2">
                Harga
            </label>

            <input
                type="number"
                name="price"
                min="0"
                required
                value="{{ old('price', $menu->price ?? '') }}"
                class="w-full border rounded-xl p-3 text-sm">
        </div>

        <div>
            <label class="block text-sm font-semibold mb-2">
                Stok
            </label>

            <input
                type="number"
                name="stock"
                min="0"
                required
                value="{{ old('stock', $menu->stock ?? '') }}"
                class="w-full border rounded-xl p-3 text-sm">
        </div>

    </div>

    <div>
        <label class="block text-sm font-semibold mb-2">
            Foto Menu
        </label>

        <input
            type="file"
            name="image"
            accept="image/*"
            class="w-full border rounded-xl p-3 text-sm">

        @if(isset($menu) && $menu->image)
            <img src="{{ asset('storage/'.$menu->image) }}"
                 class="w-24 h-24 object-cover rounded-xl mt-3">
        @endif
    </div>

    <div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   @checked(old('is_active', $menu->is_active ?? true))
                   class="accent-[#626F4B]">

            Menu aktif dan tersedia untuk transaksi.
        </label>
    </div>

</div>
