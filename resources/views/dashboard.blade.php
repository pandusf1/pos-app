@extends('layout')

@section('content')

<style>
body {
    background: #f4f6f9;
}

/* HERO */
.dashboard-hero {
    background: #ffffffff;
    border-radius: 26px;
    padding: 36px;
    margin-bottom: 32px;
    box-shadow: 0 12px 30px rgba(0,0,0,.06);
}

.dashboard-hero h2 {
    font-weight: 800;
    margin-bottom: 4px;
}

.dashboard-hero span {
    font-size: 14px;
    color: #64748b;
}

/* SECTION */
.section-panel {
    background: #ffffff;
    border-radius: 28px;
    padding: 28px;
    margin-bottom: 32px;
    box-shadow: 0 14px 34px rgba(0,0,0,.07);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
}

.section-icon {
    width: 46px;
    height: 46px;
    border-radius: 16px;
    background: linear-gradient(135deg, #a78bfa, #edcc3aff);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
}

.section-title {
    font-weight: 800;
    font-size: 16px;
    color: #0f172a;
}

/* MENU CARD */
.menu-card {
    background: #f9fafb;
    border-radius: 22px;
    padding: 22px;
    height: 100%;
    transition: all .25s ease;
}

.menu-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(0,0,0,.08);
}

.menu-card h6 {
    font-weight: 700;
    margin-bottom: 6px;
}

.menu-card p {
    font-size: 13px;
    color: #64748b;
}

.menu-card a {
    font-size: 13px;
    font-weight: 600;
    color: #7c3aed;
    text-decoration: none;
}
</style>

<div class="container-fluid px-4">

    <!-- HERO -->
    <div class="mb-4">
    <h4 class="fw-bold mb-0">Dashboard</h4>
    <span class="text-muted small">Overview</span>
</div>

</div>


    <!-- MANAJEMEN AKSES -->
    <div class="section-panel">
        <div class="section-header">
            <div class="section-icon">📲</div>
            <div class="section-title">Manajemen Akses</div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="menu-card">
                    <h6>Master Users</h6>
                    <p>Manajemen akun & role</p>
                    <a href="{{ route('users.index') }}">Kelola →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- TRANSAKSI -->
    <div class="section-panel">
        <div class="section-header">
            <div class="section-icon">⚡</div>
            <div class="section-title">Transaksi</div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="menu-card">
                    <h6>Penjualan</h6>
                    <p>Transaksi kasir & cetak struk</p>
                    <a href="{{ route('jual.index') }}">Masuk →</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="menu-card">
                    <h6>Pembelian</h6>
                    <p>Input pembelian barang</p>
                    <a href="{{ route('beli.index') }}">Masuk →</a>
                </div>
            </div>

            <!-- Retur Penjualan -->
        <div class="col-md-6">
            <div class="menu-card">
                <h6>Retur Penjualan</h6>
                <p>Pengembalian barang dari konsumen</p>
                <a href="{{ route('retur.penjualan.index') }}">Masuk →</a>
            </div>
        </div>

        <!-- Retur Pembelian -->
        <div class="col-md-6">
            <div class="menu-card">
                <h6>Retur Pembelian</h6>
                <p>Pengembalian barang ke supplier</p>
                <a href="{{ route('retur.pembelian.index') }}">Masuk →</a>
            </div>
        </div>

        </div>
    </div>

    <!-- MASTER DATA -->
    <div class="section-panel">
        <div class="section-header">
            <div class="section-icon">📦</div>
            <div class="section-title">Master Data</div>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="menu-card">
                    <h6>Barang</h6>
                    <p>Stok & harga</p>
                    <a href="{{ route('barang.index') }}">Kelola →</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="menu-card">
                    <h6>Konsumen</h6>
                    <p>Data pelanggan</p>
                    <a href="{{ route('konsumen.index') }}">Kelola →</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="menu-card">
                    <h6>Supplier</h6>
                    <p>Data pemasok</p>
                    <a href="{{ route('supplier.index') }}">Kelola →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- LAPORAN -->
    <div class="section-panel">
        <div class="section-header">
            <div class="section-icon">📋</div>
            <div class="section-title">Laporan</div>
        </div>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="menu-card">
                    <h6>Penjualan</h6>
                    <a href="{{ route('laporan.penjualan.index') }}">Lihat →</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="menu-card">
                    <h6>Pembelian</h6>
                    <a href="{{ route('laporan.pembelian.index') }}">Lihat →</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="menu-card">
                    <h6>Barang</h6>
                    <a href="{{ route('laporan.barang.index') }}">Lihat →</a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="menu-card">
                    <h6>Konsumen</h6>
                    <a href="{{ route('laporan.konsumen.index') }}">Lihat →</a>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="menu-card">
                    <h6>Retur Pembelian</h6>
                    <a href="{{ route('laporan.retur.pembelian') }}">
                        Lihat →
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="menu-card">
                    <h6>Retur Penjualan</h6>
                    <a href="{{ route('laporan.retur.penjualan') }}">
                        Lihat →
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection
