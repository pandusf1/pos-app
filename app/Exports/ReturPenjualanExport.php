<?php

namespace App\Exports;

use App\Models\ReturJual;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReturPenjualanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $rows = collect();

        $retur = ReturJual::with(['detail.barang', 'jual.konsumen'])
            ->orderBy('tgl_retur', 'desc')
            ->get();

        foreach ($retur as $r) {
            foreach ($r->detail as $d) {
                $rows->push([
                    'no_retur'   => $r->no_retur_jual,
                    'tanggal'    => $r->tgl_retur,
                    'no_jual'    => $r->no_jual,
                    'konsumen'   => $r->jual->konsumen->nm_kons ?? '-',
                    'barang'     => $d->barang->nm_brg ?? $d->kd_brg,
                    'qty'        => $d->qty_retur,
                    'harga'      => $d->harga_jual,
                    'subtotal'   => $d->subtotal,
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No Retur',
            'Tanggal',
            'No Jual',
            'Konsumen',
            'Barang',
            'Qty Retur',
            'Harga',
            'Subtotal'
        ];
    }
}
