# 📚 skripsi-web

Sistem Pengajuan Judul Skripsi berbasis Web menggunakan **Laravel** dan **Bootstrap**.

Website ini dibuat sebagai bagian dari tugas akhir mahasiswa untuk memudahkan proses pengajuan dan validasi judul skripsi antara mahasiswa dan dosen.  
Proyek ini **masih dalam proses pengembangan** dan akan terus diperbarui untuk memenuhi kebutuhan pengguna dan standar sistem informasi akademik.

---

## 🔧 Fitur Utama

- 🔐 Sistem login terpisah untuk **Mahasiswa**, **Dosen**, dan **Admin**
- 📄 Mahasiswa dapat mengajukan judul skripsi, mengunggah file, dan memantau status pengajuan
- ✅ Dosen dapat menyetujui atau menolak pengajuan dengan komentar
- 🕓 Riwayat pengajuan tersimpan otomatis berdasarkan status
- 📁 File proposal dapat dilihat langsung oleh dosen dan mahasiswa
- 🎨 Tampilan **dark mode** yang konsisten dan responsif
- 🛠 Admin dapat mengelola data dosen, mahasiswa, dan pengajuan

---

## 🧱 Teknologi yang Digunakan

- PHP (Laravel 12)
- MySQL
- Bootstrap 5 (CDN)
- AOS (Animate On Scroll)
- HTML & CSS

---

## 👥 Anggota Kelompok / Kontributor

- Krisna Wibowo – Teknik Informatika
- Peris Trisna Wati Nazara – Teknik Informatika 
- Putri Wandayani – Teknik Informatika

---

## ⚠️ Status

Proyek ini masih dalam tahap pengembangan aktif. Fitur tambahan, validasi data, dan optimasi keamanan akan terus diperbarui secara bertahap.

---

## 📂 Cara Menjalankan

1. Clone repository:

   ```bash
   git clone https://github.com/Krisna1302/skripsi-web-L.git
   cd skripsi-web-L
   ```

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

4. Sesuaikan konfigurasi database di `.env`:

   ```
   DB_DATABASE=skripsi_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Jalankan migrate dan seed default:

   ```bash
   php artisan migrate --seed
   ```

6. Jalankan server lokal:

   ```bash
   php artisan serve
   ```

---

## 🌱 Catatan Seeder

* Jalankan seeder default dengan:

  ```bash
  php artisan db:seed
  ```

* Untuk `PengajuanSeeder`, **harus dijalankan manual**:

  ```bash
  php artisan db:seed --class=PengajuanSeeder
  ```

---

## 👤 Akun Default

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

> ⚠️ Password disimpan terenkripsi di database, gunakan password plain di atas untuk login pertama kali.

---

## 📝 Note

* Nama database default: **skripsi\_db**
* Seeder `PengajuanSeeder` tidak otomatis, jalankan manual dengan command di atas
* Untuk versi lengkap yang sudah berisi `vendor/` dan file `.env`, silakan download dari menu **Release** di repository ini

## 🖼️ Preview Tampilan

### 🔑 Halaman Login
![Login Page](https://raw.githubusercontent.com/Krisna1302/skripsi-web-L/dokumentasi/attachment/MenuLogin.png)

### 📊 Dashboard Admin
![Dashboard Admin](https://raw.githubusercontent.com/Krisna1302/skripsi-web-L/dokumentasi/attachment/UI_Admin/1.dashboard_admin.png)

### 📝 Pengajuan Mahasiswa
![Pengajuan Mahasiswa](https://raw.githubusercontent.com/Krisna1302/skripsi-web-L/dokumentasi/attachment/UI_Mahasiswa/2.AjukanMhs.png)
