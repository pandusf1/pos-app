<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Exports\BarangLaporanExport; // Import Export Class
use Maatwebsite\Excel\Facades\Excel; // Untuk ekspor Excel
use PDF; // Pastikan package PDF terinstal (misalnya, barryvdh/laravel-dompdf)

class BarangController extends Controller
{
    /**
     * Menampilkan daftar barang (manajemen).
     */
    public function index(Request $request)
    {
        $query = Barang::query();
        // 🔍 Jika ada pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('nm_brg', 'like', '%' . $request->search . '%');
        }
        $barangs = $query->orderBy('kd_brg', 'asc')->paginate(10);
        return view('barang.index', compact('barangs'));
    }

    /**
     * Menampilkan form untuk membuat barang baru.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Menyimpan barang baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kd_brg' => 'required|unique:barang,kd_brg',
            'nm_brg' => 'required|string|max:30',
            'satuan' => 'nullable|string|max:10',
            'harga_jual' => 'nullable|numeric|min:0',
            'harga_beli' => 'nullable|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'stok_min' => 'nullable|integer|min:0',
            'expired' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ✅ Buat objek baru
        $barang = new Barang();
        $barang->kd_brg = $request->kd_brg;
        $barang->nm_brg = $request->nm_brg;
        $barang->satuan = $request->satuan;
        $barang->harga_jual = $request->harga_jual;
        $barang->harga_beli = $request->harga_beli;
        $barang->stok = $request->stok ?? 0; // Tambahkan default 0 jika null
        $barang->stok_min = $request->stok_min ?? 0; // Tambahkan default 0 jika null
        $barang->expired = $request->expired;

        // ✅ Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            
            $barang->gambar = null;
        }

        $barang->save();
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail barang (biasanya redirect ke index jika tidak ada detail view).
     */
    public function show(Barang $barang)
    {
        // Biasanya tidak digunakan dalam CRUD sederhana
        return redirect()->route('barang.index');
    }

    /**
     * Menampilkan form untuk mengedit barang.
     */
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    /**
     * Memperbarui data barang.
     */
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            // Tidak perlu validasi unique untuk kd_brg di update
            'nm_brg' => 'required|string|max:30',
            'satuan' => 'nullable|string|max:10',
            'harga_jual' => 'nullable|numeric|min:0',
            'harga_beli' => 'nullable|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'stok_min' => 'nullable|integer|min:0',
            'expired' => 'nullable|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Tambahkan mimes dan max untuk keamanan
        ]);

        $data = $request->only([
            'nm_brg','satuan','harga_jual','harga_beli','stok','stok_min','expired'
        ]);
        
        // Atur nilai default jika null
        $data['stok'] = $data['stok'] ?? 0;
        $data['stok_min'] = $data['stok_min'] ?? 0;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama (opsional, tergantung kebutuhan)
            if ($barang->gambar && file_exists(public_path('gambar/' . $barang->gambar))) {
                unlink(public_path('gambar/' . $barang->gambar));
            }
            
            $file = $request->file('gambar');
            // Ganti preg_replace dengan yang lebih sederhana
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar'), $filename);
            $data['gambar'] = $filename; // Simpan nama file ke array data
        }

        $barang->update($data);
        return redirect()->route('barang.index')->with('success','Barang berhasil diubah.');
    }

    /**
     * Menghapus barang dari database.
     */
    public function destroy(Barang $barang)
    {
        // 🗑️ Hapus gambar terkait jika ada
        if ($barang->gambar && file_exists(public_path('gambar/' . $barang->gambar))) {
            unlink(public_path('gambar/' . $barang->gambar));
        }
        
        $barang->delete();
        return redirect()->route('barang.index')->with('success','Barang berhasil dihapus.');
    }


    // =================================================================
    // >>> FUNGSI KHUSUS UNTUK LAPORAN BARANG
    // =================================================================

    /**
     * Logika query untuk mengambil data laporan barang, termasuk sorting dan filtering.
     */
    private function getLaporanBarangQuery(Request $request)
    {
        $query = Barang::query();

        // 1. Filter Pencarian (Berdasarkan Kode atau Nama Barang)
        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('kd_brg', 'like', '%' . $request->search . '%')
                  ->orWhere('nm_brg', 'like', '%' . $request->search . '%');
            });
        }

        // 2. Sorting
        $sortField = $request->get('sort', 'kd_brg');
        // Pastikan field yang disort ada di tabel Barang
        $allowedSorts = ['kd_brg', 'nm_brg', 'satuan', 'harga_beli', 'harga_jual', 'stok', 'stok_min', 'expired'];
        if (!in_array($sortField, $allowedSorts)) {
             $sortField = 'kd_brg';
        }
        
        $sortDir = $request->get('dir', 'asc');
        $query->orderBy($sortField, $sortDir);

        return $query;
    }

    /**
     * Menampilkan laporan barang di web.
     */
    public function laporanIndex(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $data = $this->getLaporanBarangQuery($request)->paginate($perPage);

        return view('laporan.barang.index', compact('data'));
    }

    /**
     * Mengekspor laporan barang dalam format PDF.
     */
    public function laporanPdf(Request $request)
    {
        $data = $this->getLaporanBarangQuery($request)->get(); // Ambil semua data tanpa pagination

        // Muat view laporan.barang.pdf ke package PDF
        $pdf = PDF::loadView('laporan.barang.pdf', compact('data'));

        // Ubah ukuran kertas dan orientasi jika perlu
        // $pdf->setPaper('a4', 'landscape'); 

        return $pdf->download('laporan-barang-' . date('Ymd_His') . '.pdf');
    }

    /**
     * Mengekspor laporan barang dalam format Excel.
     */
    public function laporanExcel(Request $request)
    {
        // Gunakan export class yang sudah dibuat
        return Excel::download(new BarangLaporanExport($request), 'laporan-barang-' . date('Ymd_His') . '.xlsx');
    }
}
