<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Peserta: {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-sm" role="status">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-sm" role="alert">
                    <p class="font-bold">Perhatian</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                    <p class="font-bold">Periksa kembali data pendaftaran.</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section id="daftar" class="p-6 bg-white shadow sm:rounded-lg border-t-4 border-blue-600">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Formulir Pendaftaran Lomba</h3>
                @if ($lombas->isNotEmpty())
                    <form action="{{ route('siswa.daftar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="lomba_id" class="block text-sm font-bold text-gray-700 mb-2">Pilih Kategori Lomba *</label>
                                <select id="lomba_id" name="lomba_id" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full bg-gray-50" required>
                                    <option value="">-- Silakan Pilih --</option>
                                    @foreach ($lombas as $lomba)
                                        <option value="{{ $lomba->id }}" @selected(old('lomba_id') == $lomba->id)>{{ $lomba->nama_lomba }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="kelas" class="block text-sm font-bold text-gray-700 mb-2">Asal Kelas *</label>
                                <input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: X TKJ" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full" required>
                            </div>
                            <div>
                                <label for="no_wa" class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp Aktif *</label>
                                <input id="no_wa" type="tel" name="no_wa" value="{{ old('no_wa') }}" placeholder="Contoh: 081234567890" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full" required>
                                <p class="text-xs text-gray-500 mt-1">Pastikan nomor aktif untuk undangan grup koordinasi.</p>
                            </div>
                            <div>
                                <label for="file_pendukung" class="block text-sm font-bold text-gray-700 mb-2">File Pendukung (Opsional)</label>
                                <input id="file_pendukung" type="file" name="file_pendukung" accept=".pdf,.jpg,.jpeg,.png" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full">
                                <p class="text-xs text-gray-500 mt-1">Format PDF/JPG/PNG, maksimal 2 MB.</p>
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md shadow transition duration-150 mt-2">
                            Kirim Formulir Pendaftaran
                        </button>
                    </form>
                @else
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-md border border-dashed border-gray-300">
                        <p>Belum ada mata lomba yang tersedia. Silakan cek kembali nanti.</p>
                    </div>
                @endif
            </section>

            <section class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-6 text-gray-800">Riwayat &amp; Tracking Status</h3>
                @if ($riwayat->isEmpty())
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-md border border-dashed border-gray-300">
                        <p>Anda belum mendaftar perlombaan apa pun.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($riwayat as $item)
                            @php
                                $accentClass = match ($item->status) {
                                    'Jadwal Briefing' => 'bg-blue-500',
                                    'Final' => 'bg-green-500',
                                    'Tahap Pelatihan' => 'bg-purple-500',
                                    default => 'bg-gray-400',
                                };
                            @endphp
                            <article class="border border-gray-200 rounded-lg p-5 shadow-sm hover:shadow-md transition relative overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-1 {{ $accentClass }}" aria-hidden="true"></div>
                                <h4 class="font-bold text-xl text-gray-800 mb-1">{{ $item->lomba->nama_lomba ?? 'Lomba tidak tersedia' }}</h4>
                                <p class="text-sm text-gray-500 mb-4">Tanggal Daftar: {{ $item->created_at->format('d M Y') }}</p>
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-600 mb-1 font-medium">Status Progres Terkini:</span>
                                    @switch($item->status)
                                        @case('Dokumen dalam Tinjauan')
                                            <span class="inline-flex w-fit items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">Sedang Ditinjau Juri</span>
                                            @break
                                        @case('Jadwal Briefing')
                                            <span class="inline-flex w-fit items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 border border-blue-200">Menunggu Undangan Briefing</span>
                                            @break
                                        @case('Tahap Pelatihan')
                                            <span class="inline-flex w-fit items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800 border border-purple-200">Tahap Pelatihan</span>
                                            @break
                                        @case('Final')
                                            <span class="inline-flex w-fit items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">Lolos ke Final!</span>
                                            @break
                                        @default
                                            <span class="inline-flex w-fit items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">{{ $item->status }}</span>
                                    @endswitch
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>
