<?php

namespace App\Exports;

use App\Models\ReturBeli;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanReturPembelianExport implements FromCollection, WithHeadings
{
    protected $tgl_awal;
    protected $tgl_akhir;

    public function __construct($tgl_awal = null, $tgl_akhir = null)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function collection()
    {
        $query = ReturBeli::with('detail');

        if ($this->tgl_awal && $this->tgl_akhir) {
            $query->whereBetween('tgl_retur', [
                $this->tgl_awal,
                $this->tgl_akhir
            ]);
        }

        $data = [];

        foreach ($query->get() as $r) {
            foreach ($r->detail as $d) {
                $data[] = [
                    $r->no_retur_beli,
                    $r->no_beli,
                    $r->tgl_retur,
                    $d->kd_brg,
                    $d->qty_retur,
                    $d->subtotal,
                ];
            }
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No Retur',
            'No Beli',
            'Tanggal',
            'Kode Barang',
            'Qty Retur',
            'Subtotal'
        ];
    }
}
