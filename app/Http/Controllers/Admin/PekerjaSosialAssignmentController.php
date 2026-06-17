<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;

class PekerjaSosialAssignmentController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->get('keep_assign')) {
            $request->session()->forget([
                'assign_pekerja_sosial_id',
                'assign_no_kamar',
                'assign_selected_lansia_ids',
            ]);
        }

        $pekerjaSosials = User::whereHas('role', function ($query) {
            $query->where('name', 'pekerja_sosial');
        })->orderBy('name')->get();

        $selectedPekerjaSosialId = $request->session()->get('assign_pekerja_sosial_id');
        $selectedPekerjaSosial = $selectedPekerjaSosialId
            ? $pekerjaSosials->firstWhere('id', (int) $selectedPekerjaSosialId)
            : null;

        $rooms = Lansia::where('status', 'aktif')
            ->whereNotNull('no_kamar')
            ->where('no_kamar', '!=', '')
            ->distinct()
            ->orderBy('no_kamar')
            ->pluck('no_kamar')
            ->values();

        $selectedRoom = $request->session()->get('assign_no_kamar');

        $lansias = Lansia::where('status', 'aktif')
            ->when($selectedRoom, function ($query) use ($selectedRoom) {
                $query->where('no_kamar', $selectedRoom);
            })
            ->orderBy('nama_lengkap')
            ->get();
        $assignedLansiaIds = $selectedPekerjaSosial
            ? $selectedPekerjaSosial->lansias()->pluck('lansia.id')->toArray()
            : [];
        $sessionSelected = $selectedPekerjaSosialId
            ? $request->session()->get("assign_selected_lansia_ids.$selectedPekerjaSosialId", [])
            : [];
        $selectedLansiaIds = array_values(array_unique(array_merge($assignedLansiaIds, $sessionSelected)));

        return view('admin.riwayat-kesehatan.assign', [
            'pekerjaSosials' => $pekerjaSosials,
            'lansias' => $lansias,
            'selectedPekerjaSosial' => $selectedPekerjaSosial,
            'assignedLansiaIds' => $assignedLansiaIds,
            'selectedLansiaIds' => $selectedLansiaIds,
            'rooms' => $rooms,
            'selectedRoom' => $selectedRoom,
        ]);
    }

    public function selectPekerjaSosial(Request $request)
    {
        $data = $request->validate([
            'pekerja_sosial_id' => 'nullable|exists:users,id',
            'no_kamar' => 'nullable|string|max:50',
            'selected_lansia_ids' => 'nullable|array',
            'selected_lansia_ids.*' => 'exists:lansia,id',
        ]);

        $request->session()->put('assign_pekerja_sosial_id', $data['pekerja_sosial_id'] ?? null);
        $request->session()->put('assign_no_kamar', $data['no_kamar'] ?? null);
        if (!empty($data['pekerja_sosial_id'])) {
            $request->session()->put(
                "assign_selected_lansia_ids.{$data['pekerja_sosial_id']}",
                $data['selected_lansia_ids'] ?? []
            );
        }
        $request->session()->flash('keep_assign', true);

        return redirect()->route('admin.riwayat-kesehatan.assign');
    }

    public function resetFilter(Request $request)
    {
        $request->session()->forget(['assign_pekerja_sosial_id', 'assign_no_kamar']);

        return redirect()->route('admin.riwayat-kesehatan.assign');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pekerja_sosial_id' => 'required|exists:users,id',
            'lansia_ids' => 'nullable|array',
            'lansia_ids.*' => 'exists:lansia,id',
        ]);

        $pekerjaSosial = User::whereHas('role', function ($query) {
            $query->where('name', 'pekerja_sosial');
        })->findOrFail($data['pekerja_sosial_id']);

        $pekerjaSosial->lansias()->sync($data['lansia_ids'] ?? []);
        $request->session()->forget("assign_selected_lansia_ids.{$pekerjaSosial->id}");

        return redirect()
            ->route('admin.riwayat-kesehatan.index')
            ->with('success', 'Penugasan pekerja sosial berhasil disimpan.');
    }
}
