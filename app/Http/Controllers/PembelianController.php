<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Beli;
use App\Models\Dbeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        return view('beli.index', [
            'supplier' => Supplier::all(),
            'barang'   => Barang::all(),
        ]);
    }

    public function store(Request $req)
    {
        if (!$req->has('items')) {
            return back()->with('error', 'Tidak ada barang dipilih');
        }

        $no = 'B' . time();

        try {
            DB::transaction(function () use ($req, $no) {

                // 1️⃣ SIMPAN HEADER
                $beli = Beli::create([
                    'no_beli'  => $no,
                    'tgl_beli' => now()->toDateString(),
                    'kd_sup'   => $req->kd_sup,
                    'total'    => 0,
                    'jenis'    => 'beli',
                ]);

                $total = 0;
                $adaItem = false;

                // 2️⃣ SIMPAN DETAIL
                foreach ($req->items as $item) {

                    if (
                        !isset($item['jml']) ||
                        trim($item['jml']) === '' ||
                        (int)$item['jml'] === 0
                    ) {
                        continue;
                    }

                    $adaItem = true;

                    $jml   = (int) $item['jml'];
                    $harga = (float) $item['harga_beli'];
                    $subtotal = $jml * $harga;

                    // 🔐 CEK STOK SAAT RETUR
                    if ($jml < 0) {
                        $stok = Barang::where('kd_brg', $item['kd_brg'])->value('stok');
                        if ($stok < abs($jml)) {
                            throw new \Exception("Stok barang {$item['kd_brg']} tidak mencukupi");
                        }
                    }

                    Dbeli::create([
                        'no_beli'    => $beli->no_beli,
                        'kd_brg'     => $item['kd_brg'],
                        'harga_beli' => $harga,
                        'jml_beli'   => $jml,
                        'subtotal'   => $subtotal,
                    ]);

                    // UPDATE STOK
                    Barang::where('kd_brg', $item['kd_brg'])
                        ->increment('stok', $jml);

                    $total += $subtotal;
                }

                if (!$adaItem) {
                    throw new \Exception('Qty barang belum diisi');
                }

                // 3️⃣ UPDATE TOTAL & JENIS
                $beli->update([
                    'total' => $total,
                    'jenis' => $total < 0 ? 'retur' : 'beli',
                ]);
            });

            return redirect()
                ->route('beli.show', $no)
                ->with('success', 'Transaksi pembelian berhasil');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show($no_beli)
    {
        $beli = Beli::with(['supplier', 'detail.barang'])
            ->where('no_beli', $no_beli)
            ->firstOrFail();

        return view('beli.show', compact('beli'));
    }

    public function struk($no_beli)
    {
        $beli = Beli::with(['supplier', 'detail.barang'])
            ->where('no_beli', $no_beli)
            ->firstOrFail();

        return view('beli.struk', compact('beli'));
    }
}