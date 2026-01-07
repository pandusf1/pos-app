<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\ViewPembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PembelianExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'No Beli',
            'Tanggal',
            'Supplier',
            'Barang',
            'Jumlah',
            'Harga',
            'Total'
        ];
    }

    public function collection()
    {
        $query = ViewPembelian::query();

        // FILTER TANGGAL
        if ($this->request->start_date) {
            $query->where('tgl_beli', '>=', $this->request->start_date);
        }

        if ($this->request->end_date) {
            $query->where('tgl_beli', '<=', $this->request->end_date);
        }

        // SEARCH
        if ($this->request->search) {
            $query->where(function ($q) {
                $q->where('nm_sup', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nm_brg', 'like', '%' . $this->request->search . '%')
                  ->orWhere('no_beli', 'like', '%' . $this->request->search . '%');
            });
        }

        $data = $query->get();

        // ✅ HITUNG GRAND TOTAL DARI SUBTOTAL
        $grandTotal = $data->sum(function ($row) {
            return $row->jml_beli * $row->harga_beli;
        });
        
        // ✅ TAMBAH BARIS TOTAL KE BAWAH
        $data->push((object)[
            'no_beli'   => '',
            'tgl_beli'  => '',
            'nm_sup'    => '',
            'nm_brg'    => 'TOTAL AKHIR',
            'jml_beli'  => '',
            'harga_beli'=> '',
            'total'  => $grandTotal
        ]);

        // FORMAT OUTPUT
        return $data->map(function ($row) {
            return [
                $row->no_beli,
                $row->tgl_beli,
                $row->nm_sup,
                $row->nm_brg,
                $row->jml_beli,
                $row->harga_beli,
                $row->total,
            ];
        });
    }
}