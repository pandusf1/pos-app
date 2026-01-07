<?php

namespace App\Http\Controllers;

use App\Models\ViewPembelian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PembelianExport;

class LaporanPembelianController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->getFilteredData($request);

        // 🔒 whitelist sorting agar aman
        $allowedSort = [
            'tgl_beli', 'no_beli', 'nm_sup', 'nm_brg', 'jml_beli', 'total'
        ];

        $sort = in_array($request->sort, $allowedSort)
            ? $request->sort
            : 'tgl_beli';

        $dir = $request->dir === 'asc' ? 'asc' : 'desc';

        $data = $query
            ->orderBy($sort, $dir)
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        return view('laporan.pembelian.index', compact('data'));
    }

    // ================= PDF =================
    public function exportPDF(Request $request)
    {
        $data = $this->getFilteredData($request)->get();

        $pdf = Pdf::loadView('laporan.pembelian.pdf', [
            'data' => $data,
            'request' => $request
        ])->setPaper('A4', 'landscape');

        return $pdf->download('laporan-pembelian.pdf');
    }

    // ================= EXCEL =================
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PembelianExport($request),
            'laporan-pembelian.xlsx'
        );
    }

    // ================= FILTER CORE =================
    private function getFilteredData(Request $request)
    {
        $query = ViewPembelian::query();

        // tanggal
        if ($request->start_date) {
            $query->whereDate('tgl_beli', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('tgl_beli', '<=', $request->end_date);
        }

        // search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('no_beli', 'like', '%' . $request->search . '%')
                  ->orWhere('nm_sup', 'like', '%' . $request->search . '%')
                  ->orWhere('nm_brg', 'like', '%' . $request->search . '%');
            });
        }

        return $query;
    }
}