<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Jual; // GANTI sesuai model transaksi kamu
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenjualanHariIni = Jual::whereDate('tgl_jual', Carbon::today())
            ->sum('total'); // ganti kalau beda

        $jumlahTransaksiHariIni = Jual::whereDate('tgl_jual', Carbon::today())
            ->count();

        $stokMenipis = Barang::where('stok', '<=', 5)->count();

        return view('dashboard', [
            'totalPenjualanHariIni'   => $totalPenjualanHariIni ?? 0,
            'jumlahTransaksiHariIni' => $jumlahTransaksiHariIni ?? 0,
            'stokMenipis'             => $stokMenipis ?? 0,
        ]);
    }
}
