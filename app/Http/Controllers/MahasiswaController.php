<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Pengajuan;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MahasiswaController extends Controller
{
    // ==============================
    // DASHBOARD MAHASISWA
    // ==============================
    public function dashboard()
    {
        // ==============================
        // Ambil data mahasiswa login
        // ==============================
        $userId = Auth::id();
        $mahasiswa = Mahasiswa::where('user_id', $userId)->firstOrFail();

        // ==============================
        // Set default foto jika kosong
        // ==============================
        if (!$mahasiswa->foto) {
            $mahasiswa->foto = 'default.png';
        }

        // ==============================
        // Ambil pengajuan skripsi terbaru
        // ==============================
        $pengajuan = Pengajuan::where('mahasiswa_id', $mahasiswa->id)
                              ->latest('tanggal')
                              ->first();

        // ==============================
        // Koleksi kutipan acak (rekomendasi belakangan)
        // ==============================
        $quotes = [
            'Lulus itu butuh pengorbanan, bukan cuma rebahan.',
            'Skripsi bukan akhir segalanya, tapi awal dari petualangan baru.',
            'Tidur setelah subuh dapat menghambat skripsi.',
            'Ingat pesan orang tua: "Kapan wisuda?"',
            'Satu bab selesai, satu beban berkurang.'
        ];
        $random_quote = $quotes[array_rand($quotes)];

        return view('dashboard.mahasiswa', compact('mahasiswa', 'pengajuan', 'random_quote'));
    }

    // ==============================
    // FORM PENGAJUAN JUDUL
    // ==============================
    public function createPengajuan()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();
        $dosen = Dosen::all();

        return view('pengajuan.ajukan', compact('mahasiswa', 'dosen'));
    }

    // ==============================
    // SIMPAN PENGAJUAN
    // ==============================
    public function storePengajuan(Request $request)
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'bidang'     => 'required|string|max:255',
            'pembimbing' => 'required|string|max:255',
            'nidn'       => 'required|string|max:255|exists:dosen,nidn',
            'file'       => 'required|mimes:pdf,txt|max:10240',
        ]);

        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        try {
            $dosen = Dosen::where('nidn', $validatedData['nidn'])->firstOrFail();

            // ==============================
            // Upload File
            // ==============================
            $directory = public_path('uploads');
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }

            $filename = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                            . '-' . time() . '-' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                $file->move($directory, $filename);
            }

            // ==============================
            // Buat record pengajuan di database
            // ==============================
            Pengajuan::create([
                'mahasiswa_id' => $mahasiswa->id,
                'dosen_id'     => $dosen->id,
                'judul'        => $validatedData['judul'],
                'deskripsi'    => $validatedData['deskripsi'],
                'bidang'       => $validatedData['bidang'],
                'pembimbing'   => $validatedData['pembimbing'],
                'file'         => $filename, // ✅ cukup string nama file
                'tanggal'      => now(),
                'status'       => 'Menunggu',
            ]);

            return redirect()->route('pengajuan.status')->with('success', 'Pengajuan berhasil diajukan!');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan pengajuan: ' . $e->getMessage());

            if (isset($filename) && File::exists(public_path('uploads/' . $filename))) {
                File::delete(public_path('uploads/' . $filename));
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan.');
        }
    }

    // ==============================
    // STATUS PENGAJUAN (dengan filter)
    // ==============================
    public function statusPengajuan(Request $request)
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->firstOrFail();

        // Baseline query: hanya pengajuan milik mahasiswa ini
        $query = Pengajuan::with('mahasiswa')
                    ->where('mahasiswa_id', $mahasiswa->id);

        // Filter: status (menunggu/diterima/ditolak)
        if ($request->filled('status')) {
            // normalize: form mengirim 'menunggu'/'diterima'/'ditolak'
            $status = strtolower($request->status);
            if (in_array($status, ['menunggu', 'diterima', 'ditolak'])) {
                // DB menyimpan dengan kapital di awal: 'Menunggu' dll.
                $query->where('status', ucfirst($status));
            }
        }

        // Filter: tanggal (yyyy-mm-dd)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Optional: sort by tanggal asc/desc
        $sort = $request->get('sort', 'desc');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';
        $query->orderBy('tanggal', $sort);

        $pengajuan = $query->get();

        // ----- tambahan: kirim data untuk dropdown filter di view -----
        // (aman walau view tidak selalu pakai semua variabel)
        $nama_mahasiswa = Mahasiswa::pluck('nama');
        $prodi_mahasiswa = Mahasiswa::select('prodi')->distinct()->pluck('prodi');
        // ----------------------------------------------------------------

        return view('pengajuan.status', compact('pengajuan', 'nama_mahasiswa', 'prodi_mahasiswa', 'sort'));
    }

    // ==============================
    // LIHAT FILE PENGAJUAN
    // ==============================
    public function lihatFile($id)
    {
        $pengajuan = \App\Models\Pengajuan::findOrFail($id);
        // file ada di public/uploads
        return redirect(asset('uploads/' . $pengajuan->file));
    }

    // ==============================
    // PROFIL MAHASISWA
    // ==============================
    public function editProfile()
    {
        $mahasiswa = auth()->user()->mahasiswa; // relasi user -> mahasiswa
        return view('profile.mahasiswa_profile', compact('mahasiswa'));
    }

    public function updateProfile(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // ==============================
            // Hapus file lama
            // ==============================
            if ($mahasiswa->foto && $mahasiswa->foto !== 'default.png') {
                $oldFile = public_path('assets/img/mahasiswa/' . $mahasiswa->foto);
                if (file_exists($oldFile)) {
                    @unlink($oldFile);
                }
            }

            // ==============================
            // Simpan file baru
            // ==============================
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/mahasiswa'), $filename);

            $mahasiswa->foto = $filename;
            $mahasiswa->save();
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
