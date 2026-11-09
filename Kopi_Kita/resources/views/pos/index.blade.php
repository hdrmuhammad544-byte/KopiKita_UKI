
@extends('layouts.app')

@section('title', 'Transaksi Kasir')
@section('heading', 'Transaksi kasir')

@push('styles')
<style>
    :root {
        --olive: #626F4B;
        --olive-dark: #4F5D3B;
        --cream: #F5F3EB;
        --beige: #EDEAE0;
        --text: #34352D;
        --muted: #858579;
        --border: #E8E5DC;
    }

    body {
        background: var(--cream) !important;
        color: var(--text);
        font-family: 'Segoe UI', sans-serif;
    }

    .pos-page {
        max-width: 1600px;
        margin: auto;
    }

    .pos-heading {
        display: flex;
        justify-content: space-between;
        align-items: start;
        gap: 15px;
        margin-bottom: 22px;
    }

    .pos-heading h1 {
        font-size: 25px;
        font-weight: 700;
        color: var(--text);
    }

    .pos-heading p {
        color: var(--muted);
        font-size: 13px;
        margin-top: 5px;
    }

    .shift-badge {
        background: #E8EDDF;
        color: var(--olive-dark);
        padding: 9px 13px;
        border-radius: 8px;
        font-size: 11px;
        white-space: nowrap;
    }

    .pos-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.8fr) minmax(320px, .9fr);
        gap: 18px;
        align-items: start;
    }

    .catalog-search {
        position: relative;
        margin-bottom: 14px;
    }

    .catalog-search input {
        width: 100%;
        height: 43px;
        padding: 0 15px 0 42px;
        background: white;
        border: 1px solid var(--border);
        border-radius: 10px;
        outline: none;
        font-size: 12px;
    }

    .catalog-search input:focus,
    .note-input:focus,
    .payment-input:focus {
        border-color: var(--olive);
        box-shadow: 0 0 0 3px rgba(98,111,75,.10);
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 13px;
        width: 17px;
        color: #999;
    }

    .category-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
    }

    .category-filter {
        border: 1px solid var(--border);
        background: white;
        color: #55564D;
        padding: 9px 15px;
        border-radius: 8px;
        font-size: 11px;
        transition: .2s;
    }

    .category-filter.active,
    .category-filter:hover {
        background: var(--olive);
        color: white;
        border-color: var(--olive);
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .product-card {
        min-width: 0;
        background: white;
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        transition: .2s;
    }

    .product-card:hover {
        border-color: #A8B193;
        transform: translateY(-2px);
        box-shadow: 0 5px 16px rgba(0,0,0,.05);
    }

    .product-image {
        width: 100%;
        height: 105px;
        object-fit: cover;
        background: #EEECE3;
    }

    .product-image-placeholder {
        height: 105px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #EEECE3;
        font-size: 35px;
    }

    .product-body {
        padding: 11px;
    }

    .product-name {
        font-size: 12px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 5px;
    }

    .product-description {
        font-size: 10px;
        color: var(--muted);
        line-height: 1.5;
        min-height: 29px;
    }

    .product-stock {
        color: #7B826D;
        font-size: 10px;
        margin-top: 5px;
    }

    .product-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 5px;
        margin-top: 11px;
    }

    .product-price {
        color: var(--text);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .add-product {
        background: #EEF1E8;
        color: var(--olive-dark);
        padding: 7px 9px;
        border-radius: 7px;
        font-size: 10px;
        white-space: nowrap;
    }

    .add-product:hover {
        background: var(--olive);
        color: white;
    }

    .catalog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
    }

    .pagination-buttons {
        display: flex;
        gap: 6px;
    }

    .pagination-buttons button {
        background: white;
        border: 1px solid var(--border);
        border-radius: 7px;
        padding: 8px 12px;
        font-size: 10px;
    }

    .pagination-buttons button:disabled {
        opacity: .4;
        cursor: not-allowed;
    }

    .stock-notice {
        margin-top: 13px;
        background: #EAF0E3;
        color: #66734E;
        padding: 11px 13px;
        border-radius: 8px;
        font-size: 10px;
    }

    .order-panel {
        background: white;
        border: 1px solid var(--border);
        border-radius: 13px;
        padding: 15px;
        position: sticky;
        top: 15px;
    }

    .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
    }

    .order-header h3 {
        font-size: 15px;
        font-weight: 700;
    }

    .clear-cart {
        color: #A36D65;
        font-size: 10px;
    }

    .service-options,
    .payment-options {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px;
        background: #F5F3ED;
        padding: 4px;
        border-radius: 8px;
        margin-bottom: 13px;
    }

    .service-options label,
    .payment-options label {
        cursor: pointer;
    }

    .service-options input,
    .payment-options input {
        display: none;
    }

    .service-options span,
    .payment-options span {
        display: block;
        padding: 9px 5px;
        text-align: center;
        border-radius: 6px;
        font-size: 10px;
        color: #77776C;
    }

    .service-options input:checked + span,
    .payment-options input:checked + span {
        background: white;
        color: var(--olive-dark);
        box-shadow: 0 1px 4px rgba(0,0,0,.08);
        font-weight: 700;
    }

    .invoice-info {
        display: flex;
        justify-content: space-between;
        gap: 5px;
        color: #77776C;
        font-size: 10px;
        margin-bottom: 14px;
    }

    .invoice-number {
        color: var(--text);
        font-weight: 700;
    }

    .cart-list {
        max-height: 205px;
        overflow-y: auto;
    }

    .cart-row {
        padding: 9px 0;
        border-bottom: 1px solid #F0EEE8;
    }

    .cart-row-top {
        display: flex;
        justify-content: space-between;
        gap: 8px;
    }

    .cart-name {
        font-size: 11px;
        font-weight: 700;
    }

    .cart-remove {
        color: #A36D65;
        font-size: 13px;
    }

    .cart-row-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 7px;
        gap: 5px;
    }

    .cart-unit-price {
        color: var(--muted);
        font-size: 10px;
    }

    .cart-subtotal {
        font-size: 11px;
        font-weight: 700;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
        border: 1px solid var(--border);
        padding: 3px 6px;
        border-radius: 6px;
    }

    .quantity-control button {
        color: var(--olive-dark);
        font-weight: 700;
        font-size: 13px;
    }

    .quantity-control span {
        font-size: 10px;
        min-width: 10px;
        text-align: center;
    }

    .note-input,
    .payment-input {
        width: 100%;
        border: 1px solid var(--border);
        padding: 10px;
        border-radius: 7px;
        font-size: 10px;
        outline: none;
        background: white;
    }

    .summary {
        border-top: 1px solid var(--border);
        margin-top: 12px;
        padding-top: 12px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        font-size: 11px;
    }

    .summary-label {
        color: var(--muted);
    }

    .total-row {
        font-weight: 700;
        font-size: 13px;
    }

    .total-value {
        color: var(--olive);
        font-size: 21px;
    }

    .payment-label {
        display: block;
        font-size: 10px;
        font-weight: 600;
        margin: 13px 0 7px;
    }

    .change-row {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        font-size: 11px;
    }

    .change-value {
        color: var(--olive);
        font-weight: 700;
    }

    .pay-button {
        width: 100%;
        background: var(--olive);
        color: white;
        padding: 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        margin-top: 14px;
        transition: .2s;
    }

    .pay-button:hover {
        background: var(--olive-dark);
    }

    .pay-button:disabled {
        opacity: .4;
        cursor: not-allowed;
    }

    .empty-cart,
    .empty-product {
        padding: 28px 10px;
        text-align: center;
        color: var(--muted);
        font-size: 11px;
    }

    .empty-cart-icon {
        font-size: 25px;
        margin-bottom: 8px;
    }

    .table-wrapper {
        margin-top: 10px;
    }

    .table-wrapper input {
        margin-top: 6px;
    }

    .hidden-pos {
        display: none !important;
    }

    @media(max-width: 1100px) {
        .pos-layout {
            grid-template-columns: minmax(0, 1.4fr) minmax(300px, .9fr);
        }

        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 800px) {
        .pos-layout {
            grid-template-columns: 1fr;
        }

        .order-panel {
            position: static;
        }

        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 480px) {
        .pos-heading {
            flex-direction: column;
        }

        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
        }

        .product-image,
        .product-image-placeholder {
            height: 90px;
        }

        .product-body {
            padding: 8px;
        }

        .product-price {
            font-size: 10px;
        }

        .add-product {
            padding: 7px;
            font-size: 9px;
        }

        .catalog-footer {
            flex-direction: column;
            align-items: start;
        }
    }
</style>
@endpush

@section('content')

<div class="pos-page">

    <!-- JUDUL HALAMAN -->
    <div class="pos-heading">
        <div>
            <h1>Transaksi kasir</h1>
            <p>Pilih menu, periksa pesanan, lalu selesaikan pembayaran.</p>
        </div>

        <div class="shift-badge">
            Sif pagi · {{ auth()->user()->name }}
        </div>
    </div>

    <div class="pos-layout">

        <!-- KATALOG PRODUK -->
        <section>

            <div class="catalog-search">
                <i data-lucide="search" class="search-icon"></i>
                <input type="search"
                       id="searchMenu"
                       placeholder="Cari nama menu...">
            </div>

            <!-- FILTER KATEGORI -->
            <div class="category-list">

                <button type="button"
                        class="category-filter active"
                        data-category="all">
                    Semua menu
                </button>

                @foreach($categories as $category)
                    <button type="button"
                            class="category-filter"
                            data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach

            </div>

            <!-- GRID PRODUK -->
            <div class="product-grid" id="productGrid">

                @foreach($menus as $menu)

                    <article
                        class="product-card"
                        data-id="{{ $menu->id }}"
                        data-name="{{ $menu->name }}"
                        data-price="{{ $menu->price }}"
                        data-stock="{{ $menu->stock }}"
                        data-category="{{ $menu->category_id }}"
                        data-description="{{ $menu->description ?? '' }}"
                        data-image="{{ $menu->image ? asset('storage/'.$menu->image) : '' }}"
                    >

                        @if($menu->image)
                            <img
                                src="{{ asset('storage/'.$menu->image) }}"
                                alt="{{ $menu->name }}"
                                class="product-image"
                                loading="lazy">
                        @else
                            <div class="product-image-placeholder">☕</div>
                        @endif

                        <div class="product-body">

                            <h3 class="product-name">
                                {{ $menu->name }}
                            </h3>

                            <p class="product-description">
                                {{ $menu->description ?: 'Menu pilihan Kopi Kita.' }}
                            </p>

                            <p class="product-stock">
                                Tersedia {{ $menu->stock }} porsi
                            </p>

                            <div class="product-footer">

                                <span class="product-price">
                                    Rp{{ number_format($menu->price, 0, ',', '.') }}
                                </span>

                                <button type="button"
                                        class="add-product"
                                        onclick="addToCart(this)">
                                    + Tambah
                                </button>

                            </div>

                        </div>
                    </article>

                @endforeach

            </div>

            <div id="emptyProduct" class="empty-product hidden-pos">
                Menu tidak ditemukan.
            </div>

            <!-- PAGINATION -->
            <div class="catalog-footer">

                <span id="paginationInfo"
                      class="text-xs text-gray-500">
                    Menampilkan 0 menu
                </span>

                <div class="pagination-buttons">
                    <button type="button" id="previousPage">
                        Sebelumnya
                    </button>

                    <button type="button" id="nextPage">
                        Berikutnya
                    </button>
                </div>

            </div>

            <div class="stock-notice">
                <i data-lucide="info"
                   style="width:13px;display:inline;vertical-align:middle"></i>
                Stok menu diperbarui setelah pembayaran berhasil.
            </div>

        </section>

        <!-- PANEL KERANJANG -->
        <aside class="order-panel">

            <div class="order-header">
                <h3>Pesanan saat ini</h3>

                <button type="button"
                        class="clear-cart"
                        onclick="clearCart()">
                    Kosongkan
                </button>
            </div>

            <!-- LAYANAN -->
            <div class="service-options">

                <label>
                    <input type="radio"
                           name="service_type"
                           value="dine_in">

                    <span>Makan di tempat</span>
                </label>

                <label>
                    <input type="radio"
                           name="service_type"
                           value="takeaway"
                           checked>

                    <span>Bawa pulang</span>
                </label>

            </div>

            <!-- INVOICE -->
            <div class="invoice-info">
                <span class="invoice-number" id="invoicePreview">
                    #Pesanan baru
                </span>

                <span id="orderTime">
                    {{ now()->format('H:i') }}
                </span>
            </div>

            <!-- NOMOR MEJA -->
            <div id="tableNumberWrapper" class="table-wrapper hidden-pos">
                <label class="text-xs font-semibold">Nomor meja</label>
                <input type="text"
                       id="tableNumber"
                       class="note-input"
                       placeholder="Contoh: Meja 04">
            </div>

            <!-- ITEM KERANJANG -->
            <div class="cart-list" id="cartItems">

                <div class="empty-cart">
                    <div class="empty-cart-icon">☕</div>
                    Belum ada menu dipilih.
                </div>

            </div>

            <!-- CATATAN -->
            <div class="mt-3">
                <input type="text"
                       id="orderNote"
                       class="note-input"
                       maxlength="255"
                       placeholder="✎ Catatan: kopi sedikit es">
                <p class="text-xs text-gray-400 mt-1">
                    Catatan hanya untuk tampilan pesanan saat ini.
                </p>
            </div>

            <!-- RINGKASAN -->
            <div class="summary">

                <div class="summary-row">
                    <span class="summary-label" id="itemSummary">
                        Subtotal · 0 item
                    </span>

                    <span id="subtotalDisplay">Rp0</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Pajak (10%)</span>
                    <span id="taxDisplay">Rp0</span>
                </div>

                <div class="summary-row total-row">
                    <span>Total pembayaran</span>
                    <span class="total-value" id="totalDisplay">
                        Rp0
                    </span>
                </div>

            </div>

            <!-- METODE PEMBAYARAN -->
            <label class="payment-label">Metode pembayaran</label>

            <div class="payment-options">

                <label>
                    <input type="radio"
                           name="payment_method"
                           value="cash"
                           checked>

                    <span>Tunai</span>
                </label>

                <label>
                    <input type="radio"
                           name="payment_method"
                           value="qris">

                    <span>QRIS</span>
                </label>

            </div>

            <!-- PEMBAYARAN TUNAI -->
            <div id="cashWrapper">

                <label class="payment-label">
                    Uang diterima
                </label>

                <input type="number"
                       id="paidAmount"
                       class="payment-input"
                       min="0"
                       placeholder="Masukkan nominal">

                <div class="change-row">
                    <span class="summary-label">Kembalian</span>

                    <span id="changeDisplay" class="change-value">
                        Rp0
                    </span>
                </div>

            </div>

            <!-- INFORMASI QRIS -->
            <div id="qrisInfo"
                 class="hidden-pos text-xs text-[#626F4B] bg-[#EEF1E8]
                        rounded-lg p-3 mt-3">
                Pastikan pembayaran QRIS sudah diterima sebelum
                menyelesaikan transaksi.
            </div>

            <!-- TOMBOL BAYAR -->
            <button type="button"
                    id="checkoutButton"
                    class="pay-button"
                    onclick="checkout()"
                    disabled>
                Bayar Rp0
            </button>

            <p class="text-center text-xs text-gray-400 mt-2">
                Struk tersedia setelah pembayaran selesai.
            </p>

        </aside>

    </div>

</div>

<!-- FORM PENGIRIMAN TRANSAKSI -->
<form id="transactionForm"
      action="{{ route('transactions.store') }}"
      method="POST"
      class="hidden">
    @csrf
    <div id="transactionInputs"></div>
</form>

@endsection


@push('scripts')
<script>
    // ==========================================
    // STATE TRANSAKSI
    // ==========================================

    let cart = [];
    let currentPage = 1;
    const perPage = 6;

    let selectedCategory = 'all';
    let searchKeyword = '';

    const products = Array.from(
        document.querySelectorAll('.product-card')
    );

    const rupiah = (value) => {
        return 'Rp' + Number(value).toLocaleString('id-ID');
    };

    // ==========================================
    // FILTER DAN PAGINATION
    // ==========================================

    function getFilteredProducts() {
        return products.filter(card => {
            const name = card.dataset.name.toLowerCase();
            const category = card.dataset.category;

            const matchName = name.includes(searchKeyword);

            const matchCategory =
                selectedCategory === 'all' ||
                category === selectedCategory;

            return matchName && matchCategory;
        });
    }

    function renderProducts() {
        const filtered = getFilteredProducts();

        const totalPages = Math.max(
            1,
            Math.ceil(filtered.length / perPage)
        );

        currentPage = Math.min(currentPage, totalPages);

        const start = (currentPage - 1) * perPage;
        const end = start + perPage;

        products.forEach(card => {
            card.classList.add('hidden-pos');
        });

        filtered.slice(start, end).forEach(card => {
            card.classList.remove('hidden-pos');
        });

        document.getElementById('emptyProduct')
            .classList.toggle('hidden-pos', filtered.length > 0);

        document.getElementById('paginationInfo').textContent =
            filtered.length === 0
                ? 'Tidak ada menu ditemukan'
                : `Menampilkan ${start + 1}–${Math.min(end, filtered.length)} dari ${filtered.length} menu`;

        document.getElementById('previousPage').disabled =
            currentPage <= 1;

        document.getElementById('nextPage').disabled =
            currentPage >= totalPages;
    }

    document.getElementById('searchMenu')
        .addEventListener('input', function () {
            searchKeyword = this.value.toLowerCase().trim();
            currentPage = 1;
            renderProducts();
        });

    document.querySelectorAll('.category-filter')
        .forEach(button => {
            button.addEventListener('click', function () {

                document.querySelectorAll('.category-filter')
                    .forEach(item => item.classList.remove('active'));

                this.classList.add('active');

                selectedCategory = this.dataset.category;
                currentPage = 1;

                renderProducts();
            });
        });

    document.getElementById('previousPage')
        .addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderProducts();
            }
        });

    document.getElementById('nextPage')
        .addEventListener('click', () => {
            const total = getFilteredProducts().length;

            if (currentPage < Math.ceil(total / perPage)) {
                currentPage++;
                renderProducts();
            }
        });

    // ==========================================
    // KERANJANG
    // ==========================================

    function addToCart(button) {

        const card = button.closest('.product-card');

        const id = Number(card.dataset.id);
        const stock = Number(card.dataset.stock);

        const item = cart.find(product => product.id === id);

        if (item) {
            if (item.quantity >= stock) {
                alert('Stok produk tidak mencukupi.');
                return;
            }

            item.quantity++;
        } else {
            cart.push({
                id: id,
                name: card.dataset.name,
                price: Number(card.dataset.price),
                stock: stock,
                quantity: 1
            });
        }

        renderCart();
    }

    function updateQuantity(id, change) {

        const item = cart.find(product => product.id === id);

        if (!item) return;

        const quantity = item.quantity + change;

        if (quantity <= 0) {
            cart = cart.filter(product => product.id !== id);
        } else if (quantity > item.stock) {
            alert('Jumlah melebihi stok tersedia.');
            return;
        } else {
            item.quantity = quantity;
        }

        renderCart();
    }

    function removeItem(id) {
        cart = cart.filter(product => product.id !== id);
        renderCart();
    }

    function clearCart() {

        if (cart.length === 0) return;

        if (!confirm('Kosongkan seluruh pesanan?')) return;

        cart = [];

        document.getElementById('orderNote').value = '';
        document.getElementById('paidAmount').value = '';

        renderCart();
    }

    // ==========================================
    // PERHITUNGAN
    // ==========================================

    function calculateTotal() {

        const subtotal = cart.reduce(
            (sum, item) => sum + item.price * item.quantity,
            0
        );

        const tax = Math.round(subtotal * 0.10);

        return {
            subtotal,
            tax,
            total: subtotal + tax
        };
    }

    // ==========================================
    // RENDER KERANJANG
    // ==========================================

    function renderCart() {

        const container = document.getElementById('cartItems');

        container.innerHTML = '';

        if (cart.length === 0) {

            const empty = document.createElement('div');

            empty.className = 'empty-cart';
            empty.innerHTML = `
                <div class="empty-cart-icon">☕</div>
                Belum ada menu dipilih.
            `;

            container.appendChild(empty);

        } else {

            cart.forEach(item => {

                const row = document.createElement('div');
                row.className = 'cart-row';

                const top = document.createElement('div');
                top.className = 'cart-row-top';

                const name = document.createElement('span');
                name.className = 'cart-name';
                name.textContent = item.name;

                const remove = document.createElement('button');
                remove.type = 'button';
                remove.className = 'cart-remove';
                remove.textContent = '×';
                remove.title = 'Hapus menu';

                remove.addEventListener('click', () => {
                    removeItem(item.id);
                });

                top.append(name, remove);

                const bottom = document.createElement('div');
                bottom.className = 'cart-row-bottom';

                const price = document.createElement('span');
                price.className = 'cart-unit-price';
                price.textContent = rupiah(item.price);

                const quantity = document.createElement('div');
                quantity.className = 'quantity-control';

                const minus = document.createElement('button');
                minus.type = 'button';
                minus.textContent = '−';

                minus.addEventListener('click', () => {
                    updateQuantity(item.id, -1);
                });

                const count = document.createElement('span');
                count.textContent = item.quantity;

                const plus = document.createElement('button');
                plus.type = 'button';
                plus.textContent = '+';

                plus.addEventListener('click', () => {
                    updateQuantity(item.id, 1);
                });

                quantity.append(minus, count, plus);

                const subtotal = document.createElement('span');
                subtotal.className = 'cart-subtotal';
                subtotal.textContent =
                    rupiah(item.price * item.quantity);

                bottom.append(price, quantity, subtotal);

                row.append(top, bottom);

                container.appendChild(row);
            });
        }

        const totals = calculateTotal();

        const itemCount = cart.reduce(
            (sum, item) => sum + item.quantity,
            0
        );

        document.getElementById('itemSummary').textContent =
            `Subtotal · ${itemCount} item`;

        document.getElementById('subtotalDisplay').textContent =
            rupiah(totals.subtotal);

        document.getElementById('taxDisplay').textContent =
            rupiah(totals.tax);

        document.getElementById('totalDisplay').textContent =
            rupiah(totals.total);

        document.getElementById('checkoutButton').textContent =
            '✓ Bayar ' + rupiah(totals.total);

        document.getElementById('checkoutButton').disabled =
            cart.length === 0;

        renderPayment();
    }

    // ==========================================
    // PEMBAYARAN
    // ==========================================

    function renderPayment() {

        const method = document.querySelector(
            'input[name="payment_method"]:checked'
        ).value;

        const total = calculateTotal().total;

        const cashWrapper = document.getElementById('cashWrapper');
        const qrisInfo = document.getElementById('qrisInfo');

        const paidInput = document.getElementById('paidAmount');

        if (method === 'qris') {

            cashWrapper.classList.add('hidden-pos');
            qrisInfo.classList.remove('hidden-pos');

            document.getElementById('changeDisplay')
                .textContent = rupiah(0);

        } else {

            cashWrapper.classList.remove('hidden-pos');
            qrisInfo.classList.add('hidden-pos');

            const paid = Number(paidInput.value) || 0;

            const change = Math.max(0, paid - total);

            document.getElementById('changeDisplay')
                .textContent = rupiah(change);
        }
    }

    document.getElementById('paidAmount')
        .addEventListener('input', renderPayment);

    document.querySelectorAll('input[name="payment_method"]')
        .forEach(input => {
            input.addEventListener('change', renderPayment);
        });

    // ==========================================
    // JENIS LAYANAN
    // ==========================================

    document.querySelectorAll('input[name="service_type"]')
        .forEach(input => {

            input.addEventListener('change', function () {

                const wrapper = document.getElementById(
                    'tableNumberWrapper'
                );

                if (this.value === 'dine_in') {
                    wrapper.classList.remove('hidden-pos');
                } else {
                    wrapper.classList.add('hidden-pos');

                    document.getElementById('tableNumber').value = '';
                }

            });
        });

    // ==========================================
    // NOMOR PESANAN SEMENTARA
    // ==========================================

    function generateInvoicePreview() {

        const date = new Date();

        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = String(date.getFullYear()).slice(-2);

        const random = Math.floor(100 + Math.random() * 900);

        document.getElementById('invoicePreview').textContent =
            `#KK-${day}${month}${year}-${random}`;
    }

    // ==========================================
    // CHECKOUT
    // ==========================================

    function checkout() {

        if (cart.length === 0) {
            alert('Keranjang masih kosong.');
            return;
        }

        const service = document.querySelector(
            'input[name="service_type"]:checked'
        ).value;

        const payment = document.querySelector(
            'input[name="payment_method"]:checked'
        ).value;

        const table = document.getElementById('tableNumber')
            .value.trim();

        if (service === 'dine_in' && !table) {
            alert('Masukkan nomor meja terlebih dahulu.');
            return;
        }

        const totals = calculateTotal();

        let paid = 0;

        if (payment === 'cash') {

            paid = Number(
                document.getElementById('paidAmount').value
            ) || 0;

            if (paid < totals.total) {
                alert('Uang pembayaran masih kurang.');
                return;
            }

        } else {

            paid = totals.total;

            if (!confirm(
                'Pastikan pembayaran QRIS sebesar ' +
                rupiah(totals.total) +
                ' sudah diterima. Lanjutkan?'
            )) {
                return;
            }
        }

        if (!confirm(
            'Selesaikan transaksi sebesar ' +
            rupiah(totals.total) + '?'
        )) {
            return;
        }

        const form = document.getElementById('transactionForm');

        const inputs = document.getElementById('transactionInputs');

        inputs.innerHTML = '';

        function createInput(name, value) {

            const input = document.createElement('input');

            input.type = 'hidden';
            input.name = name;
            input.value = value;

            inputs.appendChild(input);
        }

        cart.forEach((item, index) => {

            createInput(
                `items[${index}][menu_id]`,
                item.id
            );

            createInput(
                `items[${index}][quantity]`,
                item.quantity
            );
        });

        createInput('paid_amount', paid);
        createInput('payment_method', payment);
        createInput('service_type', service);
        createInput('table_number', table);

        form.submit();
    }

    // ==========================================
    // INISIALISASI
    // ==========================================

    renderProducts();
    renderCart();
    generateInvoicePreview();

</script>
@endpush