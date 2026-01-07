@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-3">Retur Penjualan</h4>

    <div id="form-retur">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        {{-- PILIH NOTA --}}
        <div class="mb-3">
            <label class="form-label">No Penjualan</label>
            <select id="no_jual" class="form-control">
                <option value="">-- Pilih Nota --</option>
                @foreach($penjualan as $j)
                    <option value="{{ $j->no_jual }}">
                        {{ $j->no_jual }} | {{ $j->tgl_jual }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DETAIL --}}
        @foreach($penjualan as $jual)
        <div class="card mb-3 detail-jual" id="detail-{{ $jual->no_jual }}" style="display:none;">
            <div class="card-header bg-light fw-bold">
                No Penjualan: {{ $jual->no_jual }}
            </div>
            <div class="card-body p-2">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Barang</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Qty Jual</th>
                            <th class="text-center">Sudah Retur</th>
                            <th>Qty Retur</th>
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

        <button type="button" class="btn btn-danger" onclick="submitRetur()">
            Simpan Retur
        </button>
    </div>
</div>

{{-- SCRIPT --}}
<script>
function submitRetur() {
    let formData = new FormData();
    let noJual = document.getElementById('no_jual').value;

    if (!noJual) {
        alert('Pilih no penjualan terlebih dahulu');
        return;
    }

    let activeCard = document.getElementById('detail-' + noJual);

    formData.append('_token', "{{ csrf_token() }}");
    formData.append('no_jual', noJual);

    activeCard.querySelectorAll('input').forEach(el => {
        if (el.name && parseInt(el.value) > 0) {
            formData.append(el.name, el.value);
        }
    });

    fetch("{{ url('/retur-penjualan/simpan') }}", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        if (res.status === 'success') location.reload();
    });
}

document.getElementById('no_jual').addEventListener('change', function () {
    document.querySelectorAll('.detail-jual').forEach(el => el.style.display = 'none');
    if (this.value) {
        document.getElementById('detail-' + this.value).style.display = 'block';
    }
});
</script>
@endsection
