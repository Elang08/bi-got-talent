<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Panel Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="status">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <section id="lomba" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 text-blue-600">Tambah Mata Lomba Baru</h3>
                <form action="{{ route('admin.lomba.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nama_lomba" class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Lomba</label>
                        <input id="nama_lomba" type="text" name="nama_lomba" value="{{ old('nama_lomba') }}" placeholder="Contoh: Web Design" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full" required>
                        @error('nama_lomba') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="md:col-span-2">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                            <textarea id="deskripsi" name="deskripsi" placeholder="Deskripsi lomba..." class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="kuota" class="block text-sm font-medium text-gray-700 mb-1">Kuota Peserta</label>
                            <input id="kuota" type="number" name="kuota" min="1" value="{{ old('kuota', 1) }}" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm w-full" required>
                            @error('kuota') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md shadow-sm transition duration-150">
                        Simpan Lomba
                    </button>
                </form>
            </section>

            <section id="pendaftaran" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Manajemen Status Peserta</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="border border-gray-300 p-3">Nama Siswa</th>
                                <th class="border border-gray-300 p-3">Mata Lomba</th>
                                <th class="border border-gray-300 p-3">Status Saat Ini</th>
                                <th class="border border-gray-300 p-3">Aksi Update Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendaftarans as $daftar)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 p-3">{{ $daftar->user->name ?? 'Akun tidak tersedia' }}</td>
                                    <td class="border border-gray-300 p-3 font-semibold">{{ $daftar->lomba->nama_lomba ?? 'Lomba tidak tersedia' }}</td>
                                    <td class="border border-gray-300 p-3">
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-bold">{{ $daftar->status }}</span>
                                    </td>
                                    <td class="border border-gray-300 p-3">
                                        <form action="{{ route('admin.status.update', $daftar->id) }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                                            @csrf
                                            <select name="status" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm">
                                                @foreach (['Dokumen dalam Tinjauan', 'Jadwal Briefing', 'Tahap Pelatihan', 'Final'] as $status)
                                                    <option value="{{ $status }}" @selected($daftar->status === $status)>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border border-gray-300 p-6 text-center text-gray-500">
                                        Belum ada pendaftaran peserta.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="siswa" class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Manajemen Akun Siswa</h3>
                <form action="{{ route('admin.siswa.store') }}" method="POST" class="mb-6 bg-gray-50 p-4 rounded-md border border-gray-200">
                    @csrf
                    <h4 class="font-semibold text-sm mb-3 text-blue-600">Buat Akun Siswa Baru</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap Siswa" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md w-full" required>
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email (Contoh: siswa@sekolah.com)" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md w-full" required>
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <input type="password" name="password" placeholder="Password (Minimal 8 Karakter)" class="border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md w-full" minlength="8" required>
                            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                        + Tambah Siswa
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100 text-left">
                                <th class="border border-gray-300 p-3">Nama Siswa</th>
                                <th class="border border-gray-300 p-3">Email</th>
                                <th class="border border-gray-300 p-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswas as $siswa)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 p-3">{{ $siswa->name }}</td>
                                    <td class="border border-gray-300 p-3">{{ $siswa->email }}</td>
                                    <td class="border border-gray-300 p-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                                            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin hapus akun {{ $siswa->name }}? Semua riwayat lombanya akan ikut terhapus!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="border border-gray-300 p-6 text-center text-gray-500">
                                        Belum ada akun siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
