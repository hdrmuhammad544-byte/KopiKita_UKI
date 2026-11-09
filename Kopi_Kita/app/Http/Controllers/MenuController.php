<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Menampilkan seluruh menu
     */
    public function index(Request $request)
    {
        // Query utama menu
        $query = Menu::with('category')->latest();

        // Pencarian berdasarkan nama menu
        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where(
                'category_id',
                $request->category_id
            );
        }

        // Pagination
        $menus = $query->paginate(10)->withQueryString();

        // Mengambil seluruh kategori
        $categories = Category::orderBy('name')->get();

        return view('menus.index', compact(
            'menus',
            'categories'
        ));
    }

    /**
     * Form tambah menu
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('menus.create', compact('categories'));
    }

    /**
     * Menyimpan menu baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('menus', 'public');
        }

        // Status menu
        $validated['is_active'] = $request->boolean(
            'is_active',
            true
        );

        // Simpan ke database
        Menu::create($validated);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail menu
     */
    public function show(Menu $menu)
    {
        $menu->load('category');

        return view('menus.show', compact('menu'));
    }

    /**
     * Form edit menu
     */
    public function edit(Menu $menu)
    {
        $categories = Category::orderBy('name')->get();

        return view('menus.edit', compact(
            'menu',
            'categories'
        ));
    }

    /**
     * Memperbarui menu
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar baru jika tersedia
        if ($request->hasFile('image')) {

            // Hapus gambar lama
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }

            // Simpan gambar baru
            $validated['image'] = $request->file('image')
                ->store('menus', 'public');
        }

        // Checkbox tidak dicentang berarti nonaktif
        $validated['is_active'] = $request->boolean('is_active');

        // Update database
        $menu->update($validated);

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * Menghapus menu
     */
    public function destroy(Menu $menu)
    {
        // Hapus gambar dari storage
        if ($menu->image) {
            Storage::disk('public')->delete($menu->image);
        }

        // Hapus data menu
        $menu->delete();

        return redirect()
            ->route('menus.index')
            ->with('success', 'Menu berhasil dihapus!');
    }
}
