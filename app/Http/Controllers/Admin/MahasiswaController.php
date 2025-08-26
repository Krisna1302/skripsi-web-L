<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
{
    // Ambil daftar nama dan prodi unik untuk filter
    $nama_mahasiswa = Mahasiswa::pluck('nama')->unique();
    $prodi_mahasiswa = Mahasiswa::pluck('prodi')->unique();

    // Query mahasiswa dengan relasi user
    $query = Mahasiswa::with('user');

    // Filter berdasarkan request
    if ($request->filled('nama')) {
        $query->where('nama', $request->nama);
    }

    if ($request->filled('nim')) {
        $query->where('nim', 'like', '%' . $request->nim . '%');
    }

    if ($request->filled('prodi')) {
        $query->where('prodi', $request->prodi);
    }

    // Ambil data mahasiswa
    $mahasiswa = $query->get();

    return view('admin.mahasiswa.index', compact('mahasiswa', 'nama_mahasiswa', 'prodi_mahasiswa'));
}


    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:3',
            'nama' => 'required|string|max:255',
            'nim' => 'required|unique:mahasiswa',
            'prodi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan user
        $userId = User::insertGetId([
    'username' => $request->username,
    'password' => Hash::make($request->password),
    'password_plain' => $request->password, // 👉 simpan password asli
    'role' => 'mahasiswa',
    'created_at' => now(),
    'updated_at' => now(),
]);


        // Upload foto
        $filename = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/mahasiswa'), $filename);
        }

        // Simpan data mahasiswa
        Mahasiswa::create([
            'user_id'    => $userId,
            'nama'       => $request->nama,
            'nim'        => $request->nim,
            'prodi'      => $request->prodi,
            'foto'       => $filename,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($id)
{
    $mahasiswa = Mahasiswa::with('user')->findOrFail($id);
    return view('admin.mahasiswa.edit', compact('mahasiswa'));
}

    public function update(Request $request, $id)
    {
        $mhs = Mahasiswa::with('user')->findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $mhs->user->id,
            'password' => 'nullable|min:3',
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|unique:mahasiswa,nim,' . $mhs->id,
            'prodi'    => 'required|string|max:255',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Update user
        $mhs->user->username = $request->username;
        if ($request->filled('password')) {
            $mhs->user->password = Hash::make($request->password);
        }
        $mhs->user->save();

        // Update foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/mahasiswa'), $filename);
            $mhs->foto = $filename;
        }

        // Update data mahasiswa
        $mhs->nama  = $request->nama;
        $mhs->nim   = $request->nim;
        $mhs->prodi = $request->prodi;
        $mhs->save();

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mhs = Mahasiswa::with('user')->findOrFail($id);

        // Hapus user terkait
        $mhs->user->delete();

        // Hapus mahasiswa
        $mhs->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}
