# 🏫 SimaSek — Sistem Informasi Manajemen Data Siswa Sekolah

**SimaSek** adalah aplikasi berbasis web yang dirancang untuk membantu sekolah dalam mengelola data siswa secara efisien, cepat, dan terstruktur.  
Melalui sistem ini, admin dapat menambah, mengedit, dan menghapus data siswa dengan mudah, sementara siswa dapat melihat biodata pribadinya secara langsung melalui antarmuka yang sederhana dan interaktif.

---

## ✨ Fitur Utama

### 🔐 1. Login Multiuser
- Mendukung dua jenis pengguna: **Admin** dan **Siswa**.
- Validasi login berbasis email dan password yang terenkripsi.
- Sistem keamanan menggunakan session-based authentication.

### 🏠 2. Dashboard
- Menampilkan jumlah total siswa yang terdaftar di sistem.
- Menampilkan daftar **10 siswa terbaru**.
- Menampilkan aktivitas terbaru dari tabel `aktivitas_terakhir` seperti penambahan, pembaruan, dan penghapusan data siswa.

### 👨‍🎓 3. Manajemen Data Siswa
- Admin dapat menambahkan siswa baru melalui form input sederhana.
- **Nomor Induk Siswa (NIS)** dihasilkan secara otomatis oleh sistem.
- Fitur edit dan hapus data siswa tersedia dengan validasi aman.
- Data siswa ditampilkan dalam bentuk tabel interaktif.

### 📜 4. Riwayat Aktivitas
- Semua tindakan penting (seperti menambah, memperbarui, atau menghapus siswa) tercatat di tabel `aktivitas_terakhir`.
- Fitur ini membantu admin memantau perubahan yang terjadi di sistem.

### 🚪 5. Logout
- Pengguna dapat keluar dari sistem dengan aman menggunakan tombol logout.

---

## 🧱 Struktur Database

### Database Name: `simasek`

Terdiri dari dua tabel utama:

#### 1. Tabel `user`
Menyimpan data semua pengguna (admin dan siswa).

| Kolom | Tipe Data | Deskripsi |
|--------|------------|------------|
| `id` | INT (PK, AUTO_INCREMENT) | ID unik untuk setiap pengguna |
| `role` | VARCHAR(100) | Peran pengguna (`admin` atau `siswa`) |
| `email` | VARCHAR(100) | Email pengguna untuk login |
| `password` | VARCHAR(100) | Password terenkripsi |
| `nama_lengkap` | VARCHAR(100) | Nama lengkap pengguna |
| `tempat_lahir` | VARCHAR(100) | Tempat lahir pengguna |
| `tanggal_lahir` | DATE | Tanggal lahir pengguna |
| `alamat` | VARCHAR(100) | Alamat pengguna |
| `nis` | DECIMAL(8,0) | Nomor Induk Siswa unik |

#### 2. Tabel `aktivitas_terakhir`
Menyimpan log aktivitas dari admin (misalnya menambah atau menghapus siswa).

| Kolom | Tipe Data | Deskripsi |
|--------|------------|------------|
| `id` | INT (PK, AUTO_INCREMENT) | ID unik aktivitas |
| `action` | VARCHAR(255) | Deskripsi aktivitas yang dilakukan |

Contoh data `aktivitas_terakhir`:
- `Siswa baru ditambahkan: NIS 1250, Nama: Marvel`
- `Data siswa diperbarui: Ayu Lestari`
- `Siswa dihapus: Marvel`

---

## 🖥️ Teknologi yang Digunakan

| Kategori | Teknologi |
|-----------|------------|
| **Frontend** | HTML, CSS |
| **Backend** | PHP |
| **Database** | MySQL |
| **Server Environment** | Laragon |
| **UI/UX Design** | Figma |

---

## ⚙️ Setup Database

Langkah-langkah menyiapkan dan menjalankan aplikasi secara lokal:

### 1. Persiapan Lingkungan
Pastikan sudah menginstal:
- [Laragon](https://laragon.org/)
- PHP versi 7.4 ke atas
- MySQL aktif

### 2. Import Database
1. Buka **phpMyAdmin** di browser (`http://localhost/phpmyadmin`).
2. Buat database baru dengan nama:  
   ```
   simasek
   ```
3. Klik **Import** dan pilih file `simasek.sql`.
4. Setelah berhasil diimport, pastikan tabel `user` dan `aktivitas_terakhir` muncul.

### 3. Konfigurasi File Koneksi
Edit file `config.php` sesuai pengaturan lokal Anda:
```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "simasek";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

### 4. Menjalankan Aplikasi
1. Simpan folder proyek ke direktori:
   ```
   C:\laragon\www\simasek
   ```
2. Jalankan **Apache** dan **MySQL** melalui Laragon.
3. Buka browser dan akses:
   ```
   http://localhost/simasek
   ```

---

## 👥 Role Pengguna

### 👨‍💼 Admin
- Login ke sistem menggunakan email dan password.
- Melihat daftar siswa.
- Menambah, mengedit, dan menghapus data siswa.
- Melihat riwayat aktivitas terakhir.

### 👩‍🎓 Siswa
- Login ke sistem.
- Melihat biodata pribadi (nama, alamat, tanggal lahir, NIS, dll).

---

## 🧩 Keamanan
- Password disimpan dalam bentuk **hash (MD5 atau bcrypt)**.
- Validasi input di sisi server dan klien untuk mencegah SQL Injection.
- Sistem login menggunakan session PHP untuk memastikan keamanan akses.

---

## 📜 Lisensi
Proyek ini dikembangkan untuk keperluan **pembelajaran dan penelitian**.  
Diperbolehkan untuk dimodifikasi dan digunakan kembali untuk pengembangan sistem informasi sekolah lainnya.

---

## 💡 Kontributor
Dikembangkan oleh tim pengembang **SimaSek** dengan tujuan meningkatkan efisiensi manajemen data sekolah.

---
