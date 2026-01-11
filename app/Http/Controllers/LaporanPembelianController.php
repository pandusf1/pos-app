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
        $query = ViewPembelian::query();

        // ================= FILTER TANGGAL =================
        if ($request->start_date) {
            $query->where('tgl_beli', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('tgl_beli', '<=', $request->end_date);
        }

        // ================= PENCARIAN =================
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('no_beli', 'like', "%{$request->search}%")
                  ->orWhere('nm_sup', 'like', "%{$request->search}%")
                  ->orWhere('nm_brg', 'like', "%{$request->search}%");
            });
        }

        // ================= TOTAL (SEBELUM PAGINATION) =================
        $totalPembelian = (clone $query)->sum('total');

        // ================= SORTING =================
        $sort = $request->sort ?? 'tgl_beli';
        $dir  = $request->dir ?? 'desc';
        $query->orderBy($sort, $dir);

        // ================= PAGINATION =================
        $data = $query->paginate($request->per_page ?? 10)
                      ->withQueryString();

        return view('laporan.pembelian.index', compact('data', 'totalPembelian'));
    }

    // ================= EXPORT PDF =================
    public function exportPDF(Request $request)
    {
        $data = $this->getFilteredData($request)->get();
        $totalPembelian = $data->sum('total');

        $pdf = Pdf::loadView(
            'laporan.pembelian.pdf',
            compact('data', 'totalPembelian')
        )->setPaper('A4', 'portrait');

        return $pdf->download('laporan-pembelian.pdf');
    }

    // ================= EXPORT EXCEL =================
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PembelianExport($request),
            'laporan-pembelian.xlsx'
        );
    }

    // ================= QUERY FILTER BERSAMA =================
    private function getFilteredData(Request $request)
    {
        $query = ViewPembelian::query();

        if ($request->start_date) {
            $query->where('tgl_beli', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('tgl_beli', '<=', $request->end_date);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('no_beli', 'like', "%{$request->search}%")
                  ->orWhere('nm_sup', 'like', "%{$request->search}%")
                  ->orWhere('nm_brg', 'like', "%{$request->search}%");
            });
        }

        return $query;
    }
}
