<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeluargaLansia;
use App\Models\Lansia;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('label')->get();

        $lansias = Lansia::orderBy('nama_lengkap')->get();

        return view('admin.users.create', compact('roles', 'lansias'));
    }

    public function store(Request $request)
    {
        $keluargaRoleId = Role::where('name', 'keluarga')->value('id');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'lansia_id' => ['nullable', 'exists:lansias,id'],
            'hubungan' => ['nullable', 'string', 'max:100'],
            'keluarga_nama_lengkap' => ['nullable', 'string', 'max:255'],
            'keluarga_no_telp' => ['nullable', 'string', 'max:20'],
            'keluarga_email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'keluarga_alamat' => ['nullable', 'string'],
        ]);

        if ((int) $data['role_id'] === (int) $keluargaRoleId && empty($data['lansia_id'])) {
            $matchedLansia = Lansia::where('nama_lengkap', $data['name'])->first();
            if ($matchedLansia) {
                $data['lansia_id'] = $matchedLansia->id;
            }
        }

        if ((int) $data['role_id'] === (int) $keluargaRoleId && empty($data['lansia_id'])) {
            throw ValidationException::withMessages([
                'lansia_id' => 'Lansia belum dipilih dan tidak ditemukan otomatis berdasarkan nama.',
            ]);
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if ((int) $data['role_id'] === (int) $keluargaRoleId) {
            KeluargaLansia::create([
                'user_id' => $user->id,
                'lansia_id' => $data['lansia_id'],
                'hubungan' => $data['hubungan'] ?? 'keluarga',
                'nama_lengkap' => $data['keluarga_nama_lengkap'] ?? $data['name'],
                'no_telp' => $data['keluarga_no_telp'] ?? ($data['phone'] ?? '-'),
                'email' => $data['keluarga_email'] ?? $data['email'],
                'alamat' => $data['keluarga_alamat'] ?? $data['address'],
                'status' => 'aktif',
            ]);
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('label')->get();

        $lansias = Lansia::orderBy('nama_lengkap')->get();
        $keluargaLansia = $user->keluargaLansia;

        return view('admin.users.edit', compact('user', 'roles', 'lansias', 'keluargaLansia'));
    }

    public function update(Request $request, User $user)
    {
        $keluargaRoleId = Role::where('name', 'keluarga')->value('id');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'lansia_id' => ['nullable', 'exists:lansias,id'],
            'hubungan' => ['nullable', 'string', 'max:100'],
            'keluarga_nama_lengkap' => ['nullable', 'string', 'max:255'],
            'keluarga_no_telp' => ['nullable', 'string', 'max:20'],
            'keluarga_email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'keluarga_alamat' => ['nullable', 'string'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if ((int) $data['role_id'] === (int) $keluargaRoleId) {
            if (empty($data['lansia_id'])) {
                $matchedLansia = Lansia::where('nama_lengkap', $data['name'])->first();
                if ($matchedLansia) {
                    $data['lansia_id'] = $matchedLansia->id;
                }
            }

            if (empty($data['lansia_id'])) {
                throw ValidationException::withMessages([
                    'lansia_id' => 'Lansia belum dipilih dan tidak ditemukan otomatis berdasarkan nama.',
                ]);
            }

            KeluargaLansia::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'lansia_id' => $data['lansia_id'],
                    'hubungan' => $data['hubungan'] ?? 'keluarga',
                    'nama_lengkap' => $data['keluarga_nama_lengkap'] ?? $data['name'],
                    'no_telp' => $data['keluarga_no_telp'] ?? ($data['phone'] ?? '-'),
                    'email' => $data['keluarga_email'] ?? $data['email'],
                    'alamat' => $data['keluarga_alamat'] ?? $data['address'],
                    'status' => 'aktif',
                ]
            );
        } else {
            KeluargaLansia::where('user_id', $user->id)->delete();
        }

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->withErrors(['user' => 'Tidak bisa menghapus akun sendiri.']);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
