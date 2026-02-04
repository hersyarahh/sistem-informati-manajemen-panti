<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use Illuminate\Http\Request;

class RiwayatKesehatanController extends Controller
{
    public function index(Request $request)
    {
        $lansias = Lansia::with('latestRiwayatKesehatan')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderBy('nama_lengkap')
            ->paginate(6)
            ->withQueryString();

        return view('admin.riwayat-kesehatan.index', compact('lansias'));
    }

    public function show(Lansia $lansia)
    {
        $lansia->load('latestRiwayatKesehatan');

        return view('admin.riwayat-kesehatan.show', [
            'lansia' => $lansia,
        ]);
    }
}
