@extends('layout')

@section('content')
<div class="glass-card">
    <h1 class="page-title mb-3">Retur Penjualan</h1>

    <div id="form-retur">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        {{-- PILIH NOTA --}}
        <div class="card mb-3">
            <div class="card-body">
            <label class="form-label fw-bold">No Penjualan</label>
            <select id="no_jual" class="form-control">
                <option value="">-- Pilih Nota --</option>
                @foreach($penjualan as $j)
                    <option value="{{ $j->no_jual }}"
                        {{ !$j->masih_bisa_retur ? 'disabled' : '' }}>
                        {{ $j->no_jual }} | {{ $j->tgl_jual }}
                        {{ !$j->masih_bisa_retur ? ' (FULL RETUR)' : '' }}
                    </option>
                @endforeach
            </select>
            </div>
        </div>

        {{-- DETAIL --}}
        @foreach($penjualan as $jual)
        <div class="card mb-3 detail-jual shadow-sm" id="detail-{{ $jual->no_jual }}" style="display:none;">
        <div class="card-header bg-white fw-semibold">
                No Penjualan: {{ $jual->no_jual }}
            </div>
            <div class="card-body p-2">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="15%">Kode Barang</th>
                            <th width="20%" class="text-end">Harga</th>
                            <th width="15%" class="text-center">Qty Jual</th>
                            <th width="20%" class="text-center">Sudah Retur</th>
                            <th width="30%" >Qty Retur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jual->detail as $d)
                        @php
                            $sudahDiretur = \App\Models\DReturJual::where('kd_brg', $d->kd_brg)
                                ->whereHas('retur', function ($q) use ($jual) {
                                    $q->where('no_jual', $jual->no_jual);
                                })
                                ->sum('qty_retur');

                            $sisa = $d->jml_jual - $sudahDiretur;
                        @endphp
 
                        <tr>
                            <td>{{ $d->kd_brg }}</td>
                            <td class="text-end">{{ number_format($d->harga_jual) }}</td>
                            <td class="text-center">{{ $d->jml_jual }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">{{ $sudahDiretur }}</span>
                            </td>
                            <td>
                                <div class="input-group">
                                <input type="number"
                                    name="qty_retur[{{ $d->kd_brg }}]"
                                    class="form-control text-end"
                                    min="0"
                                    max="{{ $sisa }}"
                                    value="0"
                                    {{ $sisa <= 0 ? 'disabled' : '' }}>
                                    <span class="input-group-text">/ {{ $sisa }}</span>
                                </div>
                                @if($sisa <= 0)
                                    <small class="text-danger">Sudah full retur</small>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach

        <button type="button"
            class="btn btn-danger"
            onclick="submitRetur('{{ url('/retur-penjualan/simpan') }}','no_jual')">
            Simpan Retur
        </button>

    </div>
</div>

{{-- SCRIPT --}}
<script>
function submitRetur(url, noField) {
    let formData = new FormData();
    let noNota = document.getElementById(noField).value;

    if (!noNota) {
        alert('Pilih nota terlebih dahulu');
        return;
    }

    let activeCard = document.getElementById('detail-' + noNota);

    formData.append('_token', "{{ csrf_token() }}");
    formData.append(noField, noNota);

    activeCard.querySelectorAll('input').forEach(el => {
        if (el.name && parseInt(el.value) > 0) {
            formData.append(el.name, el.value);
        }
    });

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        if (res.status === 'success') location.reload();
    })
    .catch(() => alert('Terjadi kesalahan server'));
}

document.getElementById('no_jual').addEventListener('change', function () {
    document.querySelectorAll('.detail-jual').forEach(el => el.style.display = 'none');
    if (this.value) {
        document.getElementById('detail-' + this.value).style.display = 'block';
    }
});
</script>
@endsection
