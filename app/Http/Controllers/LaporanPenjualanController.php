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
// Filter tanggal
if ($request->start_date) {
$query->where('tgl_jual', '>=', $request->start_date);
}
if ($request->end_date) {
$query->where('tgl_jual', '<=', $request->end_date);
}
// Pencarian global
if ($request->search) {
$query->where(function($q) use ($request) {
$q->where('nm_kons', 'like', '%' . $request->search . '%')
->orWhere('nm_brg', 'like', '%' . $request->search . '%')
->orWhere('no_jual', 'like', '%' . $request->search . '%');
});
}
// === SORTING ===
$sort = $request->sort ?? 'tgl_jual';
$dir = $request->dir ?? 'desc';
$query->orderBy($sort, $dir);
$data = $query->paginate($request->per_page ?? 10)->withQueryString();
return view('laporan.penjualan.index', compact('data'));
}
// EXPORT PDF
public function exportPDF(Request $request)
{
$data = $this->getFilteredData($request)->get();
$pdf = Pdf::loadView('laporan.penjualan.pdf', compact('data'));
return $pdf->download('laporan-penjualan.pdf');
}
// EXPORT EXCEL
public function exportExcel(Request $request)
{
return Excel::download(new PenjualanExport($request), 'laporan-penjualan.xlsx');
}
private function getFilteredData($request)
{
$query = ViewPenjualan::query();
if ($request->start_date) {$query->where('tgl_jual', '>=', $request->start_date);}
if ($request->end_date) {
$query->where('tgl_jual', '<=', $request->end_date);
}
if ($request->search) {
$query->where(function($q) use ($request) {
$q->where('nm_kons', 'like', '%' . $request->search . '%')
->orWhere('nm_brg', 'like', '%' . $request->search . '%')
->orWhere('no_jual', 'like', '%' . $request->search . '%');
});
}
return $query;
}
}