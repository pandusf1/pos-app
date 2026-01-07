<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\ViewPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenjualanExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        return [
            'No Jual',
            'Tanggal',
            'Konsumen',
            'Barang',
            'Jumlah',
            'Harga',
            'Total'
        ];
    }

    public function collection()
    {
        $query = ViewPenjualan::query();

        if ($this->request->start_date) {
            $query->where('tgl_jual', '>=', $this->request->start_date);
        }

        if ($this->request->end_date) {
            $query->where('tgl_jual', '<=', $this->request->end_date);
        }

        if ($this->request->search) {
            $query->where(function ($q) {
                $q->where('nm_kons', 'like', '%' . $this->request->search . '%')
                  ->orWhere('nm_brg', 'like', '%' . $this->request->search . '%')
                  ->orWhere('no_jual', 'like', '%' . $this->request->search . '%');
            });
        }

        $data = $query->get();

        // HITUNG TOTAL AKHIR
        $grandTotal = $data->sum('total');

        // TAMBAH BARIS TOTAL KE BAWAH
        $data->push((object)[
            'no_jual'   => '',
            'tgl_jual'  => '',
            'nm_kons'   => '',
            'nm_brg'    => 'TOTAL AKHIR',
            'jml_jual'  => '',
            'harga_jual'=> '',
            'total'     => $grandTotal
        ]);

        return $data->map(function ($row) {
            return [
                $row->no_jual,
                $row->tgl_jual,
                $row->nm_kons,
                $row->nm_brg,
                $row->jml_jual,
                $row->harga_jual,
                $row->total
            ];
        });
    }
}