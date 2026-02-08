<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\LansiaRekapExport;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapLansiaController extends Controller
{
    public function index(Request $request)
    {
        $tahun  = $request->tahun ?? now()->year;
        $bulan  = $request->bulan;
        $status = $request->status;

        $query = Lansia::with('terminasi')
            ->whereYear('tanggal_masuk', $tahun)
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('tanggal_masuk', $bulan);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            });

        // TOTAL LANSIA PER TAHUN 
        $totalLansia = (clone $query)->count();

        $lansias = $query
            ->orderBy('tanggal_masuk', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.data-lansia.rekap', compact(
            'lansias',
            'tahun',
            'bulan',
            'status',
            'totalLansia'
        ));
    }

    public function exportExcel(Request $request)
    {
        $tahun  = $request->tahun ?? now()->year;
        $bulan  = $request->bulan;
        $status = $request->status;

        $filename = 'rekap-lansia-' . $tahun;
        if (!empty($bulan)) {
            $filename .= '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
        }
        $filename .= '.xlsx';

        return Excel::download(new LansiaRekapExport($tahun, $bulan, $status), $filename);
    }
}
