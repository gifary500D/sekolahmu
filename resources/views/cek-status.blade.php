@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran')

@section('content')
<section class="bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <h1 class="text-3xl md:text-4xl font-bold mb-2">Cek Status Pendaftaran</h1>
        <p class="text-blue-100">Masukkan nomor pendaftaran 8 karakter yang Anda terima saat mendaftar</p>
    </div>
</section>

<section class="py-12 bg-gray-50 min-h-[60vh]">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8">
            <form id="formStatus" class="space-y-4" novalidate>
                <label for="nomor" class="block text-sm font-semibold text-gray-700">Nomor Pendaftaran</label>
                <input
                    type="text"
                    id="nomor"
                    name="nomor"
                    maxlength="8"
                    autocomplete="off"
                    autocapitalize="characters"
                    spellcheck="false"
                    placeholder="Contoh: K7M2Q9XA"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg font-mono tracking-widest uppercase focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                <button type="submit" id="tombolCari" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-all">
                    Periksa Status
                </button>
            </form>

            <p id="pesanStatus" role="alert" class="hidden mt-6 bg-red-50 border-l-4 border-red-600 text-red-800 p-4 rounded-r-lg text-sm"></p>

            <div id="hasilStatus" class="hidden mt-8 border-t pt-6" aria-live="polite">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-gray-500">Nomor</dt><dd id="sNomor" class="font-mono font-semibold text-gray-900"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-gray-500">Nama</dt><dd id="sNama" class="font-semibold text-gray-900"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-gray-500">Program</dt><dd id="sProgram" class="font-semibold text-gray-900"></dd></div>
                    <div class="flex justify-between gap-4 items-center"><dt class="text-gray-500">Status</dt><dd><span id="sStatus" class="inline-block px-3 py-1 rounded-full text-xs font-bold"></span></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-gray-500">Diperbarui</dt><dd id="sTanggal" class="font-semibold text-gray-900"></dd></div>
                </dl>
                <div id="blokCatatan" class="hidden mt-5 bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-lg text-sm text-amber-900">
                    <p class="font-semibold mb-1">Catatan dari panitia</p>
                    <p id="sCatatan"></p>
                </div>
            </div>
        </div>
        <p class="text-xs text-gray-500 text-center mt-4">Demi privasi, nama ditampilkan tersamar dan data pribadi lain tidak ditampilkan.</p>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('formStatus');
    const input = document.getElementById('nomor');
    const pesan = document.getElementById('pesanStatus');
    const hasil = document.getElementById('hasilStatus');
    const tombol = document.getElementById('tombolCari');

    const warna = {
        menunggu: 'bg-gray-100 text-gray-800',
        diverifikasi: 'bg-blue-100 text-blue-800',
        perlu_perbaikan: 'bg-amber-100 text-amber-800',
        lulus: 'bg-green-100 text-green-800',
        tidak_lulus: 'bg-red-100 text-red-800'
    };

    function isi(id, teks) { document.getElementById(id).textContent = teks; }
    function tampilPesan(teks) { pesan.textContent = teks; pesan.classList.remove('hidden'); hasil.classList.add('hidden'); }

    input.addEventListener('input', function () { input.value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, ''); });

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        pesan.classList.add('hidden');
        hasil.classList.add('hidden');

        const nomor = input.value.trim();
        if (!/^[A-Z0-9]{8}$/.test(nomor)) { tampilPesan('Nomor pendaftaran harus 8 huruf atau angka.'); return; }

        tombol.disabled = true;
        const label = tombol.textContent;
        tombol.textContent = 'Memeriksa...';
        try {
            const res = await fetch('/api/v1/spmb/status/' + encodeURIComponent(nomor), { headers: { 'Accept': 'application/json' } });
            const json = await res.json().catch(function () { return {}; });
            if (res.ok) {
                const d = json.data;
                isi('sNomor', d.nomor_pendaftaran);
                isi('sNama', d.nama);
                isi('sProgram', String(d.program).toUpperCase());
                isi('sTanggal', new Date(d.diperbarui_pada).toLocaleString('id-ID'));
                const badge = document.getElementById('sStatus');
                badge.textContent = d.label_status;
                badge.className = 'inline-block px-3 py-1 rounded-full text-xs font-bold ' + (warna[d.status] || warna.menunggu);
                document.getElementById('blokCatatan').classList.toggle('hidden', !d.catatan);
                isi('sCatatan', d.catatan || '');
                hasil.classList.remove('hidden');
            } else if (res.status === 404) {
                tampilPesan('Nomor pendaftaran tidak ditemukan. Periksa kembali penulisannya.');
            } else if (res.status === 429) {
                tampilPesan('Terlalu banyak percobaan. Tunggu sebentar lalu coba lagi.');
            } else {
                tampilPesan('Terjadi kesalahan pada server. Coba lagi nanti.');
            }
        } catch (err) {
            tampilPesan('Tidak dapat terhubung ke server. Periksa koneksi internet Anda.');
        } finally {
            tombol.disabled = false;
            tombol.textContent = label;
        }
    });
})();
</script>
@endpush
