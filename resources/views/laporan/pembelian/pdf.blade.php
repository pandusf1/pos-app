<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembelian</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
        }

        .kop {
            text-align: center;
        }

        .kop h2 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .kop p {
            margin: 3px 0;
            font-size: 12px;
        }

        .line {
            border-top: 2px solid #000;
            margin: 10px 0 2px;
        }

        .line-thin {
            border-top: 1px solid #000;
            margin-bottom: 20px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #0f172a;
            color: #fff;
            text-align: center;
            padding: 6px;
            font-size: 11px;
        }

        table td {
            padding: 6px;
            border: 1px solid #ccc;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            width: 100%;
            margin-top: 50px;
        }

        .footer .right {
            width: 40%;
            float: right;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- KOP -->
    <div class="kop">
        <h2>LAPORAN PEMBELIAN</h2>
        <h2>KEJORA MART</h2>
        <p>Jl. Bintang No 36, Semarang</p>
        <p>Telepon: (021) 123-4567 | Email: kejoramart@gmail.com</p>
    </div>

    <div class="line"></div>
    <div class="line-thin"></div>

    <!-- JUDUL -->
    <div class="title">
        LAPORAN PEMBELIAN
    </div>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th>No Beli</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSeluruh = 0; @endphp {{-- Inisialisasi variabel --}}
            @foreach($data as $d)
            <tr>
                <td class="text-center">{{ $d->no_beli }}</td>
                <td class="text-center">{{ date('d-m-Y', strtotime($d->tgl_beli)) }}</td>
                <td>{{ $d->nm_sup }}</td>
                <td>{{ $d->nm_brg }}</td>
                <td class="text-center">{{ $d->jml_beli }}</td>
                <td class="text-right">Rp {{ number_format($d->harga_beli,0,',','.') }}</td>
                <td class="text-right">Rp {{ number_format($d->total,0,',','.') }}</td>
            </tr>
            @php $totalSeluruh += $d->total; @endphp {{-- Tambahkan setiap total ke total seluruh --}}
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">TOTAL KESELURUHAN</th>
                <th class="text-right">
                    Rp {{ number_format($totalSeluruh, 0, ',', '.') }}
                </th>
            </tr>
        </tfoot>
    </table>

    <!-- FOOTER -->
    <br><br><br>

    <table width="100%" cellpadding="0" cellspacing="0" style="border:none;">
        <tr>
            <td width="60%" style="border:none;"></td>
            <td width="40%" align="center" style="border:none;">
                Semarang, {{ date('d F Y') }}
            </td>
        </tr>
    </table>

    <br><br>

    <table width="100%" cellpadding="0" cellspacing="0" style="border:none;">
        <tr>
            <td width="50%" align="center" style="border:none;">
                Dibuat oleh,
            </td>
            <td width="50%" align="center" style="border:none;">
                Mengetahui,
            </td>
        </tr>

        <tr>
            <td height="70" style="border:none;"></td>
            <td height="70" style="border:none;"></td>
        </tr>

        <tr>
            <td align="center" style="border:none;">
                <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
            </td>
            <td align="center" style="border:none;">
                <strong>Pimpinan</strong>
            </td>
        </tr>
    </table>

</body>
</html>
