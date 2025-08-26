<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tabel agar fresh seed
        DB::table('pengajuan')->truncate();

        $statuses = ['Menunggu', 'Diterima', 'Ditolak'];

        $keywords = [
            'Teknik Informatika' => ['Sistem', 'Algoritma', 'Aplikasi', 'AI', 'Web', 'Keamanan'],
            'Sistem Informasi'   => ['Informasi', 'Database', 'ERP', 'Manajemen', 'Data', 'Integrasi'],
            'Teknik Mesin'       => ['Mesin', 'Mekanika', 'Robotik', 'Produksi', 'Energi', 'Desain'],
        ];

        $mahasiswas = DB::table('mahasiswa')
            ->join('users', 'mahasiswa.user_id', '=', 'users.id')
            ->select('mahasiswa.*', 'users.username')
            ->get();

        // Ambil semua file dari folder seeder
        $files = glob(database_path('seeders/files/*'));

        foreach ($mahasiswas as $m) {
            $dosens = DB::table('dosen')->where('kaprodi', $m->prodi)->get();
            $jumlahPengajuan = rand(2,3);

            for ($i=1; $i<=$jumlahPengajuan; $i++) {
                shuffle($keywords[$m->prodi]);
                $kata = $keywords[$m->prodi];

                $judul = "Skripsi tentang " . implode(' ', array_slice($kata,0,2)) . " oleh " . $m->nama;

                $deskripsi = "Penelitian ini membahas " . implode(' ', array_slice($kata,0,2)) . 
                             " dengan tujuan untuk menganalisis dan mengevaluasi penerapan " . $kata[2] .
                             ". Penelitian dilakukan oleh " . $m->nama . " untuk memperoleh hasil yang dapat memberikan " . 
                             "pemahaman lebih dalam terkait penerapan " . $kata[3] . 
                             " dalam konteks " . $m->prodi . ". Metode yang digunakan diharapkan dapat memberikan " .
                             "data dan insight yang valid sehingga dapat mendukung pengembangan lebih lanjut.";

                $pembimbingId = $dosens->random()->id ?? null;
                $pembimbingNama = $pembimbingId ? DB::table('dosen')->where('id', $pembimbingId)->value('nama') : null;

                $fileSource = $files[array_rand($files)];
                $ext = pathinfo($fileSource, PATHINFO_EXTENSION);
                $fileName = $m->username.'_pengajuan_'.$i.'.'.$ext;

                $uploadFolder = public_path('uploads/');
                if (!is_dir($uploadFolder)) mkdir($uploadFolder, 0755, true);

                // Salin file ke public/uploads
                copy($fileSource, $uploadFolder.$fileName);

                // Simpan hanya nama file di DB
                $fileDest = $fileName;

                $status = $statuses[array_rand($statuses)];

                switch($status) {
                    case 'Diterima':
                        $komentar = 'Bagus, silakan lanjutkan penelitian sesuai proposal.';
                        break;
                    case 'Ditolak':
                        $komentar = 'Perlu revisi pada metode dan tinjauan pustaka.';
                        break;
                    case 'Menunggu':
                        $komentar = '-';
                        break;
                }

                DB::table('pengajuan')->insert([
                    'mahasiswa_id' => $m->id,
                    'judul'        => $judul,
                    'deskripsi'    => $deskripsi,
                    'dosen_id'     => $pembimbingId,
                    'bidang'       => $kata[0],
                    'pembimbing'   => $pembimbingNama,
                    'file'         => $fileDest,  // Hanya nama file
                    'status'       => $status,
                    'komentar'     => $komentar,
                    'tanggal'      => now()->subDays(rand(0,10)),
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }
    }
}
