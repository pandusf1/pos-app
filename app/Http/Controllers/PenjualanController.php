<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Konsumen;
use App\Models\Jual;
use App\Models\DJual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('jual.index', [
            'konsumen' => Konsumen::all(),
            'barang'   => Barang::all(),
        ]);
    }

    public function store(Request $req)
    {
        $no = "J" . time();

        DB::transaction(function () use ($req, $no) {

            Jual::create([
                'no_jual'  => $no,
                'tgl_jual' => date('Y-m-d'),
                'kd_kons'  => $req->kd_kons
            ]);

            $total = 0;

            foreach ($req->items as $item) {

                if (!isset($item['jml']) || $item['jml'] <= 0) {
                    continue;
                }

                $jml   = (int) $item['jml'];
                $harga = (float) $item['harga_jual'];
                $subtotal = $jml * $harga;

                $barang = Barang::where('kd_brg', $item['kd_brg'])->first();

                // ✅ CEK STOK HANYA UNTUK PENJUALAN
                if ($jml > 0 && $barang->stok < $jml) {
                    throw new \Exception(
                        "Stok {$barang->nm_brg} tidak mencukupi"
                    );
                }

                DJual::create([
                    'no_jual'    => $no,
                    'kd_brg'     => $item['kd_brg'],
                    'harga_jual' => $harga,
                    'jml_jual'   => $jml,
                    'subtotal'   => $subtotal,
                ]);

                // ✅ LOGIKA STOK JELAS & AMAN
                if ($jml > 0) {
                    $barang->decrement('stok', $jml);
                }

                $total += $subtotal;
            }

            // SIMPAN JENIS & TOTAL
            Jual::where('no_jual', $no)->update([
                'total' => $total
            ]);
        });

        return redirect()
            ->route('jual.show', $no)
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    public function show($no_jual)
    {
        $jual = Jual::with(['konsumen', 'detail.barang'])
                    ->findOrFail($no_jual);

        return view('jual.show', compact('jual'));
    }

    public function struk($no_jual)
    {
        $jual = Jual::with(['konsumen','detail.barang'])
                    ->findOrFail($no_jual);

        return view('jual.struk', compact('jual'));
    }
}