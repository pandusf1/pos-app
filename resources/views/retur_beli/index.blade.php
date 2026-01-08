@extends('layout')

@section('content')
<div class="glass-card">
    <h1 class="page-title mb-3">Retur Pembelian</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div id="form-retur">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="card mb-3">
            <div class="card-body">
            <label class="form-label fw-bold">No Pembelian</label>
            <select id="no_beli" class="form-control">
                <option value="">-- Pilih Nota --</option>
                @foreach($pembelian as $b)
                    <option value="{{ $b->no_beli }}"
                        {{ !$b->masih_bisa_retur ? 'disabled' : '' }}>
                        {{ $b->no_beli }} | {{ $b->tgl_beli }}
                        {{ !$b->masih_bisa_retur ? ' (FULL RETUR)' : '' }}
                    </option>
                @endforeach
            </select>
            </div>
        </div>

        @foreach($pembelian as $beli)
        <div class="card mb-3 detail-beli shadow-sm" id="detail-{{ $beli->no_beli }}" style="display:none;">
            <div class="card-header bg-white fw-semibold">
                No Pembelian: {{ $beli->no_beli }}
            </div>
            <div class="card-body p-2">
                <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="15%">Kode Barang</th>
                        <th width="20%" class="text-end">Harga</th>
                        <th width="15%" class="text-center">Qty Beli</th>
                        <th width="20%" class="text-center">Sudah Retur</th>
                        <th width="30%">Qty Retur</th>
                    </tr>
                </thead>
                    <tbody>
                    @foreach($beli->detail as $d)
                    @php
                        $sudahDiretur = \App\Models\DReturBeli::where('kd_brg', $d->kd_brg)
                            ->whereHas('retur', function ($q) use ($beli) {
                                $q->where('no_beli', $beli->no_beli);
                            })
                            ->sum('qty_retur');

                        $sisa = $d->jml_beli - $sudahDiretur;
                    @endphp

                        <tr>
                            <td>{{ $d->kd_brg }}</td>
                            <td class="text-end">{{ number_format($d->harga_beli) }}</td>
                            <td class="text-center">{{ $d->jml_beli }}</td>
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
                                    <span class="input-group-text">
                                        / {{ $sisa }}
                                    </span>
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
            onclick="submitRetur('{{ url('/retur-pembelian/simpan') }}','no_beli')">
            Simpan Retur
        </button>
</div>

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
</script>

<script>
document.getElementById('no_beli').addEventListener('change', function () {
    document.querySelectorAll('.detail-beli').forEach(el => el.style.display = 'none');
    let id = this.value;
    if (id) document.getElementById('detail-' + id).style.display = 'block';
});
</script>
@endsection
