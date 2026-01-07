@extends('layout')
@section('content')

<style>
:root {
    --dark: #0f172a;
    --muted: #64748b;
}
.glass-card {
    background: #fff;
    border-radius: 22px;
    padding: 28px;
    box-shadow: 0 20px 40px rgba(15,23,42,.08);
}
.page-title {
    font-weight: 800;
    font-size: 20px;
    color: var(--dark);
    margin-bottom: 20px;
}
.form-label {
    font-size: 13px;
    color: var(--muted);
    font-weight: 600;
}
.table {
    border-collapse: separate;
    border-spacing: 0 12px;
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
}
.table td {
    border: none;
    padding: 16px;
}
.stock-empty {
    color: #dc2626;
    font-weight: 700;
}
.btn-dark {
    background: var(--dark);
    color: #fff;
    border-radius: 14px;
    padding: 10px 20px;
    font-weight: 600;
}
</style>

<div class="glass-card">
    <div class="page-title">Transaksi Penjualan</div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('jual.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="form-label">Konsumen</label>
            <select name="kd_kons" class="form-select">
                @foreach($konsumen as $k)
                    <option value="{{ $k->kd_kons }}">{{ $k->nm_kons }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 fw-bold">Daftar Barang</div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Pilih</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Qty</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($barang as $b)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox"
                                   onclick="enableInput('{{ $b->kd_brg }}')"
                                    {{ $b->stok == 0 ? 'disabled' : '' }}>

                        </td>
                        <td>{{ $b->nm_brg }}</td>
                        <td>Rp {{ number_format($b->harga_jual) }}</td>
                        <td class="text-center {{ $b->stok == 0 ? 'stock-empty' : '' }}">
                          {{ $b->stok }}
                        </td>

                        <td class="text-center">
                            <input type="number"
                                   name="items[{{ $b->kd_brg }}][jml]"
                                   id="jml_{{ $b->kd_brg }}"
                                   class="form-control form-control-sm text-center"
                                   style="max-width:80px"
                                   min="1"
                                   max="{{ $b->stok }}"
                                   placeholder="qty"
                                   disabled>

                            <input type="hidden" name="items[{{ $b->kd_brg }}][kd_brg]" value="{{ $b->kd_brg }}">
                            <input type="hidden" name="items[{{ $b->kd_brg }}][harga_jual]" value="{{ $b->harga_jual }}">
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <button class="btn btn-dark mt-3">Simpan Transaksi</button>
    </form>
</div>

<script>
function enableInput(kd) {
    const el = document.getElementById('jml_' + kd);
    el.disabled = !el.disabled;

    if (!el.disabled) {
        el.focus();
    } else {
        el.value = '';
    }
}
</script>


@endsection