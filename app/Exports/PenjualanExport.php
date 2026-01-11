<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\ViewPenjualan;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class PenjualanExport implements FromArray, WithEvents, WithTitle
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function title(): string
    {
        return 'Laporan Penjualan';
    }

    public function array(): array
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
                $q->where('nm_kons','like',"%{$this->request->search}%")
                  ->orWhere('nm_brg','like',"%{$this->request->search}%")
                  ->orWhere('no_jual','like',"%{$this->request->search}%");
            });
        }

        $data  = $query->get();
        $total = $data->sum('total');

        $rows = [];

        /* ===== KOP ===== */
        $rows[] = ['LAPORAN PENJUALAN','','','','','','',''];
        $rows[] = ['KEJORA MART','','','','','','',''];
        $rows[] = ['Jl. Bintang No 36, Semarang','','','','','','',''];
        $rows[] = [
            'Periode: '.($this->request->start_date ?? '-') .
            ' s/d '.($this->request->end_date ?? '-'),
            '','','','','','',''
        ];
        $rows[] = ['','','','','','','',''];

        /* ===== HEADER ===== */
        $rows[] = [
            'No','No Jual','Tanggal','Konsumen','Barang','Jumlah','Harga','Total'
        ];

        /* ===== DATA ===== */
        $no = 1;
        foreach ($data as $d) {
            $rows[] = [
                $no++,
                $d->no_jual,
                date('d-m-Y', strtotime($d->tgl_jual)),
                $d->nm_kons,
                $d->nm_brg,
                $d->jml_jual,
                $d->harga_jual,
                $d->total
            ];
        }

        /* ===== TOTAL (JELAS & TEGAS) ===== */
        $rows[] = ['','','','','','','TOTAL',$total];

        /* ===== FOOTER ===== */
        $rows[] = ['','','','','','','',''];
        $rows[] = ['','','','','','Semarang, '.date('d F Y'),'',''];
        $rows[] = ['','','','','','','',''];
        $rows[] = ['Dibuat oleh,','','','','Mengetahui,','',''];
        $rows[] = ['','','','','','','',''];
        $rows[] = [auth()->user()->name ?? 'Admin','','','','Pimpinan','',''];

        return $rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet   = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();

                $headerRow = 6;
                $totalRow  = $lastRow - 6;

                /* === MERGE KOP === */
                foreach ([1,2,3,4] as $r) {
                    $sheet->mergeCells("A{$r}:H{$r}");
                }

                $sheet->getStyle('A1:A4')->getAlignment()
                      ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(13);

                /* === HEADER STYLE === */
                $sheet->getStyle("A{$headerRow}:H{$headerRow}")->applyFromArray([
                    'font' => ['bold'=>true,'color'=>['rgb'=>'FFFFFF']],
                    'fill' => [
                        'fillType'=>Fill::FILL_SOLID,
                        'startColor'=>['rgb'=>'0F172A']
                    ],
                    'alignment'=>['horizontal'=>Alignment::HORIZONTAL_CENTER],
                    'borders'=>[
                        'allBorders'=>['borderStyle'=>Border::BORDER_THIN]
                    ]
                ]);

                /* === BORDER DATA (SAMPAI TOTAL) === */
                $sheet->getStyle("A{$headerRow}:H{$totalRow}")
                      ->getBorders()->getAllBorders()
                      ->setBorderStyle(Border::BORDER_THIN);

                /* === TOTAL STYLE === */
                $sheet->mergeCells("A{$totalRow}:F{$totalRow}");
                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->applyFromArray([
                    'font' => ['bold'=>true,'size'=>12],
                    'alignment'=>[
                        'horizontal'=>Alignment::HORIZONTAL_RIGHT
                    ],
                    'borders'=>[
                        'top'=>['borderStyle'=>Border::BORDER_MEDIUM]
                    ]
                ]);

                /* === FORMAT ANGKA === */
                $sheet->getStyle("G".($headerRow+1).":H{$totalRow}")
                      ->getNumberFormat()
                      ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

                /* === AUTO WIDTH === */
                foreach (range('A','H') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                /* === PRINT SETUP === */
                $sheet->getPageSetup()
                      ->setPaperSize(PageSetup::PAPERSIZE_A4)
                      ->setOrientation(PageSetup::ORIENTATION_PORTRAIT)
                      ->setFitToWidth(1);
            }
        ];
    }
}
