<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index()
    {
        // Ambil semua data lomba untuk form pendaftaran
        $lombas = Lomba::all();

        // Ambil riwayat pendaftaran khusus untuk siswa yang sedang login, urutkan dari yang terbaru
        $riwayat = Pendaftaran::with('lomba')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.dashboard', compact('lombas', 'riwayat'));
    }

    public function daftarLomba(Request $request)
    {
        // 1. Validasi input wajib diisi
        $request->validate([
            'lomba_id' => 'required|exists:lombas,id',
            'kelas' => 'required|string|max:50',
            'no_wa' => 'required|string|max:20',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Validasi: Cegah siswa mendaftar lomba yang sama lebih dari satu kali
        $sudahDaftar = Pendaftaran::where('user_id', Auth::id())
                                  ->where('lomba_id', $request->lomba_id)
                                  ->exists();

        if ($sudahDaftar) {
            return back()->with('error', 'Gagal: Anda sudah terdaftar di mata lomba ini.');
        }

        $filePendukung = null;
        if ($request->hasFile('file_pendukung')) {
            $filePendukung = $request->file('file_pendukung')->store('file-pendukung', 'public');
        }

        // Proses simpan pendaftaran dengan status awal
        Pendaftaran::create([
            'user_id' => Auth::id(),
            'lomba_id' => $request->lomba_id,
            'kelas' => $request->kelas,
            'no_wa' => $request->no_wa,
            'file_pendukung' => $filePendukung,
            'status' => 'Dokumen dalam Tinjauan'
        ]);

        return back()->with('success', 'Berhasil mendaftar! Silakan pantau status Anda di bawah.');
    }
}
