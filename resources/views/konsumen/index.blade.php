@extends('layout')

@section('content')

<style>
    :root {
        --navy: #0f172a;
        --border: #e5e7eb;
        --muted: #64748b;
    }

    /* Card */
    .glass-card {
        background: #ffffff;
        border-radius: 18px;
        padding: 28px;
        box-shadow: 0 18px 30px rgba(15,23,42,.08);
    }

    .page-title {
        font-weight: 800;
        color: var(--navy);
    }

    /* Button tambah */
    .btn-navy {
        background: var(--navy);
        color: #fff;
        border-radius: 12px;
        padding: 8px 18px;
        font-weight: 600;
    }

    .btn-navy:hover {
        background: #020617;
        color: #fff;
    }

    /* Search */
    .search-box input {
        border-radius: 12px 0 0 12px;
    }

    .search-box button {
        border-radius: 0 12px 12px 0;
    }

    /* Table */
    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table thead th {
        font-size: .75rem;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: var(--muted);
        border: none;
        padding-bottom: 8px;
    }

    .table tbody tr {
        background: #fff;
        box-shadow: 0 6px 14px rgba(15,23,42,.05);
        transition: .2s ease;
    }

    .table tbody tr:hover {
        transform: translateY(-2px);
    }

    .table td {
        border: none;
        padding: 14px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .kode {
        font-weight: 700;
        color: #2563eb;
    }

    /* Action */
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: .2s ease;
        border: none;
    }

    .btn-edit {
        background: #facc15;
        color: #78350f;
    }

    .btn-delete {
        border: 1px solid #ef4444;
        color: #ef4444;
        background: transparent;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: #fff;
    }
</style>

<div class="glass-card">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="page-title mb-0">Pengelolaan Data Konsumen</h4>
        <a href="{{ route('konsumen.create') }}" class="btn btn-navy">
            + Tambah Konsumen
        </a>
    </div>

    <!-- SEARCH -->
    <form action="{{ route('konsumen.index') }}" method="GET" class="mb-4">
        <div class="input-group search-box" style="max-width: 420px;">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Cari nama / kota / email konsumen..."
                   value="{{ request('search') }}">
            <button class="btn btn-dark">Cari</button>

            @if(request('search'))
                <a href="{{ route('konsumen.index') }}" class="btn btn-outline-danger">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- TABLE -->
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Phone</th>
                <th>Email</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($data as $k)
            <tr>
                <td class="kode">{{ $k->kd_kons }}</td>
                <td class="fw-semibold">{{ $k->nm_kons }}</td>
                <td>{{ $k->alm_kons }}</td>
                <td class="fw-semibold">{{ $k->kota_kons }}</td>
                <td>{{ $k->phone }}</td>
                <td>{{ $k->email }}</td>
                <td class="text-center">
                    <a href="{{ route('konsumen.edit', $k->kd_kons) }}"
                       class="btn-icon btn-edit">✏️</a>

                    <form action="{{ route('konsumen.destroy', $k->kd_kons) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn-icon btn-delete">🗑️</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    Belum ada data konsumen.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</div>

@if(session('success'))
<div id="successAlert" class="alert alert-success mt-3">
    {{ session('success') }}
</div>

<script>
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.transition = 'opacity .5s';
        alert.style.opacity = 0;
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>
@endif

@endsection
