<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Mahasiswa;

class PengajuanController extends Controller
{
    // Tampilkan semua pengajuan dengan filter
    public function index(Request $request)
{
    $nama_mahasiswa = Mahasiswa::orderBy('nama')->pluck('nama')->unique();
    $prodi_mahasiswa = Mahasiswa::orderBy('prodi')->pluck('prodi')->unique();

    $query = Pengajuan::with('mahasiswa');

    if ($request->nama) {
        $query->whereHas('mahasiswa', fn($q) => $q->where('nama', $request->nama));
    }
    if ($request->nim) {
        $query->whereHas('mahasiswa', fn($q) => $q->where('nim', 'like', "%{$request->nim}%"));
    }
    if ($request->prodi) {
        $query->whereHas('mahasiswa', fn($q) => $q->where('prodi', $request->prodi));
    }
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Urutkan berdasarkan tanggal
    $sort = $request->sort ?? 'desc'; // default terbaru → terlama
    $pengajuan = $query->orderBy('created_at', $sort)->get();

    return view('admin.pengajuan.index', compact('pengajuan', 'nama_mahasiswa', 'prodi_mahasiswa', 'sort'));
}


    // Form edit pengajuan
    public function edit($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        return view('admin.pengajuan.edit', compact('pengajuan'));
    }

    // Update pengajuan
    public function update(Request $request, $id)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'komentar' => 'nullable|string',
        'status' => 'required|in:menunggu,diterima,ditolak',
        'file' => 'nullable|file|mimes:pdf,doc,docx'
    ]);

    $pengajuan = Pengajuan::findOrFail($id);

    // Assign semua field
    $pengajuan->judul = $request->judul;
    $pengajuan->deskripsi = $request->deskripsi;
    $pengajuan->komentar = $request->komentar;
    $pengajuan->status = $request->status;

    // Handle file jika ada
    if ($request->hasFile('file')) {
        $file = $request->file('file')->store('pengajuan_files', 'public');
        $pengajuan->file = $file;
    }

    $pengajuan->save();

    return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui.');
}

    // Hapus pengajuan
    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil dihapus.');
    }

    // Approve pengajuan
    public function approve($id)
    {
        $p = Pengajuan::findOrFail($id);
        $p->status = 'diterima';
        $p->save();

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan diterima.');
    }

    // Reject pengajuan
    public function reject($id)
    {
        $p = Pengajuan::findOrFail($id);
        $p->status = 'ditolak';
        $p->save();

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan ditolak.');
    }
}
