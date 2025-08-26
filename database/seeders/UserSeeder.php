<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ======================
        // Admin
        // ======================
        $admins = [
            [
                'username' => 'admin',
                'nama'     => 'Admin Utama',
                'password' => '123',
            ],
        ];

        foreach ($admins as $admin) {
            // Cek dulu supaya tidak duplicate
            if (!DB::table('users')->where('username', $admin['username'])->exists()) {
                $userId = DB::table('users')->insertGetId([
                    'username'       => $admin['username'],
                    'password'       => Hash::make($admin['password']),
                    'password_plain' => $admin['password'], 
                    'role'           => 'admin',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                DB::table('admin')->insert([
                    'user_id'    => $userId,
                    'nama'       => $admin['nama'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ======================
        // Mahasiswa
        // ======================
        $mahasiswas = [
            // Teknik Informatika
            ['username'=>'peris','nama'=>'Peris Trisna','nim'=>'06024011','prodi'=>'Teknik Informatika','password'=>'123'],
            ['username'=>'krisnaw','nama'=>'Krisna Wibowo','nim'=>'06024012','prodi'=>'Teknik Informatika','password'=>'123'],
            ['username'=>'ajma','nama'=>'Ajma Erlangga','nim'=>'06024013','prodi'=>'Teknik Informatika','password'=>'123'],

            // Sistem Informasi
            ['username'=>'putri','nama'=>'Putri Wandayani','nim'=>'06024006','prodi'=>'Sistem Informasi','password'=>'123'],
            ['username'=>'revli','nama'=>'Revli Valendiaz Zalfa','nim'=>'06024007','prodi'=>'Sistem Informasi','password'=>'123'],
            ['username'=>'daffa','nama'=>'Daffa Kuswardana','nim'=>'06024008','prodi'=>'Sistem Informasi','password'=>'123'],

            // Teknik Mesin
            ['username'=>'handhy','nama'=>'Handhy Kurnia','nim'=>'06024009','prodi'=>'Teknik Mesin','password'=>'123'],
            ['username'=>'krisnan','nama'=>'Krisna Nugraha','nim'=>'06024010','prodi'=>'Teknik Mesin','password'=>'123'],
            ['username'=>'yasmin','nama'=>'Yasmin Aprilia Mischa Mahesa','nim'=>'06024014','prodi'=>'Teknik Mesin','password'=>'123'],
        ];

        foreach ($mahasiswas as $m) {
            if (!DB::table('users')->where('username', $m['username'])->exists()) {
                $userId = DB::table('users')->insertGetId([
                    'username'       => $m['username'],
                    'password'       => Hash::make($m['password']),
                    'password_plain' => $m['password'],
                    'role'           => 'mahasiswa',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                DB::table('mahasiswa')->insert([
                    'user_id'    => $userId,
                    'nama'       => $m['nama'],
                    'nim'        => $m['nim'],
                    'prodi'      => $m['prodi'],
                    'foto'       => 'default.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // ======================
        // Dosen
        // ======================
        $dosens = [
            ['username'=>'yohanes','nama'=>'Yohanes Eka Wibawa','nidn'=>'20232023','kaprodi'=>'Teknik Informatika','password'=>'123'],
            ['username'=>'sri','nama'=>'Sri Wahyu','nidn'=>'20232024','kaprodi'=>'Sistem Informasi','password'=>'123'],
            ['username'=>'johny','nama'=>'Johny Siringo Ringo','nidn'=>'20232026','kaprodi'=>'Teknik Mesin','password'=>'123'],
        ];

        foreach ($dosens as $d) {
            if (!DB::table('users')->where('username', $d['username'])->exists()) {
                $userId = DB::table('users')->insertGetId([
                    'username'       => $d['username'],
                    'password'       => Hash::make($d['password']),
                    'password_plain' => $d['password'],
                    'role'           => 'dosen',
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);

                DB::table('dosen')->insert([
                    'user_id'    => $userId,
                    'nama'       => $d['nama'],
                    'nidn'       => $d['nidn'],
                    'kaprodi'    => $d['kaprodi'],
                    'foto'       => 'default.png',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
