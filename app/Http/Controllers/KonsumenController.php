<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KonsumenExport;

class KonsumenController extends Controller
{
    // ======================
    // DATA KONSUMEN (CRUD)
    // ======================

    public function index(Request $request)
    {
        $query = Konsumen::query();

        // SEARCH KHUSUS DATA KONSUMEN
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kd_kons', 'like', "%{$request->search}%")
                  ->orWhere('nm_kons', 'like', "%{$request->search}%")
                  ->orWhere('alm_kons', 'like', "%{$request->search}%")
                  ->orWhere('kota_kons', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $data = $query->orderBy('kd_kons')->get();

        return view('konsumen.index', compact('data'));
    }

    public function create()
    {
        return view('konsumen.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'kd_kons'   => 'required|unique:konsumen',
            'nm_kons'   => 'required',
            'alm_kons'  => 'nullable',
            'kota_kons' => 'nullable',
            'kd_pos'    => 'nullable',
            'phone'     => 'nullable',
            'email'     => 'nullable|email',
        ]);

        Konsumen::create($req->all());

        return redirect()
            ->route('konsumen.index')
            ->with('success', 'Konsumen berhasil ditambahkan');
    }

    public function edit($id)
    {
        $k = Konsumen::findOrFail($id);
        return view('konsumen.edit', compact('k'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'nm_kons' => 'required'
        ]);

        Konsumen::findOrFail($id)->update($req->all());

        return redirect()
            ->route('konsumen.index')
            ->with('success', 'Data konsumen berhasil diperbarui');
    }

    public function destroy($id)
    {
        Konsumen::findOrFail($id)->delete();

        return redirect()
            ->route('konsumen.index')
            ->with('success', 'Data konsumen berhasil dihapus');
    }

    // ======================
    // LAPORAN KONSUMEN
    // ======================

    private function laporanQuery(Request $request)
    {
        $query = Konsumen::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kd_kons', 'like', "%{$request->search}%")
                  ->orWhere('nm_kons', 'like', "%{$request->search}%")
                  ->orWhere('alm_kons', 'like', "%{$request->search}%")
                  ->orWhere('kota_kons', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        return $query->orderBy('kd_kons');
    }

    public function laporanIndex(Request $request)
    {
        $data = $this->laporanQuery($request)
                     ->paginate(10)
                     ->withQueryString();

        return view('laporan.konsumen.index', compact('data'));
    }

    public function laporanPdf(Request $request)
    {
        $data = $this->laporanQuery($request)->get();

        $pdf = Pdf::loadView('laporan.konsumen.pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-konsumen.pdf');
    }

    public function laporanExcel(Request $request)
    {
        return Excel::download(
            new KonsumenExport($request),
            'laporan-konsumen.xlsx'
        );
    }
}
