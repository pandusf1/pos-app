<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jual;
use App\Models\Barang;
use App\Models\ReturJual;
use App\Models\DReturJual;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReturPenjualanExport;

class ReturPenjualanController extends Controller
{
    // HALAMAN RETUR PENJUALAN
    public function index()
    {
        $penjualan = Jual::with('detail')->get()->map(function ($jual) {
            $totalSisa = 0;

            foreach ($jual->detail as $d) {
                $sudahDiretur = \App\Models\DReturJual::where('kd_brg', $d->kd_brg)
                    ->whereHas('retur', function ($q) use ($jual) {
                        $q->where('no_jual', $jual->no_jual);
                    })
                    ->sum('qty_retur');

                $totalSisa += max(0, $d->jml_jual - $sudahDiretur);
            }

            $jual->masih_bisa_retur = $totalSisa > 0;
            return $jual;
        });

        return view('retur_jual.index', compact('penjualan'));
    }

    // SIMPAN RETUR PENJUALAN
    public function store(Request $request)
    {
        try {
            $request->validate([
                'no_jual'       => 'required',
                'qty_retur'     => 'nullable|array',
                'qty_retur.*'   => 'integer|min:0'
            ]);

            DB::transaction(function () use ($request) {

                $jual = Jual::with('detail')
                    ->where('no_jual', $request->no_jual)
                    ->firstOrFail();
                
                    $adaRetur = false;


                // HEADER RETUR
                $retur = ReturJual::create([
                    'no_jual'     => $jual->no_jual,
                    'tgl_retur'   => now(),
                    'total_retur' => 0
                ]);                

                $total = 0;

                foreach ($jual->detail as $d) {
 
                    $qtyRetur = $request->qty_retur[$d->kd_brg] ?? 0;

                    if ($qtyRetur > 0) {
                        $adaRetur = true;


                        // 🔴 HITUNG YANG SUDAH DIRETUR
                        $sudahDiretur = DReturJual::where('kd_brg', $d->kd_brg)
                            ->whereHas('retur', function ($q) use ($jual) {
                                $q->where('no_jual', $jual->no_jual);
                            })
                            ->sum('qty_retur');

                        $sisa = $d->jml_jual - $sudahDiretur;

                        if ($qtyRetur > $sisa) {
                            throw new \Exception(
                                "Qty retur {$d->kd_brg} melebihi sisa. Sisa: {$sisa}"
                            );
                        }

                        $subtotal = $qtyRetur * $d->harga_jual;

                        // DETAIL RETUR
                        DReturJual::create([
                            'no_retur_jual' => $retur->no_retur_jual,
                            'kd_brg'        => $d->kd_brg,
                            'qty_retur'     => $qtyRetur,
                            'harga_jual'    => $d->harga_jual,
                            'subtotal'      => $subtotal
                        ]);

                        // 🔴 STOK BALIK (TAMBAH)
                        Barang::where('kd_brg', $d->kd_brg)
                            ->increment('stok', $qtyRetur);

                        $total += $subtotal;
                    }
                }
                if (!$adaRetur) {
                    throw new \Exception('Tidak ada barang yang diretur');
                }                

                $retur->update(['total_retur' => $total]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Retur penjualan berhasil disimpan'
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function laporan(Request $request)
    {
        $query = ReturJual::with('detail');

        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_retur', [
                $request->tgl_awal,
                $request->tgl_akhir
            ]);
        }

        $retur = $query
            ->orderBy('tgl_retur', 'desc')
            ->get();

        return view('retur_jual.laporan', compact('retur'));
    }

    // ================= EXPORT PDF =================
public function exportPDF(Request $request)
{
    $query = ReturJual::with(['detail.barang', 'jual.konsumen']);

    if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
        $query->whereBetween('tgl_retur', [
            $request->tgl_awal,
            $request->tgl_akhir
        ]);
    }

    $retur = $query->orderBy('tgl_retur', 'desc')->get();

    $pdf = Pdf::loadView('retur_jual.pdf', [
        'retur' => $retur,
        'tgl_awal' => $request->tgl_awal,
        'tgl_akhir' => $request->tgl_akhir,
    ])->setPaper('A4', 'portrait');

    return $pdf->download('laporan-retur-penjualan.pdf');
}

// ================= EXPORT EXCEL =================
public function exportExcel()
{
    return Excel::download(
        new ReturPenjualanExport,
        'laporan-retur-penjualan.xlsx'
    );
}

}
