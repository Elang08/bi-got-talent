<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="talent-page-kicker !text-purple-600">MANAJEMEN PESERTA</p>
            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-gray-800">Edit akun siswa</h2>
        </div>
    </x-slot>

    <div class="talent-page !max-w-3xl">
        <div class="talent-panel">
            <div class="talent-panel-heading">
                <div>
                    <h2>{{ $siswa->name }}</h2>
                    <p>Perbarui informasi akun siswa di bawah ini.</p>
                </div>
                <span class="talent-panel-icon" aria-hidden="true">♙</span>
            </div>

            <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="talent-field">
                    <label for="name">Nama lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $siswa->name) }}" required>
                    @error('name') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="talent-field">
                    <label for="email">Alamat email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $siswa->email) }}" required>
                    @error('email') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="talent-field rounded-xl border border-amber-100 bg-amber-50/70 p-4">
                    <label for="password">Ubah password <span class="font-normal text-gray-400">(opsional)</span></label>
                    <p class="talent-muted">Kosongkan jika tidak ingin mengubah password siswa.</p>
                    <input id="password" type="password" name="password" minlength="8" autocomplete="new-password" placeholder="Ketik password baru">
                    @error('password') <span class="text-xs text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <button type="submit" class="talent-primary-button">Simpan perubahan <span aria-hidden="true">→</span></button>
                    <a href="{{ route('admin.dashboard') }}#siswa" class="text-sm font-semibold text-gray-500 hover:text-purple-700">Kembali ke dashboard</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
