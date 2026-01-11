<?php

namespace App\Http\Controllers;

use App\Models\ViewPenjualan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenjualanExport;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $query = ViewPenjualan::query();

        // FILTER TANGGAL
        if ($request->start_date) {
            $query->where('tgl_jual', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('tgl_jual', '<=', $request->end_date);
        }

        // PENCARIAN
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nm_kons', 'like', "%{$request->search}%")
                  ->orWhere('nm_brg', 'like', "%{$request->search}%")
                  ->orWhere('no_jual', 'like', "%{$request->search}%");
            });
        }

        // TOTAL (SEBELUM PAGINATION)
        $totalPenjualan = (clone $query)->sum('total');

        // SORTING
        $sort = $request->sort ?? 'tgl_jual';
        $dir  = $request->dir ?? 'desc';
        $query->orderBy($sort, $dir);

        // PAGINATION
        $data = $query->paginate($request->per_page ?? 10)
                      ->withQueryString();

        return view('laporan.penjualan.index', compact('data', 'totalPenjualan'));
    }

    // EXPORT PDF
    public function exportPDF(Request $request)
    {
        $data = $this->getFilteredData($request)->get();
        $totalPenjualan = $data->sum('total');

        $pdf = Pdf::loadView('laporan.penjualan.pdf', compact('data', 'totalPenjualan'))
                  ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-penjualan.pdf');
    }

    // EXPORT EXCEL
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PenjualanExport($request),
            'laporan-penjualan.xlsx'
        );
    }

    // QUERY FILTER BERSAMA
    private function getFilteredData(Request $request)
    {
        $query = ViewPenjualan::query();

        if ($request->start_date) {
            $query->where('tgl_jual', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('tgl_jual', '<=', $request->end_date);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nm_kons', 'like', "%{$request->search}%")
                  ->orWhere('nm_brg', 'like', "%{$request->search}%")
                  ->orWhere('no_jual', 'like', "%{$request->search}%");
            });
        }

        return $query;
    }
}
