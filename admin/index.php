<?php
include_once __DIR__ . '/../connection.php';

function totalSiswa() {
  global $db;
  $result = $db->query("SELECT COUNT(*) AS total_siswa FROM user WHERE role='siswa'");
  $row = $result->fetch_assoc();
  return $row['total_siswa'];
}

function siswaTerbaru() {
  global $db;
  $result = $db->query("SELECT nis, nama_lengkap, tempat_lahir FROM user WHERE role='siswa' ORDER BY id DESC LIMIT 10");
  $list = [];
  if ($result) {
    while ($row = $result->fetch_assoc()) {
      $list[] = $row;
    }
  }
  return $list;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - SimaSek</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <aside class="sidebar">
    <h2 class="logo">SimaSek</h2>
    <nav>
      <a href="#" class="active">Dashboard</a>
      <a href="/simasek/admin/datasiswa.php">Data Siswa</a>
      <a href="/simasek/logout.php" class="logout">Logout</a>
    </nav>
  </aside>

  <main class="content">
    <header class="topbar">
      <p>Dashboard</p>
    </header>

    <section class="dashboard">
      <div class="card">
        <h3>Total Siswa</h3>
        <p><?= totalSiswa(); ?></p>
      </div>

      <div class="card">
        <h3>10 Siswa Terbaru</h3>
        <ul class="latest-list">
          <?php foreach (siswaTerbaru() as $siswa): ?>
            <li><?= htmlspecialchars($siswa['nis']) ?> - <?= htmlspecialchars($siswa['nama_lengkap']) ?> - <?= htmlspecialchars($siswa['tempat_lahir']) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  </main>

</body>
</html>