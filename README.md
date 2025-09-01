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
| StarUML | Membuat diagram use case, ERD, dan site map |

---

## 👥 Anggota Kelompok / Kontributor

- Krisna Wibowo – Teknik Informatika Batch 13 
- Peris Trisna Wati Nazara – Teknik Informatika Batch 13 
- Putri Wandayani – Teknik Informatika Batch 13 

---

## ⚠️ Status

Proyek ini masih dalam tahap pengembangan aktif. Fitur tambahan, validasi data, dan optimasi keamanan akan terus diperbarui secara bertahap.

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

## 🖼️ Preview Tampilan

### 🔑 Halaman Login
![Login Page](https://raw.githubusercontent.com/Krisna1302/skripsi-web-L/dokumentasi/attachment/MenuLogin.png)

### 📊 Dashboard Admin
![Dashboard Admin](https://raw.githubusercontent.com/Krisna1302/skripsi-web-L/dokumentasi/attachment/UI_Admin/1.dashboard_admin.png)

### 📝 Pengajuan Mahasiswa
![Pengajuan Mahasiswa](https://raw.githubusercontent.com/Krisna1302/skripsi-web-L/dokumentasi/attachment/UI_Mahasiswa/2.AjukanMhs.png)

---

## 📝 Catatan

- Database default yang digunakan: **`skripsi_db`**  
- Seeder **`PengajuanSeeder`** harus dijalankan secara manual jika ingin menggunakan akun default.  

### Akun Seeder (Manual)

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

---

## 📌 Repository & File Project

- GitHub: [https://github.com/Krisna1302/skripsi-web](https://github.com/Krisna1302/skripsi-web)  
- Google Drive: Menyimpan berkas lengkap (source code, database, dokumentasi)  
- Release: Untuk full package (termasuk `vendor/` dan file `.env`)
