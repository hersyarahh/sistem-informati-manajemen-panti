<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lansia;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanAssignmentController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->session()->get('keep_assign')) {
            $request->session()->forget([
                'assign_staff_id',
                'assign_no_kamar',
                'assign_selected_lansia_ids',
            ]);
        }

        $staffs = User::whereHas('role', function ($query) {
            $query->where('name', 'karyawan');
        })->orderBy('name')->get();

        $selectedStaffId = $request->session()->get('assign_staff_id');
        $selectedStaff = $selectedStaffId
            ? $staffs->firstWhere('id', (int) $selectedStaffId)
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
        $assignedLansiaIds = $selectedStaff
            ? $selectedStaff->lansias()->pluck('lansias.id')->toArray()
            : [];
        $sessionSelected = $selectedStaffId
            ? $request->session()->get("assign_selected_lansia_ids.$selectedStaffId", [])
            : [];
        $selectedLansiaIds = array_values(array_unique(array_merge($assignedLansiaIds, $sessionSelected)));

        return view('admin.riwayat-kesehatan.assign', [
            'staffs' => $staffs,
            'lansias' => $lansias,
            'selectedStaff' => $selectedStaff,
            'assignedLansiaIds' => $assignedLansiaIds,
            'selectedLansiaIds' => $selectedLansiaIds,
            'rooms' => $rooms,
            'selectedRoom' => $selectedRoom,
        ]);
    }

    public function selectStaff(Request $request)
    {
        $data = $request->validate([
            'staff_id' => 'nullable|exists:users,id',
            'no_kamar' => 'nullable|string|max:50',
            'selected_lansia_ids' => 'nullable|array',
            'selected_lansia_ids.*' => 'exists:lansias,id',
        ]);

        $request->session()->put('assign_staff_id', $data['staff_id'] ?? null);
        $request->session()->put('assign_no_kamar', $data['no_kamar'] ?? null);
        if (!empty($data['staff_id'])) {
            $request->session()->put(
                "assign_selected_lansia_ids.{$data['staff_id']}",
                $data['selected_lansia_ids'] ?? []
            );
        }
        $request->session()->flash('keep_assign', true);

        return redirect()->route('admin.riwayat-kesehatan.assign');
    }

    public function resetFilter(Request $request)
    {
        $request->session()->forget(['assign_staff_id', 'assign_no_kamar']);

        return redirect()->route('admin.riwayat-kesehatan.assign');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_id' => 'required|exists:users,id',
            'lansia_ids' => 'nullable|array',
            'lansia_ids.*' => 'exists:lansias,id',
        ]);

        $staff = User::whereHas('role', function ($query) {
            $query->where('name', 'karyawan');
        })->findOrFail($data['staff_id']);

        $staff->lansias()->sync($data['lansia_ids'] ?? []);
        $request->session()->forget("assign_selected_lansia_ids.{$staff->id}");

        return redirect()
            ->route('admin.riwayat-kesehatan.index')
            ->with('success', 'Penugasan pekerja sosial berhasil disimpan.');
    }
}
