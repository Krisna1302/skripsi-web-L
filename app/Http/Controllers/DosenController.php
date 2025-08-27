<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class DosenController extends Controller
{
    // ==============================
    // DASHBOARD DOSEN
    // ==============================
    public function dashboard()
    {
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => 'Data dosen tidak ditemukan.']);
        }

        // ==============================
        // Hitung jumlah pengajuan untuk dosen ini
        // ==============================
        $jumlah_menunggu = Pengajuan::where('pembimbing', $dosen->nama)
            ->where('status', 'Menunggu')
            ->count();

        $jumlah_diterima = Pengajuan::where('pembimbing', $dosen->nama)
            ->where('status', 'Diterima')
            ->count();

        $jumlah_ditolak = Pengajuan::where('pembimbing', $dosen->nama)
            ->where('status', 'Ditolak')
            ->count();

        return view('dashboard.dosen', compact(
            'dosen',
            'jumlah_menunggu',
            'jumlah_diterima',
            'jumlah_ditolak'
        ));
    }

    // ==============================
    // DATA PENGAJUAN MENUNGGU
    // ==============================
    public function dataPengajuan(Request $request)
    {
        $dosen = Auth::user()->dosen;
        if (!$dosen) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['error' => 'Data dosen tidak ditemukan. Pastikan akun Anda terhubung dengan data dosen.']);
        }

        // ==============================
        // Ambil daftar mahasiswa dan bidang
        // ==============================
        $nama_mahasiswa = Mahasiswa::pluck('nama');
        $bidang_mahasiswa = Mahasiswa::select('prodi')->distinct()->pluck('prodi');

        // ==============================
        // Query pengajuan menunggu untuk dosen ini
        // ==============================
        $query = Pengajuan::with('mahasiswa')
            ->where('pembimbing', $dosen->nama)
            ->where('status', 'Menunggu');

        // ==============================
        // Filter berdasarkan input request
        // ==============================
        if ($request->filled('nama')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('nama', $request->nama);
            });
        }

        if ($request->filled('bidang')) {
            $query->whereHas('mahasiswa', function ($q) use ($request) {
                $q->where('prodi', $request->bidang);
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->nim) {
            $query->whereHas('mahasiswa', function($q) use ($request) {
                $q->where('nim', 'like', '%' . $request->nim . '%');
            });
        }

        $pengajuans = $query->get();

        // ==============================
        // Hitung jumlah pengajuan menunggu
        // ==============================
        $jumlah_menunggu = Pengajuan::where('pembimbing', $dosen->nama)
            ->where('status', 'Menunggu')
            ->count();

        return view('pengajuan.data', compact('pengajuans', 'jumlah_menunggu', 'nama_mahasiswa', 'bidang_mahasiswa'));
    }

    // ==============================
    // UPDATE STATUS PENGAJUAN
    // ==============================
    public function updateStatus(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = $request->status;
        $pengajuan->komentar = $request->komentar;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status pengajuan berhasil diperbarui!');
    }

    // ==============================
    // LIHAT FILE PENGAJUAN
    // ==============================
    public function lihatFile($id)
{
    $pengajuan = \App\Models\Pengajuan::findOrFail($id);
    $fileUrl = asset('uploads/' . $pengajuan->file);

    return redirect($fileUrl);
}

    // ==============================
    // RIWAYAT PENGAJUAN
    // ==============================
    public function riwayat(Request $request)
{
    $dosen = Auth::user()->dosen;
    if (!$dosen) {
        Auth::logout();
        return redirect()->route('login')->withErrors(['error' => 'Data dosen tidak ditemukan.']);
    }

    // Ambil daftar untuk filter
    $nama_mahasiswa = Mahasiswa::pluck('nama');
    $nim_mahasiswa = Mahasiswa::pluck('nim');
    $prodi_mahasiswa = Mahasiswa::select('prodi')->distinct()->pluck('prodi');

    // Query pengajuan yang sudah diproses dan dibimbing dosen ini
    $query = Pengajuan::with('mahasiswa')
        ->where('status', '!=', 'Menunggu')
        ->where('pembimbing', $dosen->nama); // Hanya pengajuan dosen login

    // ==============================
    // Filter berdasarkan request
    // ==============================
    if ($request->filled('nama')) {
        $query->whereHas('mahasiswa', function ($q) use ($request) {
            $q->where('nama', $request->nama);
        });
    }

    if ($request->filled('nim')) {
        $query->whereHas('mahasiswa', function ($q) use ($request) {
            $q->where('nim', $request->nim);
        });
    }

    if ($request->filled('prodi')) {
        $query->whereHas('mahasiswa', function ($q) use ($request) {
            $q->where('prodi', $request->prodi);
        });
    }

    if ($request->filled('tanggal')) {
        $query->whereDate('tanggal', $request->tanggal);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Ambil data riwayat
    $riwayat = $query->orderBy('tanggal', 'desc')->get();

    return view('pengajuan.history', compact('riwayat', 'nama_mahasiswa', 'nim_mahasiswa', 'prodi_mahasiswa'));
}


    // ==============================
    // PROFIL DOSEN
    // ==============================
    public function editProfile()
    {
        $dosen = auth()->user()->dosen; // relasi user -> dosen
        return view('profile.dosen_profile', compact('dosen'));
    }

    public function updateProfile(Request $request)
    {
        $dosen = auth()->user()->dosen;

        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // ==============================
            // Hapus file lama
            // ==============================
            if ($dosen->foto && $dosen->foto !== 'default.png') {
                $oldFile = public_path('assets/img/dosen/' . $dosen->foto);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            // ==============================
            // Simpan file baru
            // ==============================
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/dosen'), $filename);

            $dosen->foto = $filename;
            $dosen->save();
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
