<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupplierExport;

class SupplierController extends Controller
{
    // =========================================================
    // CRUD SUPPLIER (UNTUK DATA SUPPLIER)
    // =========================================================

    public function index(Request $request)
    {
        $query = Supplier::query();

        // SEARCH KHUSUS DATA SUPPLIER
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kd_sup', 'like', "%{$request->search}%")
                  ->orWhere('nm_sup', 'like', "%{$request->search}%")
                  ->orWhere('alamat', 'like', "%{$request->search}%")
                  ->orWhere('kota', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $data = $query->orderBy('kd_sup')->get();

        return view('supplier.index', compact('data'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'kd_sup' => 'required|unique:supplier',
            'nm_sup' => 'required',
            'alamat' => 'nullable',
            'kota'   => 'nullable',
            'kd_pos' => 'nullable',
            'phone'  => 'nullable',
            'email'  => 'nullable|email',
        ]);

        Supplier::create($req->all());

        return redirect()
            ->route('supplier.index')
            ->with('success','Supplier berhasil ditambahkan');
    }

    public function edit($id)
    {
        $s = Supplier::findOrFail($id);
        return view('supplier.edit', compact('s'));
    }

    public function update(Request $req, $id)
    {
        $req->validate([
            'nm_sup' => 'required',
            'alamat' => 'nullable',
            'kota'   => 'nullable',
            'kd_pos' => 'nullable',
            'phone'  => 'nullable',
            'email'  => 'nullable|email',
        ]);

        Supplier::findOrFail($id)->update($req->all());

        return redirect()
            ->route('supplier.index')
            ->with('success','Data supplier berhasil diperbarui');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();

        return redirect()
            ->route('supplier.index')
            ->with('success','Data supplier berhasil dihapus');
    }

    // =========================================================
    // LAPORAN SUPPLIER (KHUSUS LAPORAN)
    // =========================================================

    private function getLaporanSupplierQuery(Request $request)
    {
        $query = Supplier::query();

        // SEARCH LAPORAN
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kd_sup', 'like', "%{$request->search}%")
                  ->orWhere('nm_sup', 'like', "%{$request->search}%")
                  ->orWhere('alamat', 'like', "%{$request->search}%")
                  ->orWhere('kota', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // SORTING
        $allowed = ['kd_sup','nm_sup','alamat','kota','kd_pos','phone','email'];
        $sort = in_array($request->sort, $allowed) ? $request->sort : 'kd_sup';
        $dir  = $request->dir === 'desc' ? 'desc' : 'asc';

        return $query->orderBy($sort, $dir);
    }

    public function laporanIndex(Request $request)
    {
        $data = $this->getLaporanSupplierQuery($request)
                     ->paginate($request->per_page ?? 10)
                     ->withQueryString();

        return view('laporan.supplier.index', compact('data'));
    }

    public function laporanPdf(Request $request)
    {
        $data = $this->getLaporanSupplierQuery($request)->get();

        $pdf = Pdf::loadView('laporan.supplier.pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download(
            'laporan-supplier-' . date('Ymd_His') . '.pdf'
        );
    }

    public function laporanExcel(Request $request)
    {
        return Excel::download(
            new SupplierExport($request),
            'laporan-supplier-' . date('Ymd_His') . '.xlsx'
        );
    }
}
