<?php
include '../connection.php';
session_start();

if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: /");
  exit;
}

$getLastNis = $db->query("SELECT MAX(nis) AS last_nis FROM user WHERE role='siswa'");
$row = $getLastNis->fetch_assoc();
$nextNis = $row['last_nis'] ? $row['last_nis'] + 1 : 1001;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email   = trim($_POST['email']);
  $nama    = trim($_POST['nama_lengkap']);
  $tempat  = trim($_POST['tempat_lahir']);
  $tgl     = trim($_POST['tanggal_lahir']);
  $alamat  = trim($_POST['alamat']);
  $password = md5("a");

  $sql = "INSERT INTO user(role,email,password,nama_lengkap,tempat_lahir,tanggal_lahir,alamat,nis) 
          VALUES('siswa','$email','$password','$nama','$tempat','$tgl','$alamat',$nextNis)";
  if ($db->query($sql)) {
    header("Location: ?success=" . urlencode("Siswa baru berhasil dibuat (NIS $nextNis, password default = a)"));
    exit;
  } else {
    header("Location: ?error=" . urlencode("Gagal menambah siswa: " . $db->error));
    exit;
  }
}

$siswa = $db->query("SELECT * FROM user WHERE role='siswa' ORDER BY id DESC");

// tampilkan pesan
$success = isset($_GET['success']) ? $_GET['success'] : "";
$error   = isset($_GET['error']) ? $_GET['error'] : "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Siswa - SimaSek</title>
  <link rel="stylesheet" href="style.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    th, td {
      border: 1px solid #e5e7eb;
      padding: 8px 12px;
      text-align: left;
    }
    th {
      background: #f3f4f6;
    }
    .action-btn {
      padding: 6px 10px;
      margin-right: 4px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.85rem;
    }
    .btn-read { background: #3b82f6; color: #fff; }
    .btn-update { background: #f59e0b; color: #fff; }
    .btn-delete { background: #ef4444; color: #fff; }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2 class="logo">SimaSek</h2>
    <nav>
      <a href="/admin/">Dashboard</a>
      <a href="#" class="active">Data Siswa</a>
      <a href="/logout.php" class="logout">Logout</a>
    </nav>
  </aside>

  <main class="content">
    <header class="topbar">
      <p>Data Siswa</p>
    </header>

    <section class="dashboard">
      <!-- Card Tambah -->
      <div class="card">
        <h3>Tambah Siswa Baru</h3>
        <?php if ($error): ?><p style="color:red;"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <?php if ($success): ?><p style="color:green;"><?= htmlspecialchars($success) ?></p><?php endif; ?>

        <form method="POST">
          <label>Email</label>
          <input type="email" name="email" required>

          <label>Nama Lengkap</label>
          <input type="text" name="nama_lengkap" required>

          <label>Tempat Lahir</label>
          <input type="text" name="tempat_lahir" required>

          <label>Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" required>

          <label>Alamat</label>
          <textarea name="alamat" required></textarea>

          <p>NIS Otomatis: <?= $nextNis ?></p>
          <button type="submit">Simpan</button>
        </form>
      </div>

      <!-- Card Daftar -->
      <div class="card">
        <h3>Daftar Siswa</h3>
        <table>
          <thead>
            <tr>
              <th>NIS</th>
              <th>Nama Lengkap</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $siswa->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['nis']) ?></td>
                <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                <td>
                  <a href="read.php?id=<?= $row['id'] ?>" class="action-btn btn-read">READ</a>
                  <a href="update.php?id=<?= $row['id'] ?>" class="action-btn btn-update">UPDATE</a>
                  <a href="delete.php?id=<?= $row['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Yakin hapus siswa ini?')">DELETE</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>
</html>