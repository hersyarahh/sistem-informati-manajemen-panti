<?php

namespace App\Http\Controllers\Keluarga;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\KeluargaLansia;
use App\Models\RiwayatKesehatan;
use Illuminate\Http\RedirectResponse;

class LansiaInfoController extends Controller
{
    public function profile()
    {
        $keluargaLansia = $this->getKeluargaLansia();
        if (!$keluargaLansia) {
            return $this->redirectNoAccess();
        }

        return view('keluarga.profile', [
            'lansia' => $keluargaLansia->lansia,
        ]);
    }

    public function kegiatan()
    {
        $keluargaLansia = $this->getKeluargaLansia();
        if (!$keluargaLansia) {
            return $this->redirectNoAccess();
        }

        $lansia = $keluargaLansia->lansia;

        $kegiatanHariIni = Kegiatan::whereDate('tanggal', today())
            ->with(['lansias' => function ($query) use ($lansia) {
                $query->where('lansia_id', $lansia->id);
            }])
            ->orderBy('waktu_mulai')
            ->get();

        return view('keluarga.kegiatan', [
            'lansia' => $lansia,
            'kegiatan_hari_ini' => $kegiatanHariIni,
        ]);
    }

    public function riwayat()
    {
        $keluargaLansia = $this->getKeluargaLansia();
        if (!$keluargaLansia) {
            return $this->redirectNoAccess();
        }

        $lansia = $keluargaLansia->lansia;

        $riwayatKesehatan = RiwayatKesehatan::where('lansia_id', $lansia->id)
            ->orderBy('tanggal_periksa', 'desc')
            ->paginate(10);

        return view('keluarga.riwayat', [
            'lansia' => $lansia,
            'riwayat_kesehatan' => $riwayatKesehatan,
        ]);
    }

    private function getKeluargaLansia(): ?KeluargaLansia
    {
        return KeluargaLansia::where('user_id', auth()->id())
            ->with('lansia')
            ->first();
    }

    private function redirectNoAccess(): RedirectResponse
    {
        return redirect()
            ->route('keluarga.dashboard')
            ->with('message', 'Anda belum terdaftar sebagai keluarga dari lansia manapun. Silakan hubungi admin.');
    }
}
