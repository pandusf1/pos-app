<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kejora Mart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f7f7f9;
            margin: 0;
        }

        /* SIDEBAR */
        .sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    background: #111827;
    color: #fff;
    padding: 22px 16px;

    overflow-y: auto;   /* ⬅️ INI KUNCI */
}


        .brand {
            color: #facc15;
            margin-bottom: 36px;
        }

        .brand h3 {
            font-weight: 800;
            margin-bottom: 4px;
        }

        .brand span {
            font-size: 13px;
            opacity: .9;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 12px;
            color: #d1d5db;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 6px;
            transition: .2s;
        }

        .sidebar a:hover {
            background: rgba(250, 204, 21, .15);
            color: #facc15;
        }

        .sidebar a.active {
            background: #facc15;
            color: #111827;
            font-weight: 700;
        }

        .sidebar .section {
            font-size: 11px;
            text-transform: uppercase;
            color: #9ca3af;
            margin: 18px 8px 8px;
        }

        /* CONTENT */
        .content {
            margin-left: 240px;
            padding: 28px;
        }

        .logout-btn {
            margin-top: 30px;
            background: transparent;
            border: 1px solid #facc15;
            color: #facc15;
            width: 100%;
            padding: 10px;
            border-radius: 12px;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #facc15;
            color: #111827;
        }
    </style>
    
    <style>
:root {
    --dark: #0f172a;
    --muted: #64748b;
    --border: #e5e7eb;
}

/* CARD */
.glass-card {
    background: #fff;
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(15,23,42,.08);
}

/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.page-title {
    font-weight: 800;
    font-size: 20px;
    color: var(--dark);
}

/* BUTTON */
.btn-dark-rounded {
    background: var(--dark);
    color: #fff;
    border-radius: 14px;
    padding: 10px 18px;
    font-weight: 600;
}

.btn-dark-rounded:hover {
    background: #020617;
    color: #fff;
}

/* SEARCH */
.search-box {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
}

.search-box input {
    border-radius: 14px;
    padding: 10px 14px;
    max-width: 320px;
}

/* TABLE */
.table {
    border-collapse: separate;
    border-spacing: 0 14px;
}

.table thead th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--muted);
    border: none;
}

.table tbody tr {
    background: #fff;
    box-shadow: 0 8px 20px rgba(15,23,42,.06);
    transition: .25s ease;
}

.table tbody tr:hover {
    transform: translateY(-3px);
}

.table td {
    border: none;
    padding: 16px;
    vertical-align: middle;
}

/* IMAGE */
.img-barang {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid var(--border);
}

/* AKSI */
.action-group {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.btn-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    transition: .2s;
}

/* edit */
.btn-edit {
    background: #facc15;
    color: #78350f;
}

/* delete */
.btn-delete {
    border: 1.4px solid #ef4444;
    color: #ef4444;
    background: transparent;
}

.btn-delete:hover {
    background: #ef4444;
    color: #fff;
}
.brand {
    margin-bottom: 12px;
}

.brand-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.brand-row img {
    width: 42px;
    height: 80px;
    object-fit: contain;
}

.brand-row h5 {
    margin: 0;
    font-weight: 800;
    color: #facc15;
}

.brand-sub {
    display: block;
    margin-left: 8px; /* ← KUNCI UTAMA */
    font-size: 12px;
    color: #e5e7eb;
    opacity: 0.9;
}

</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
<div class="brand">
    <div class="brand-row">
        <img src="{{ asset('logo.png') }}" alt="Logo Kejora Mart">
        <h5>Kejora Mart</h5>
    </div>
    <span class="brand-sub">
        Sistem Kasir & Manajemen Toko
    </span>
</div>


    <a href="{{ route('dashboard') }}"
       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        🏠 Dashboard
    </a>

    <div class="section">Manajemen Akses</div>
    <a href="{{ route('users.index') }}"
       class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        👤 User
    </a>

    <div class="section">Transaksi</div>
    <a href="{{ route('jual.index') }}"
       class="{{ request()->routeIs('jual.*') ? 'active' : '' }}">
        🛍️ Penjualan
    </a>
    <a href="{{ route('beli.index') }}"
       class="{{ request()->routeIs('beli.*') ? 'active' : '' }}">
        📥 Pembelian
    </a>

    <a href="{{ route('retur.penjualan.index') }}"
    class="{{ request()->routeIs('retur.penjualan.*') ? 'active' : '' }}">
        🔄 Retur Penjualan
    </a>

    <a href="{{ route('retur.pembelian.index') }}"
    class="{{ request()->routeIs('retur.pembelian.*') ? 'active' : '' }}">
        🔁 Retur Pembelian
    </a>

    <div class="section">Master Data</div>
    <a href="{{ route('barang.index') }}"
       class="{{ request()->routeIs('barang.*') ? 'active' : '' }}">
        📦 Barang
    </a>
    <a href="{{ route('konsumen.index') }}"
       class="{{ request()->routeIs('konsumen.*') ? 'active' : '' }}">
        👥 Konsumen
    </a>
    <a href="{{ route('supplier.index') }}"
       class="{{ request()->routeIs('supplier.*') ? 'active' : '' }}">
        🚚 Supplier
    </a>

    <div class="section">Laporan</div>
    <a href="{{ route('laporan.penjualan.index') }}"
       class="{{ request()->routeIs('laporan.penjualan.*') ? 'active' : '' }}">
        📕 Laporan Penjualan
    </a>
    <a href="{{ route('laporan.pembelian.index') }}"
       class="{{ request()->routeIs('laporan.pembelian.*') ? 'active' : '' }}">
        📗 Laporan Pembelian
    </a>
    <a href="{{ route('laporan.barang.index') }}"
       class="{{ request()->routeIs('laporan.barang.*') ? 'active' : '' }}">
        📘Laporan Barang
    </a>
    <a href="{{ route('laporan.konsumen.index') }}"
       class="{{ request()->routeIs('laporan.konsumen.*') ? 'active' : '' }}">
        📙Laporan Konsumen
    </a>
    <a href="{{ route('laporan.supplier.index') }}"
       class="{{ request()->routeIs('laporan.supplier.*') ? 'active' : '' }}">
        📓Laporan Supplier
    </a>
    <a href="{{ route('laporan.retur.pembelian') }}"
    class="{{ request()->routeIs('laporan.retur.pembelian') ? 'active' : '' }}">
        📔 Laporan Retur Pembelian
    </a>
    <a href="{{ route('laporan.retur.penjualan') }}"
    class="{{ request()->routeIs('laporan.retur.penjualan') ? 'active' : '' }}">
        📕 Laporan Retur Penjualan
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout-btn">Logout</button>
    </form>
</div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
