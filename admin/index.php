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

function aktivitasTerakhir() {
  global $db;
  $result = $db->query("SELECT * from aktivitas_terakhir ORDER BY id DESC LIMIT 1");
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f0f4ff;
      display: flex;
      min-height: 100vh;
      color: #333;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background: #1e40af; /* biru utama */
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }
    .logo {
      font-size: 22px;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
    }
    nav a {
      color: #e2e8f0;
      text-decoration: none;
      padding: 10px 15px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
      transition: background 0.3s;
    }
    nav a.active, nav a:hover {
      background: #2563eb;
      color: #fff;
    }
    nav a.logout {
      margin-top: auto;
      background: #dc2626;
      color: white;
      text-align: center;
    }

    /* Content */
    .content {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* Topbar */
    .topbar {
      background: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .topbar p {
      font-size: 18px;
      font-weight: 600;
      color: #1e3a8a;
    }
    .profile {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .profile img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
    }

    /* Dashboard Section */
    .dashboard {
      padding: 25px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
      padding: 20px;
      transition: transform 0.2s;
      border-top: 5px solid #2563eb;
    }
    .card:hover {
      transform: translateY(-3px);
    }
    .card h3 {
      font-size: 16px;
      margin-bottom: 10px;
      color: #2563eb;
    }
    .card p {
      font-size: 24px;
      font-weight: bold;
      color: #0f172a;
    }

    /* Latest List */
    .latest-list {
      list-style: none;
      padding: 0;
      margin-top: 10px;
      max-height: 250px;
      overflow-y: auto;
    }
    .latest-list li {
      background: #f8fafc;
      margin-bottom: 8px;
      border-radius: 6px;
      padding: 8px 10px;
      font-size: 14px;
      border-left: 4px solid #2563eb;
    }

    /* Search */
    .search-box {
      display: flex;
      align-items: center;
      background: #f1f5f9;
      border-radius: 8px;
      padding: 8px 10px;
      gap: 10px;
    }
    .search-box input {
      border: none;
      outline: none;
      background: none;
      width: 100%;
    }

    @media(max-width: 768px) {
      .sidebar { width: 70px; align-items: center; }
      .sidebar .logo, .sidebar nav a span { display: none; }
      .sidebar nav a i { margin: 0 auto; }
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2 class="logo">SimaSek</h2>
    <nav>
      <a href="#" class="active"><i class="ri-dashboard-3-line"></i> <span>Dashboard</span></a>
      <a href="/admin/datasiswa.php"><i class="ri-group-line"></i> <span>Data Siswa</span></a>
      <a href="/logout.php" class="logout"><i class="ri-logout-box-line"></i> <span>Logout</span></a>
    </nav>
  </aside>

  <main class="content">
    <header class="topbar">
      <p>Dashboard</p>
      <div class="profile">
        <img src="https://ui-avatars.com/api/?name=A&background=2563eb&color=fff" alt="Admin">
        <span>Admin</span>
      </div>
    </header>

    <section class="dashboard">

      <div class="card">
        <h3>Aktivitas Terakhir</h3>
        <?php foreach (aktivitasTerakhir() as $aktivitas): ?>
        <p><?= htmlspecialchars($aktivitas['action']) ?></p>
        <?php endforeach; ?>
      </div>

      <div class="card">
        <h3>10 Siswa Terbaru</h3>
        <ul class="latest-list" id="siswaList">
          <?php foreach (siswaTerbaru() as $siswa): ?>
            <li><?= htmlspecialchars($siswa['nis']) ?> - <?= htmlspecialchars($siswa['nama_lengkap']) ?> - <?= htmlspecialchars($siswa['tempat_lahir']) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </section>
  </main>

  <script>
    const search = document.getElementById('search');
    const list = document.getElementById('siswaList');
    search.addEventListener('keyup', function() {
      const term = this.value.toLowerCase();
      [...list.children].forEach(li => {
        li.style.display = li.textContent.toLowerCase().includes(term) ? '' : 'none';
      });
    });
  </script>

</body>
</html>
