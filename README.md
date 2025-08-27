# skripsi-web

Sistem Pengajuan Judul Skripsi berbasis Web menggunakan PHP dan Bootstrap.

Website ini dibuat sebagai bagian dari tugas akhir mahasiswa untuk memudahkan proses pengajuan dan validasi judul skripsi antara mahasiswa dan dosen.  
Proyek ini **masih dalam proses pengembangan** dan akan terus diperbarui untuk memenuhi kebutuhan pengguna dan standar sistem informasi akademik.

---

## 🔧 Fitur Utama

- 🔐 Sistem login terpisah untuk mahasiswa, dosen, dan admin
- 📄 Mahasiswa dapat mengajukan judul skripsi, mengunggah file, dan memantau status pengajuan
- ✅ Dosen dapat menyetujui atau menolak pengajuan dengan komentar
- 🕓 Riwayat pengajuan tersimpan otomatis berdasarkan status
- 📁 File proposal dapat dilihat langsung oleh dosen dan mahasiswa
- 🎨 Tampilan dark mode yang konsisten dan responsif
- 🛠 Admin dapat mengelola data dosen, mahasiswa, dan pengajuan

---

## 🧱 Teknologi yang Digunakan

- PHP (Laravel 12)
- MySQL
- Bootstrap 5 (CDN)
- AOS (Animate On Scroll)
- HTML & CSS
- Vite.js (untuk asset bundling)

---

## 👥 Anggota Kelompok / Kontributor

- Krisna Wibowo (krisna.wibowo@student.tau.ac.id) – Admin & Developer  
- Peris Trisna Wati Nazara – Dosen  
- Putri Wandayani – Mahasiswa  

---

## ⚠️ Status

Proyek ini masih dalam tahap pengembangan aktif. Fitur tambahan, validasi data, dan optimasi keamanan akan terus diperbarui secara bertahap.

---

## 📂 Cara Menjalankan

1. Clone repository:

```bash
git clone https://github.com/Krisna1302/skripsi-web-L.git
cd skripsi-web-L
````

2. Install dependencies:

```bash
composer install
npm install
npm run dev
```

3. Copy file `.env` dan generate key:

```bash
cp .env.example .env
php artisan key:generate
```

4. Jalankan migrate dan seed:

```bash
php artisan migrate --seed
```

5. Jalankan server lokal:

```bash
php artisan serve
```

---

## 📝 Catatan Akun Seeder

Berikut username dan password default yang dibuat di `PengajuanSeeder`:

| ID | Role      | Username | Password (Plain) |
| -- | --------- | -------- | ---------------- |
| 1  | Admin     | admin    | 123              |
| 2  | Mahasiswa | peris    | 123              |
| 3  | Mahasiswa | krisnaw  | 123              |
| 4  | Mahasiswa | ajma     | 123              |
| 5  | Mahasiswa | putri    | 123              |
| 6  | Mahasiswa | revli    | 123              |
| 7  | Mahasiswa | daffa    | 123              |
| 8  | Mahasiswa | handhy   | 123              |
| 9  | Mahasiswa | krisnan  | 123              |
| 10 | Mahasiswa | yasmin   | 123              |
| 11 | Dosen     | yohanes  | 123              |
| 12 | Dosen     | sri      | 123              |
| 13 | Dosen     | johny    | 123              |

> **Catatan:** Password disimpan terenkripsi di database, gunakan password plain di atas untuk login pertama kali.
