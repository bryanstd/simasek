# 🏫 SimaSek — Sistem Informasi Manajemen Data Siswa Sekolah

**SimaSek** adalah aplikasi berbasis web yang bertujuan untuk memudahkan siswa dalam melihat biodata diri mereka serta membantu admin dalam mengelola data siswa dengan lebih cepat, terstruktur, dan efisien.  
Dengan adanya sistem ini, proses pendataan siswa tidak lagi harus dilakukan secara manual, melainkan dapat diakses langsung melalui dashboard sederhana dan interaktif.

---

## ✨ Fitur Utama

### 🔐 1. Login Multiuser
- Login sebagai **Admin** atau **Siswa**.
- Autentikasi berbasis sesi untuk menjaga keamanan data.

### 🏠 2. Dashboard
- Menampilkan total siswa yang terdaftar.
- Menampilkan daftar **10 siswa terbaru**.
- Tampilan ringkas dan informatif untuk pengguna.

### 👨‍🎓 3. Manajemen Data Siswa
- Tambah siswa baru dengan form input sederhana.
- **Nomor Induk Siswa (NIS)** dibuat otomatis oleh sistem.
- Edit dan hapus data siswa.
- Menampilkan daftar siswa dalam bentuk tabel yang mudah dibaca.

### 🚪 4. Logout
- Mengakhiri sesi pengguna untuk menjaga keamanan akses aplikasi.

---

## 🧱 Entitas yang Digunakan

| Entitas | Deskripsi | Atribut Utama |
|----------|------------|----------------|
| **Admin** | Pengguna yang mengelola sistem | id_admin, username, password |
| **Siswa** | Data siswa yang tersimpan dalam sistem | nis, nama, kelas, alamat, tanggal_lahir |
| **User (Login)** | Menyimpan kredensial login multiuser | username, password, role |

---

## 🖥️ Teknologi yang Digunakan

| Kategori | Teknologi |
|-----------|------------|
| **Frontend** | HTML, CSS, JavaScript |
| **Backend** | PHP |
| **Database** | MySQL |
| **Desain UI/UX** | Figma |
| **Server Environment (opsional)** | XAMPP / Laragon / LAMP |

---

## ⚙️ Setup Database

Berikut langkah-langkah untuk menjalankan SimaSek secara lokal:

### 1. Persiapan
Pastikan sudah menginstal:
- [XAMPP](https://www.apachefriends.org/index.html) atau [Laragon](https://laragon.org/)
- PHP 7.4 atau lebih baru
- MySQL Server aktif

### 2. Import Database
1. Buka **phpMyAdmin** melalui browser (`http://localhost/phpmyadmin`).
2. Buat database baru, misalnya:  
   ```
   simasek_db
   ```
3. Klik **Import**, lalu unggah file `simasek.sql` dari folder proyek (biasanya berada di `/database/simasek.sql`).
4. Setelah proses import selesai, pastikan tabel seperti `admin`, `siswa`, dan `user` sudah terbentuk.

### 3. Konfigurasi Koneksi
Edit file konfigurasi (misalnya `config.php`) dengan menyesuaikan kredensial database:
```php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "simasek_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
```

### 4. Jalankan Aplikasi
1. Letakkan folder proyek ke direktori:
   ```
   C:\xampp\htdocs\simasek
   ```
2. Jalankan Apache dan MySQL di XAMPP.
3. Akses aplikasi di browser melalui:
   ```
   http://localhost/simasek
   ```

---

## 👥 Role Pengguna

### 👨‍💼 Admin
- Login ke sistem.
- Menginput, mengedit, dan menghapus data siswa.
- Melihat jumlah siswa yang terdaftar.

### 👩‍🎓 Siswa
- Login ke sistem.
- Melihat biodata diri yang sudah dimasukkan oleh admin.

---

## 📂 Struktur Direktori (Contoh)
```
simasek/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── database/
│   └── simasek.sql
├── includes/
│   ├── config.php
│   ├── header.php
│   ├── footer.php
├── pages/
│   ├── dashboard.php
│   ├── data_siswa.php
│   ├── tambah_siswa.php
│   └── edit_siswa.php
├── index.php
└── login.php
```

---

## 📜 Lisensi
Proyek ini dikembangkan untuk keperluan pembelajaran dan dapat digunakan serta dimodifikasi secara bebas untuk pengembangan sistem informasi sekolah lainnya.

---

## 💡 Kontributor
Dikembangkan oleh tim pengembang **SimaSek** dengan tujuan meningkatkan efisiensi administrasi sekolah.

---
