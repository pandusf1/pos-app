<?php
namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\ViewSupplier; // ViewSupplier akan diarahkan ke tabel 'supplier'
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplierExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = ViewSupplier::query();
        
        // Filter Pencarian (hanya berdasarkan kolom master supplier)
        if ($this->request->search) {
            $query->where(function($q) {
                $q->where('kd_sup', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nm_sup', 'like', '%' . $this->request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $this->request->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->request->search . '%');
            });
        }
        
        // Ambil data yang dibutuhkan sesuai urutan di headings()
        return $query->get()->map(function ($supplier) {
            return [
                $supplier->kd_sup,
                $supplier->nm_sup,
                $supplier->alamat, // Mengikuti struktur tabel supplier
                $supplier->kota,
                $supplier->kd_pos,
                $supplier->phone,
                $supplier->email,
            ];
        });
    }

    // Definisikan Header Kolom untuk Excel
    public function headings(): array
    {
        return [
            'Kode Supplier',
            'Nama Supplier',
            'Alamat',
            'Kota',
            'Kode Pos',
            'Telepon',
            'Email',
        ];
    }
}