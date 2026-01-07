<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Barang; // Gunakan model Barang
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; // Tambahkan untuk header kolom

class BarangLaporanExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Barang::query();

        // Filter Pencarian
        if ($this->request->search) {
            $query->where(function ($q) {
                $q->where('kd_brg', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nm_brg', 'like', '%' . $this->request->search . '%');
            });
        }
        
        // Ambil data yang dibutuhkan saja sesuai urutan di headings()
        return $query->get()->map(function ($barang) {
            return [
                $barang->kd_brg,
                $barang->nm_brg,
                $barang->satuan,
                $barang->harga_beli,
                $barang->harga_jual,
                $barang->stok,
                $barang->stok_min,
                $barang->expired,
                // Hilangkan kolom gambar
            ];
        });
    }

    // Definisikan Header Kolom untuk Excel
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Satuan',
            'Harga Beli',
            'Harga Jual',
            'Stok',
            'Stok Min',
            'Expired',
        ];
    }
}