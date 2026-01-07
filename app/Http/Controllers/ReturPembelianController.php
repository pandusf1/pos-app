<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Beli;
use App\Models\Dbeli;
use App\Models\Barang;
use App\Models\ReturBeli;
use App\Models\DReturBeli;

class ReturPembelianController extends Controller
{
    // HALAMAN RETUR PEMBELIAN
    public function index()
{
    $pembelian = Beli::with('detail')->get();
    return view('retur_beli.index', compact('pembelian'));
}

    // SIMPAN RETUR PEMBELIAN
    public function store(Request $request)
    {
        try {
            $request->validate([
                'no_beli'       => 'required',
                'qty_retur'     => 'nullable|array',
                'qty_retur.*'   => 'integer|min:0'
            ]);
    
            DB::transaction(function () use ($request) {
    
                $pembelian = Beli::with('detail')
                    ->where('no_beli', $request->no_beli)
                    ->firstOrFail();
    
                $retur = ReturBeli::create([
                    'no_beli'     => $pembelian->no_beli,
                    'tgl_retur'   => now(),
                    'total_retur' => 0
                ]);
    
                $total = 0;
    
                foreach ($pembelian->detail as $d) {

                    $qtyRetur = $request->qty_retur[$d->kd_brg] ?? 0;
                
                    if ($qtyRetur > 0) {
                
                        // 🔴 HITUNG YANG SUDAH DIRETUR
                        $sudahDiretur = DReturBeli::where('kd_brg', $d->kd_brg)
                            ->whereHas('retur', function ($q) use ($pembelian) {
                                $q->where('no_beli', $pembelian->no_beli);
                            })
                            ->sum('qty_retur');
                
                        $sisa = $d->jml_beli - $sudahDiretur;
                
                        if ($qtyRetur > $sisa) {
                            throw new \Exception(
                                "Qty retur {$d->kd_brg} melebihi sisa. Sisa: {$sisa}"
                            );
                        }
                
                        $subtotal = $qtyRetur * $d->harga_beli;
                
                        DReturBeli::create([
                            'no_retur_beli' => $retur->no_retur_beli,
                            'kd_brg'        => $d->kd_brg,
                            'qty_retur'     => $qtyRetur,
                            'harga_beli'    => $d->harga_beli,
                            'subtotal'      => $subtotal
                        ]);
                
                        Barang::where('kd_brg', $d->kd_brg)
                            ->decrement('stok', $qtyRetur);
                
                        $total += $subtotal;
                    }
                }                
    
                $retur->update(['total_retur' => $total]);
            });
    
            return response()->json([
                'status' => 'success',
                'message' => 'Retur pembelian berhasil disimpan'
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
        $query = ReturBeli::with(['detail', 'detail.barang']);

        // 🔍 filter tanggal (opsional)
        if ($request->filled('tgl_awal') && $request->filled('tgl_akhir')) {
            $query->whereBetween('tgl_retur', [
                $request->tgl_awal,
                $request->tgl_akhir
            ]);
        }

        $retur = $query->orderBy('tgl_retur', 'desc')->get();

        return view('retur_beli.laporan', compact('retur'));
    }
}