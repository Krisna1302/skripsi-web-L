<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Jumlah mahasiswa dan dosen
        $jumlahMahasiswa = User::where('role', 'mahasiswa')->count();
        $jumlahDosen = User::where('role', 'dosen')->count();

        // Jumlah total pengajuan
        $jumlahPengajuan = Pengajuan::count();

        // Ambil 5 pengajuan terbaru
        $recentPengajuan = Pengajuan::with('mahasiswa')
            ->latest()
            ->take(5)
            ->get();

        // Statistik jumlah mahasiswa per prodi
        $prodiCounts = DB::table('mahasiswa')
            ->join('users', 'mahasiswa.user_id', '=', 'users.id')
            ->where('users.role', 'mahasiswa')
            ->select('mahasiswa.prodi', DB::raw('COUNT(*) as total'))
            ->groupBy('mahasiswa.prodi')
            ->pluck('total', 'mahasiswa.prodi');

        // Statistik pengajuan per status
        $pengajuanStats = [
            'Menunggu'     => Pengajuan::where('status', 'Menunggu')->count(),
            'Diterima'     => Pengajuan::where('status', 'Diterima')->count(),
            'Ditolak'      => Pengajuan::where('status', 'Ditolak')->count(),
            'Dikembalikan' => Pengajuan::where('status', 'Dikembalikan')->count(),
        ];

        return view('admin.dashboard', compact(
            'jumlahMahasiswa',
            'jumlahDosen',
            'jumlahPengajuan',
            'recentPengajuan',
            'prodiCounts',
            'pengajuanStats'
        ));
    }

    public function editProfile()
    {
        $admin = Auth::user()->admin;
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::user()->admin;

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama' => 'required|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/admin'), $filename);
            $admin->foto = $filename;
        }

        $admin->nama = $request->nama;
        $admin->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}
