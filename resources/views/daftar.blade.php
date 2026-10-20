@extends('layouts.app')

@section('title', 'Pendaftaran')

@section('content')
<!-- Header Section -->
<section class="bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 py-12 print:hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Pendaftaran Siswa Baru</h1>
            <p class="text-blue-100">Daftarkan dirimu untuk menjadi bagian dari SMA Negeri 1 Medan</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Form Container -->
            <div class="p-6 sm:p-8 md:p-10">
                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-8 rounded-r-lg">
                    <h3 class="font-semibold text-blue-900 mb-2 flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Informasi Penting</h3>
                    <ul class="text-blue-800 text-sm space-y-1">
                        <li>• Mohon isi semua field dengan data yang valid dan akurat</li>
                        <li>• Pastikan alamat email dan nomor telepon dapat dihubungi</li>
                        <li>• Anda akan menerima notifikasi status pendaftaran melalui email</li>
                    </ul>
                </div>

                <!-- Form -->
                <!-- Pesan galat dari server -->
                <div id="formAlert" role="alert" class="hidden mb-6 bg-red-50 border-l-4 border-red-600 text-red-800 p-4 rounded-r-lg text-sm"></div>

                <!-- Hasil pendaftaran (bukti cetak) -->
                <div id="hasilPendaftaran" class="hidden" aria-live="polite">
                    <div class="text-center py-6">
                        <div class="mx-auto w-14 h-14 rounded-full bg-green-100 text-green-700 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-1">Pendaftaran Berhasil</h2>
                        <p class="text-gray-600 mb-6">Simpan nomor pendaftaran berikut untuk memeriksa status Anda.</p>
                        <div class="inline-block bg-blue-50 border-2 border-blue-600 rounded-xl px-8 py-4 mb-6">
                            <p class="text-xs uppercase tracking-wide text-blue-800 font-semibold">Nomor Pendaftaran</p>
                            <p id="hasilNomor" class="text-3xl font-mono font-bold tracking-widest text-blue-900"></p>
                        </div>
                        <dl class="text-left max-w-sm mx-auto text-sm space-y-2 mb-8">
                            <div class="flex justify-between gap-4"><dt class="text-gray-500">Nama</dt><dd id="hasilNama" class="font-semibold text-gray-900 text-right"></dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-gray-500">Program</dt><dd id="hasilProgram" class="font-semibold text-gray-900 text-right"></dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-gray-500">Jalur</dt><dd id="hasilJalur" class="font-semibold text-gray-900 text-right"></dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-gray-500">Status</dt><dd id="hasilStatus" class="font-semibold text-gray-900 text-right"></dd></div>
                            <div class="flex justify-between gap-4"><dt class="text-gray-500">Tanggal daftar</dt><dd id="hasilTanggal" class="font-semibold text-gray-900 text-right"></dd></div>
                        </dl>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center print:hidden">
                            <button type="button" id="tombolCetak" class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition-all">Cetak Bukti</button>
                            <a href="/cek-status" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all">Cek Status</a>
                        </div>
                    </div>
                </div>

                <form id="registrationForm" data-api-form class="space-y-8">

                    <!-- Section 1: Data Pribadi -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-blue-600">
                            Data Pribadi
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nama_lengkap" 
                                    name="nama_lengkap" 
                                    required
                                    placeholder="Masukkan nama lengkap sesuai akta kelahiran"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="gender" 
                                    name="gender" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- Tempat Lahir -->
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tempat Lahir <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="tempat_lahir" 
                                    name="tempat_lahir" 
                                    required
                                    placeholder="Kota tempat lahir"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Lahir <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="tanggal_lahir" 
                                    name="tanggal_lahir" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- NISN -->
                            <div>
                                <label for="nisn" class="block text-sm font-semibold text-gray-700 mb-2">
                                    NISN <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nisn" 
                                    name="nisn" 
                                    required
                                    placeholder="10 digit NISN"
                                    maxlength="10"
                                    pattern="[0-9]{10}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>


                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">
                                    NIK <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nik" 
                                    name="nik" 
                                    required
                                    placeholder="16 digit NIK"
                                    maxlength="16"
                                    pattern="[0-9]{16}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Agama -->
                            <div>
                                <label for="agama" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="agama" 
                                    name="agama" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="islam">Islam</option>
                                    <option value="kristen">Kristen Protestan</option>
                                    <option value="katolik">Kristen Katolik</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="buddha">Buddha</option>
                                    <option value="konghucu">Konghucu</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Data Kontak -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-blue-600">
                            Data Kontak
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    required
                                    placeholder="example@email.com"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="telepon" 
                                    name="telepon" 
                                    required
                                    placeholder="0812-3456-7890"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Alamat -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    id="alamat" 
                                    name="alamat" 
                                    required
                                    rows="3"
                                    placeholder="Jl. nama jalan No. X, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                ></textarea>
                            </div>

                            <!-- Kota -->
                            <div>
                                <label for="kota" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Kota <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="kota" 
                                    name="kota" 
                                    required
                                    placeholder="Medan"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Provinsi -->
                            <div>
                                <label for="provinsi" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="provinsi" 
                                    name="provinsi" 
                                    required
                                    placeholder="Sumatera Utara"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Data Orang Tua/Wali -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-blue-600">
                            Data Orang Tua / Wali
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Ayah -->
                            <div>
                                <label for="nama_ayah" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Ayah <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nama_ayah" 
                                    name="nama_ayah" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Pekerjaan Ayah -->
                            <div>
                                <label for="pekerjaan_ayah" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pekerjaan Ayah <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pekerjaan_ayah" 
                                    name="pekerjaan_ayah" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Nama Ibu -->
                            <div>
                                <label for="nama_ibu" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Ibu <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="nama_ibu" 
                                    name="nama_ibu" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Pekerjaan Ibu -->
                            <div>
                                <label for="pekerjaan_ibu" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pekerjaan Ibu <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="pekerjaan_ibu" 
                                    name="pekerjaan_ibu" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Nomor Telepon Orang Tua -->
                            <div class="md:col-span-2">
                                <label for="telepon_ortu" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Telepon Orang Tua <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="tel" 
                                    id="telepon_ortu" 
                                    name="telepon_ortu" 
                                    required
                                    placeholder="0812-3456-7890"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Data Pendidikan -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-blue-600">
                            Data Pendidikan
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Asal Sekolah -->
                            <div class="md:col-span-2">
                                <label for="asal_sekolah" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Asal Sekolah <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="asal_sekolah" 
                                    name="asal_sekolah" 
                                    required
                                    placeholder="Nama SMP/MTs"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Nilai Rata-rata -->
                            <div>
                                <label for="nilai_rata" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nilai Rata-rata <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="nilai_rata" 
                                    name="nilai_rata" 
                                    required
                                    step="0.01"
                                    min="0"
                                    max="100"
                                    placeholder="0.00"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Tahun Lulus -->
                            <div>
                                <label for="tahun_lulus" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tahun Lulus <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="tahun_lulus" 
                                    name="tahun_lulus" 
                                    required
                                    min="2020"
                                    max="{{ date('Y') }}"
                                    placeholder="{{ date('Y') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                            </div>

                            <!-- Pilihan Program -->
                            <div class="md:col-span-2">
                                <label for="program" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Pilihan Program <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="program" 
                                    name="program" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                                    <option value="">-- Pilih Program --</option>
                                    <option value="ipa">Program IPA (Sains)</option>
                                    <option value="ips">Program IPS (Sosial)</option>
                                    <option value="bahasa">Program Bahasa</option>
                                </select>
                            </div>


                            <!-- Jalur Pendaftaran -->
                            <div class="md:col-span-2">
                                <label for="jalur_pendaftaran" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jalur Pendaftaran <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="jalur_pendaftaran" 
                                    name="jalur_pendaftaran" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                >
                                    <option value="">-- Pilih Jalur --</option>
                                    <option value="Zonasi">Zonasi</option>
                                    <option value="Afirmasi">Afirmasi</option>
                                    <option value="Prestasi">Prestasi</option>
                                    <option value="Perpindahan Tugas">Perpindahan Tugas</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Pernyataan & Konfirmasi -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-blue-600">
                            Pernyataan & Konfirmasi
                        </h2>

                        <div class="space-y-4">
                            <!-- Checkbox 1 -->
                            <label class="flex items-start cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <input 
                                    type="checkbox" 
                                    name="confirm_data" 
                                    required
                                    class="mt-1 w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                                >
                                <span class="ml-3 text-gray-700">
                                    Saya menyatakan bahwa data yang saya masukkan adalah benar, akurat, dan tidak ada yang disembunyikan
                                </span>
                            </label>

                            <!-- Checkbox 2 -->
                            <label class="flex items-start cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <input 
                                    type="checkbox" 
                                    name="agree_terms" 
                                    required
                                    class="mt-1 w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                                >
                                <span class="ml-3 text-gray-700">
                                    Saya setuju dengan tata tertib dan peraturan yang berlaku di SMA Negeri 1 Medan
                                </span>
                            </label>

                            <!-- Checkbox 3 -->
                            <label class="flex items-start cursor-pointer p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <input 
                                    type="checkbox" 
                                    name="agree_privacy" 
                                    required
                                    class="mt-1 w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                                >
                                <span class="ml-3 text-gray-700">
                                    Saya memberi izin penggunaan data pribadi saya untuk keperluan administrasi pendidikan
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t-2 border-gray-200">
                        <button 
                            type="reset" 
                            class="flex-1 px-6 py-3 border-2 border-gray-400 text-gray-700 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300"
                        >
                            Bersihkan
                        </button>
                        <button 
                            type="submit" 
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-cyan-600 transition-all duration-300 hover:shadow-lg active:scale-95"
                        >
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- FAQ -->
        <div class="mt-12 bg-white rounded-2xl shadow-lg p-8 print:hidden">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Pertanyaan Umum (FAQ)</h2>
            
            <div class="space-y-6">
                <!-- FAQ 1 -->
                <details class="group cursor-pointer">
                    <summary class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors select-none font-semibold text-gray-900">
                        <span>Kapan pendaftaran dibuka?</span>
                        <span class="transform group-open:rotate-180 transition-transform"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></span>
                    </summary>
                    <p class="p-4 text-gray-600 border-t">
                        Pendaftaran siswa baru dibuka setiap tahun biasanya pada bulan April hingga Juni. Silakan hubungi sekolah untuk jadwal pendaftaran terbaru.
                    </p>
                </details>

                <!-- FAQ 2 -->
                <details class="group cursor-pointer">
                    <summary class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors select-none font-semibold text-gray-900">
                        <span>Apa syarat untuk mendaftar?</span>
                        <span class="transform group-open:rotate-180 transition-transform"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></span>
                    </summary>
                    <p class="p-4 text-gray-600 border-t">
                        Peserta didik harus telah menyelesaikan pendidikan SMP/MTs dan memiliki ijazah. Kami juga menerima peserta didik yang sedang mengikuti ujian nasional.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details class="group cursor-pointer">
                    <summary class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors select-none font-semibold text-gray-900">
                        <span>Apakah ada tes masuk?</span>
                        <span class="transform group-open:rotate-180 transition-transform"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></span>
                    </summary>
                    <p class="p-4 text-gray-600 border-t">
                        Ya, setelah pendaftaran online, peserta akan mengikuti tes akademik dan wawancara. Jadwal tes akan dikirimkan melalui email Anda.
                    </p>
                </details>

                <!-- FAQ 4 -->
                <details class="group cursor-pointer">
                    <summary class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors select-none font-semibold text-gray-900">
                        <span>Bagaimana cara pembayaran?</span>
                        <span class="transform group-open:rotate-180 transition-transform"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg></span>
                    </summary>
                    <p class="p-4 text-gray-600 border-t">
                        Pembayaran dapat dilakukan melalui transfer bank, cicilan, atau skema beasiswa untuk yang memenuhi syarat. Hubungi bagian keuangan untuk informasi lebih detail.
                    </p>
                </details>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('registrationForm');
    if (!form) return;

    const kotakGalat = document.getElementById('formAlert');
    const panelHasil = document.getElementById('hasilPendaftaran');
    const tombolKirim = form.querySelector('button[type="submit"]');

    function tampilkanGalat(daftar) {
        kotakGalat.replaceChildren();
        const ul = document.createElement('ul');
        ul.className = 'list-disc pl-5 space-y-1';
        daftar.forEach(function (pesan) {
            const li = document.createElement('li');
            li.textContent = pesan; // textContent: aman dari XSS
            ul.appendChild(li);
        });
        kotakGalat.appendChild(ul);
        kotakGalat.classList.remove('hidden');
        kotakGalat.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function isi(id, teks) { document.getElementById(id).textContent = teks; }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!form.checkValidity()) { form.reportValidity(); return; }
        kotakGalat.classList.add('hidden');

        const data = Object.fromEntries(new FormData(form).entries());
        data.persetujuan = ['confirm_data', 'agree_terms', 'agree_privacy']
            .every(function (n) { return form.elements[n].checked; });
        ['confirm_data', 'agree_terms', 'agree_privacy'].forEach(function (n) { delete data[n]; });

        const labelAsli = tombolKirim.textContent;
        tombolKirim.disabled = true;
        tombolKirim.textContent = 'Mengirim...';

        try {
            const res = await fetch('/api/v1/spmb/daftar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify(data)
            });
            const json = await res.json().catch(function () { return {}; });

            if (res.status === 201) {
                const d = json.data;
                isi('hasilNomor', d.nomor_pendaftaran);
                isi('hasilNama', d.nama_lengkap);
                isi('hasilProgram', String(d.program).toUpperCase());
                isi('hasilJalur', d.jalur_pendaftaran);
                isi('hasilStatus', d.label_status);
                isi('hasilTanggal', new Date(d.tanggal_daftar).toLocaleString('id-ID'));
                form.classList.add('hidden');
                panelHasil.classList.remove('hidden');
                panelHasil.scrollIntoView({ behavior: 'smooth', block: 'start' });
            } else if (res.status === 422 && json.errors) {
                tampilkanGalat(Object.values(json.errors).flat());
            } else {
                tampilkanGalat([json.message || 'Terjadi kesalahan pada server. Coba lagi nanti.']);
            }
        } catch (err) {
            tampilkanGalat(['Tidak dapat terhubung ke server. Periksa koneksi internet Anda.']);
        } finally {
            tombolKirim.disabled = false;
            tombolKirim.textContent = labelAsli;
        }
    });

    document.getElementById('tombolCetak').addEventListener('click', function () { window.print(); });
})();
</script>
@endpush
