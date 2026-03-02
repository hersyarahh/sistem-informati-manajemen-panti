@extends('layouts.app-karyawan')

@section('title', 'Edit Data Kesehatan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('staff.riwayat-kesehatan') }}"
           class="text-blue-600 hover:text-blue-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <ul class="text-sm text-red-600 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php $riwayat = $latestRiwayat ?? null; @endphp

    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Kesehatan Terakhir</h2>
        </div>

        @if($riwayat)
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500 mb-1">Tanggal Periksa</p>
                    <p class="font-semibold text-gray-900">{{ optional($riwayat->tanggal_periksa)->format('d F Y') ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Jenis Pemeriksaan</p>
                    <p class="font-semibold text-gray-900">{{ $riwayat->jenis_pemeriksaan ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Keluhan</p>
                    <p class="font-semibold text-gray-900">{{ $riwayat->keluhan ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Diagnosa</p>
                    <p class="font-semibold text-gray-900">{{ $riwayat->diagnosa ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Tindakan</p>
                    <p class="font-semibold text-gray-900">{{ $riwayat->tindakan ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Resep Obat</p>
                    <p class="font-semibold text-gray-900">{{ $riwayat->resep_obat ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Penanggung Jawab</p>
                    <p class="font-semibold text-gray-900">{{ $riwayat->nama_petugas ?: '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Catatan</p>
                    <p class="font-semibold text-gray-900">{{ $riwayat->catatan ?: '-' }}</p>
                </div>
            </div>

            @if (!empty($riwayat->file_hasil))
                <div class="px-6 pb-6">
                    <a href="{{ asset('storage/' . $riwayat->file_hasil) }}"
                       class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700"
                       target="_blank">
                        Lihat file hasil terakhir
                    </a>
                </div>
            @endif
        @else
            <div class="p-6 text-sm text-gray-500">
                Belum ada riwayat kesehatan yang tersimpan untuk lansia ini.
            </div>
        @endif
    </div>

    <form action="{{ route('staff.lansia.update', $lansia) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Data Kesehatan Lansia</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nama Lansia</label>
                        <input type="text" value="{{ $lansia->nama_lengkap }}" disabled
                               class="w-full px-4 py-3 border rounded-lg bg-gray-100 text-gray-600">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">No. Kamar</label>
                        <input type="text" name="no_kamar"
                               value="{{ old('no_kamar', $lansia->no_kamar) }}"
                               class="w-full px-4 py-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Kondisi</label>
                        <select name="kondisi_kesehatan" class="w-full px-4 py-3 border rounded-lg">
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="sehat" {{ old('kondisi_kesehatan', $lansia->kondisi_kesehatan) == 'sehat' ? 'selected' : '' }}>Sehat</option>
                            <option value="sakit_ringan" {{ old('kondisi_kesehatan', $lansia->kondisi_kesehatan) == 'sakit_ringan' ? 'selected' : '' }}>Sakit Ringan</option>
                            <option value="sakit_berat" {{ old('kondisi_kesehatan', $lansia->kondisi_kesehatan) == 'sakit_berat' ? 'selected' : '' }}>Sakit Berat</option>
                            <option value="perawatan_khusus" {{ old('kondisi_kesehatan', $lansia->kondisi_kesehatan) == 'perawatan_khusus' ? 'selected' : '' }}>Perawatan Khusus</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Riwayat Penyakit</label>
                        <input type="text" name="riwayat_penyakit"
                               value="{{ old('riwayat_penyakit', $lansia->riwayat_penyakit) }}"
                               class="w-full px-4 py-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Alergi</label>
                        <input type="text" name="alergi"
                               value="{{ old('alergi', $lansia->alergi) }}"
                               class="w-full px-4 py-3 border rounded-lg">
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Input Riwayat Kesehatan Baru</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Tanggal Periksa</label>
                        <input type="date" name="riwayat_tanggal_periksa"
                               value="{{ old('riwayat_tanggal_periksa') }}"
                               class="w-full px-4 py-3 border rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Jenis Pemeriksaan</label>
                        <input type="text" name="riwayat_jenis_pemeriksaan"
                               value="{{ old('riwayat_jenis_pemeriksaan') }}"
                               class="w-full h-11 px-4 border rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Keluhan</label>
                        <textarea name="riwayat_keluhan" rows="2"
                                  class="w-full h-11 px-4 border rounded-lg">{{ old('riwayat_keluhan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Diagnosa</label>
                        <textarea name="riwayat_diagnosa" rows="2"
                                  class="w-full h-11 px-4 border rounded-lg">{{ old('riwayat_diagnosa') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Tindakan</label>
                        <textarea name="riwayat_tindakan" rows="2"
                                  class="w-full h-11 px-4 border rounded-lg">{{ old('riwayat_tindakan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Resep Obat</label>
                        <textarea name="riwayat_resep_obat" rows="2"
                                  class="w-full h-11 px-4 border rounded-lg">{{ old('riwayat_resep_obat') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Penanggung Jawab</label>
                        <input type="text" name="riwayat_nama_petugas"
                               value="{{ old('riwayat_nama_petugas') }}"
                               class="w-full h-11 px-4 border rounded-lg">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Catatan</label>
                        <textarea name="riwayat_catatan" rows="2"
                                  class="w-full h-11 px-4 border rounded-lg">{{ old('riwayat_catatan') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">File Hasil (PDF/JPG/PNG)</label>
                        <input type="file" name="riwayat_file_hasil"
                               accept=".pdf,.jpg,.jpeg,.png"
                               class="w-full h-11 px-4 border rounded-lg">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('staff.riwayat-kesehatan') }}"
                   class="px-6 py-2 bg-gray-200 rounded-lg">Batal</a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg">
                    Simpan
                </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
