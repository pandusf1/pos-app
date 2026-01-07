<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\Konsumen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KonsumenExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Konsumen::query();

        // Filter Pencarian
        if ($this->request->search) {
            $query->where(function ($q) {
                $q->where('kd_kons', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nm_kons', 'like', '%' . $this->request->search . '%')
                  ->orWhere('alm_kons', 'like', '%' . $this->request->search . '%')
                  ->orWhere('kota_kons', 'like', '%' . $this->request->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->request->search . '%')
                  ->orWhere('email', 'like', '%' . $this->request->search . '%');
            });
        }

        // Ambil data sesuai urutan headings()
        return $query->get()->map(function ($k) {
            return [
                $k->kd_kons,
                $k->nm_kons,
                $k->alm_kons,
                $k->kota_kons,
                $k->kd_pos,
                $k->phone,
                $k->email,
                // kolom gambar tidak disertakan
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kode Konsumen',
            'Nama Konsumen',
            'Alamat',
            'Kota',
            'Kode Pos',
            'No. Telepon',
            'Email',
        ];
    }
}
