<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PekerjaSosial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PekerjaSosialController extends Controller
{
    public function index(Request $request)
    {
        $query = PekerjaSosial::query();

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status_pegawai')) {
            $query->where('status_pegawai', $request->status_pegawai);
        }

        $pekerjaSosials = $query->orderBy('nama_lengkap')
            ->paginate(6)
            ->withQueryString();

        return view('admin.pekerja-sosial.index', compact('pekerjaSosials'));
    }

    public function create()
    {
        return view('admin.pekerja-sosial.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'digits:16'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nomor_hp' => ['nullable', 'digits_between:8,20'],
            'alamat' => ['nullable', 'string'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:100'],
            'status_pegawai' => ['nullable', Rule::in(['Tetap', 'Honorer', 'Kontrak'])],
            'tanggal_mulai_bertugas' => ['nullable', 'date'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pekerja-sosial', 'public');
        }

        PekerjaSosial::create($data);

        return redirect()
            ->route('admin.pekerja-sosial.index')
            ->with('success', 'Pekerja sosial berhasil ditambahkan.');
    }

    public function show(PekerjaSosial $pekerja_sosial)
    {
        return view('admin.pekerja-sosial.show', [
            'pekerjaSosial' => $pekerja_sosial,
        ]);
    }

    public function edit(PekerjaSosial $pekerja_sosial)
    {
        return view('admin.pekerja-sosial.edit', [
            'pekerjaSosial' => $pekerja_sosial,
        ]);
    }

    public function update(Request $request, PekerjaSosial $pekerja_sosial)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'digits:16'],
            'jenis_kelamin' => ['nullable', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'nomor_hp' => ['nullable', 'digits_between:8,20'],
            'alamat' => ['nullable', 'string'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:100'],
            'status_pegawai' => ['nullable', Rule::in(['Tetap', 'Honorer', 'Kontrak'])],
            'tanggal_mulai_bertugas' => ['nullable', 'date'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($pekerja_sosial->foto) {
                Storage::disk('public')->delete($pekerja_sosial->foto);
            }
            $data['foto'] = $request->file('foto')->store('pekerja-sosial', 'public');
        }

        $pekerja_sosial->update($data);

        return redirect()
            ->route('admin.pekerja-sosial.index')
            ->with('success', 'Data pekerja sosial berhasil diperbarui.');
    }

    public function destroy(PekerjaSosial $pekerja_sosial)
    {
        if ($pekerja_sosial->foto) {
            Storage::disk('public')->delete($pekerja_sosial->foto);
        }

        $pekerja_sosial->delete();

        return redirect()
            ->route('admin.pekerja-sosial.index')
            ->with('success', 'Pekerja sosial berhasil dihapus.');
    }

    public function rekap(Request $request)
    {
        $query = PekerjaSosial::query();

        if ($request->filled('search')) {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status_pegawai')) {
            $query->where('status_pegawai', $request->status_pegawai);
        }

        $totalPekerjaSosial = (clone $query)->count();

        $pekerjaSosials = $query->orderBy('nama_lengkap')
            ->paginate(5)
            ->withQueryString();

        return view('admin.pekerja-sosial.rekap', compact(
            'pekerjaSosials',
            'totalPekerjaSosial'
        ));
    }
}
