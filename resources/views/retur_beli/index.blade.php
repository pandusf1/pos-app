@extends('layout')

@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-3">Retur Pembelian</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div id="form-retur">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">


        <div class="mb-3">
            <label class="form-label">No Pembelian</label>
            <select name="no_beli" id="no_beli" class="form-control" >
                <option value="">-- Pilih Nota --</option>
                @foreach($pembelian as $b)
                    <option value="{{ $b->no_beli }}">
                        {{ $b->no_beli }} | {{ $b->tgl_beli }}
                    </option>
                @endforeach
            </select>
        </div>

        @foreach($pembelian as $beli)
        <div class="card mb-3 detail-beli" id="detail-{{ $beli->no_beli }}" style="display:none;">
            <div class="card-header bg-light fw-bold">
                No Pembelian: {{ $beli->no_beli }}
            </div>
            <div class="card-body p-2">
                <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="15%">Kode Barang</th>
                        <th width="20%">Harga</th>
                        <th width="15%" class="text-center">Qty Beli</th>
                        <th width="20%" class="text-center">Sudah Retur</th>
                        <th width="30%">Qty Retur</th>
                    </tr>
                </thead>

                    <tbody>
                        @foreach($beli->detail as $d)
                        <tr>
                            <td>{{ $d->kd_brg }}</td>
                            <td>{{ number_format($d->harga_beli) }}</td>
                            <td>{{ $d->jml_beli }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary">
                                    {{ $d->sudah_diretur }}
                                </span>
                            </td>

                            <td>
                                <div class="input-group">
                                    <input type="number"
                                        name="qty_retur[{{ $d->kd_brg }}]"
                                        class="form-control text-end"
                                        min="0"
                                        max="{{ $d->jml_beli - $d->sudah_diretur }}"
                                        value="0"
                                        {{ ($d->jml_beli - $d->sudah_diretur) <= 0 ? 'disabled' : '' }}>

                                    <span class="input-group-text">
                                        / {{ $d->jml_beli - $d->sudah_diretur }}
                                    </span>
                                </div>

    @if(($d->jml_beli - $d->sudah_diretur) <= 0)
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

<script>
function submitRetur() {
    let formData = new FormData();

    let noBeli = document.getElementById('no_beli').value;
    if (!noBeli) {
        alert('Pilih no pembelian terlebih dahulu');
        return;
    }

    let activeCard = document.getElementById('detail-' + noBeli);

    formData.append('_token', "{{ csrf_token() }}");
    formData.append('no_beli', noBeli);

    activeCard.querySelectorAll('input').forEach(el => {
        if (el.name && parseInt(el.value) > 0) {
            formData.append(el.name, el.value);
        }
    });

    fetch("{{ url('/retur-pembelian/simpan') }}", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())   // ✅ BACA JSON
    .then(res => {
        if (res.status === 'success') {
            alert(res.message);
            window.location.reload();
        } else {
            alert(res.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan server');
    });
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
