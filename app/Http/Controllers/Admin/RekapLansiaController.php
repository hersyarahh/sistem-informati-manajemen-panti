<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\Request;

class RekapLansiaController extends Controller
{
    public function index(Request $request)
    {
        $tahun  = $request->tahun ?? now()->year;
        $status = $request->status;

        $lansias = Lansia::with('terminasi')
            ->whereYear('tanggal_masuk', $tahun)
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('tanggal_masuk', 'asc')
            ->get();

        // TOTAL LANSIA PER TAHUN 
        $totalLansia = $lansias->count();

        return view('admin.data-lansia.rekap', compact(
            'lansias',
            'tahun',
            'status',
            'totalLansia'
        ));
    }
}
