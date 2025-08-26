<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index(Request $request)
{
    // Ambil daftar nama dan prodi unik untuk filter dropdown
    $nama_dosen = Dosen::pluck('nama')->unique();
    $prodi_dosen = Dosen::pluck('kaprodi')->unique();

    // Query dosen dengan relasi user
    $query = Dosen::with('user');

    // Filter berdasarkan input request
    if ($request->filled('nama')) {
        $query->where('nama', $request->nama);
    }

    if ($request->filled('kaprodi')) {
        $query->where('kaprodi', $request->kaprodi);
    }

    // Ambil hasil query
    $dosen = $query->get();

    return view('admin.dosen.index', compact('dosen', 'nama_dosen', 'prodi_dosen'));
}


    public function create()
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:3',
            'nama' => 'required|string|max:255',
            'nidn' => 'required|unique:dosen',
            'kaprodi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userId = User::insertGetId([
    'username' => $request->username,
    'password' => Hash::make($request->password),
    'password_plain' => $request->password, // tambahkan ini
    'role' => 'dosen',
    'created_at' => now(),
    'updated_at' => now(),
]);


        $filename = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/dosen'), $filename);
        }

        Dosen::create([
            'user_id' => $userId,
            'nama' => $request->nama,
            'nidn' => $request->nidn,
            'kaprodi' => $request->kaprodi,
            'foto' => $filename,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil ditambahkan');
    }

public function edit($id)
{
    $dosen = Dosen::with('user')->findOrFail($id); // ganti $dsn jadi $dosen
    return view('admin.dosen.edit', compact('dosen'));
}


    public function update(Request $request, $id)
    {
        $dsn = Dosen::with('user')->findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'nidn' => 'required',
            'kaprodi' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img/dosen'), $filename);
            $dsn->foto = $filename;
        }

        $dsn->nama = $request->nama;
        $dsn->nidn = $request->nidn;
        $dsn->kaprodi = $request->kaprodi;
        $dsn->save();

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil diperbarui');
    }

    public function destroy($id)
    {
        $dsn = Dosen::findOrFail($id);
        $dsn->user()->delete(); // hapus user juga
        $dsn->delete();

        return redirect()->route('dosen.index')->with('success', 'Dosen berhasil dihapus');
    }
}
