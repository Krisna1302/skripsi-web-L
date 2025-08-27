# Skripsi-Web

Sistem Pengajuan Judul Skripsi berbasis Web menggunakan PHP (Laravel 12) dan Bootstrap.  
Website ini dibuat untuk mempermudah proses pengajuan dan validasi judul skripsi antara mahasiswa, dosen, dan admin akademik di Tanri Abeng University.  
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

---

## 🛠 Tools yang Digunakan

| Alat / Software | Fungsi |
|-----------------|--------|
| PHP | Bahasa pemrograman backend, menulis logika aplikasi Laravel |
| XAMPP | Server lokal (Apache, MySQL/MariaDB, PHP) untuk testing |
| Laravel | Framework PHP untuk web apps (MVC, routing, controller, model) |
| GitHub | Repository online untuk version control dan kolaborasi |
| MySQL | Database relational untuk menyimpan data pengguna, pengajuan, dll |
| VS Code | Code editor untuk menulis kode, debugging, dan install ekstensi Laravel |
| Browser | Menampilkan hasil aplikasi web di localhost |
| Composer | Dependency manager PHP, install Laravel & package tambahan |
| InfinityFree | Hosting gratis untuk aplikasi web |
| StarUML | Membuat diagram use case, ERD, dan site map |
| FileZilla | Upload file via FTP ke hosting |

---

## 👥 Anggota Kelompok / Kontributor

- Krisna Wibowo – Teknik Informatika Batch 13 
- Peris Trisna Wati Nazara – Teknik Informatika Batch 13 
- Putri Wandayani – Teknik Informatika Batch 13 

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

4. Jalankan migrate dan seed:

```bash
php artisan migrate --seed
```

5. Jalankan server lokal:

```bash
php artisan serve
```

---

## 🖥 Struktur Halaman / Skenario Login

### Mahasiswa

- Halaman Login
- Dashboard Mahasiswa
- Halaman Pengajuan Skripsi
- Halaman Status Pengajuan Skripsi
- Halaman Pengaturan Profil

### Dosen

- Halaman Login
- Dashboard Dosen
- Halaman Data Pengajuan Skripsi
- Halaman History Pengajuan Skripsi
- Halaman Pengaturan Profil

### Admin

- Halaman Login
- Dashboard Admin
- Data Mahasiswa
- Data Dosen
- Data Pengajuan Skripsi

---

## 📌 Repository & File Project

- GitHub: [https://github.com/Krisna1302/skripsi-web](https://github.com/Krisna1302/skripsi-web)  
- Google Drive: Tempat menyimpan berkas proyek lengkap (source code, database, dokumentasi)
