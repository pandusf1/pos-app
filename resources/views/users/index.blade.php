@extends('layout')

@section('content')

<style>
/* ================= CARD UTAMA ================= */
.glass-card {
    background: #ffffff;
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(15,23,42,.08);
}

/* ================= HEADER ================= */
.page-title {
    font-weight: 700;
    font-size: 20px;
}

.page-subtitle {
    font-size: 13px;
    color: #6b7280;
}

/* ================= SEARCH ================= */
.search-box {
    max-width: 420px;
}

.search-box input {
    border-radius: 12px 0 0 12px;
    border: 1px solid #e5e7eb;
}

.search-box button {
    border-radius: 0 12px 12px 0;
    background: #111827;
    color: #fff;
    border: none;
}

/* ================= TABLE FLOATING ================= */
.table {
    border-collapse: separate;
    border-spacing: 0 14px;
}

.table thead th {
    border: none;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #64748b;
    background: transparent;
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

/* ================= AKSI ================= */
.action-group {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px; /* kotak rounded */
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    padding: 0;
    cursor: pointer;
    transition: .15s;
}

/* EDIT */
.btn-edit {
    background-color: #fbbf24;
    border: none;
    color: #000;
}

.btn-edit:hover {
    opacity: .85;
}

/* DELETE */
.btn-delete {
    background-color: #fff;
    border: 1.4px solid #ef4444;
    color: #9ca3af;
}

.btn-delete:hover {
    background-color: #ef4444;
    color: #fff;
}
</style>

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <div class="page-title">Pengelolaan Data User</div>
        <div class="page-subtitle">Manajemen akun pengguna sistem</div>
    </div>

    <a href="{{ route('users.create') }}"
       class="btn btn-dark rounded-pill px-4">
        + Tambah User
    </a>
</div>

<!-- ================= CARD ================= -->
<div class="glass-card">

    <!-- SEARCH -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-4">
        <div class="input-group search-box">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari berdasarkan nama user..."
                   value="{{ request('search') }}">
            <button class="btn">Cari</button>
        </div>
    </form>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-center" width="140">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse ($users as $u)
                <tr>
                    <td class="fw-semibold">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role }}</td>
                    <td class="text-center">
                        <div class="action-group">

                            <a href="{{ route('users.edit', $u->id) }}"
                               class="action-btn btn-edit"
                               title="Edit">
                                ✏️
                            </a>

                            <form action="{{ route('users.destroy', $u->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="action-btn btn-delete"
                                        title="Hapus">
                                    🗑️
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        Tidak ada data user
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
