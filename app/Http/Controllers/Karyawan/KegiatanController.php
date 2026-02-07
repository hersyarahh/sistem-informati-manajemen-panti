<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Lansia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('karyawan.riwayat-kegiatan', [
            'kegiatans' => $kegiatans,
        ]);
    }

    public function kehadiran(Kegiatan $kegiatan)
    {
        $assignedLansias = auth()->user()
            ->lansias()
            ->where('status', 'aktif')
            ->whereDate('tanggal_masuk', '<=', $kegiatan->tanggal)
            ->orderBy('nama_lengkap')
            ->get();

        $kehadiran = Kehadiran::where('kegiatan_id', $kegiatan->id)
            ->pluck('status_kehadiran', 'lansia_id')
            ->toArray();

        $catatan = Kehadiran::where('kegiatan_id', $kegiatan->id)
            ->pluck('catatan', 'lansia_id')
            ->toArray();

        return view('karyawan.kegiatan-kehadiran', [
            'kegiatan' => $kegiatan,
            'lansias' => $assignedLansias,
            'kehadiran' => $kehadiran,
            'catatan' => $catatan,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'kehadiran' => 'required|array',
            'kehadiran.*' => 'required|in:hadir,tidak_hadir',
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string|max:500',
        ]);

        $validator->after(function ($validator) use ($request) {
            $kegiatan = Kegiatan::find($request->input('kegiatan_id'));
            if (!$kegiatan) {
                return;
            }

            $assignedIds = auth()->user()
                ->lansias()
                ->where('status', 'aktif')
                ->whereDate('tanggal_masuk', '<=', $kegiatan->tanggal)
                ->pluck('lansias.id')
                ->map(fn ($id) => (string) $id)
                ->toArray();

            $filledIds = array_keys($request->input('kehadiran', []));
            $missing = array_diff($assignedIds, $filledIds);

            if (!empty($missing)) {
                $validator->errors()->add('kehadiran', 'Semua lansia wajib dipilih hadir atau tidak hadir.');
            }
        });

        $data = $validator->validate();

        $assignedIds = auth()->user()
            ->lansias()
            ->pluck('lansias.id')
            ->toArray();

        foreach ($data['kehadiran'] as $lansiaId => $status) {
            if (!in_array((int) $lansiaId, $assignedIds, true)) {
                continue;
            }

            Kehadiran::updateOrCreate(
                [
                    'kegiatan_id' => $data['kegiatan_id'],
                    'lansia_id' => $lansiaId,
                ],
                [
                    'status_kehadiran' => $status,
                    'catatan' => $request->input("catatan.$lansiaId"),
                ]
            );
        }

        return redirect()
            ->route('staff.riwayat-kegiatan')
            ->with('success', 'Absensi berhasil disimpan.');
    }

    public function update(Request $request, Kehadiran $kehadiran)
    {
        $isAssigned = auth()->user()
            ->lansias()
            ->where('lansias.id', $kehadiran->lansia_id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'status_kehadiran' => 'nullable|in:hadir,tidak_hadir',
            'catatan' => 'nullable|string|max:500',
        ]);

        $withinLimit = $kehadiran->created_at && $kehadiran->created_at->gt(Carbon::now()->subDay());

        if ($withinLimit) {
            $kehadiran->update([
                'status_kehadiran' => $data['status_kehadiran'] ?? $kehadiran->status_kehadiran,
                'catatan' => $data['catatan'] ?? $kehadiran->catatan,
            ]);
        } else {
            // Setelah 1x24 jam hanya boleh ubah catatan
            $kehadiran->update([
                'catatan' => $data['catatan'] ?? $kehadiran->catatan,
            ]);
        }

        return redirect()
            ->route('staff.riwayat-kegiatan')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function requestCancel(Request $request, Kehadiran $kehadiran)
    {
        $isAssigned = auth()->user()
            ->lansias()
            ->where('lansias.id', $kehadiran->lansia_id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'pembatalan_alasan' => 'required|string|max:500',
        ]);

        $kehadiran->update([
            'pembatalan_diajukan_at' => now(),
            'pembatalan_alasan' => $data['pembatalan_alasan'],
        ]);

        return redirect()
            ->route('staff.riwayat-kegiatan')
            ->with('success', 'Pengajuan pembatalan tersimpan.');
    }
}
