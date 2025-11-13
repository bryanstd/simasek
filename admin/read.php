<?php
session_start();
include "../connection.php";

if (empty($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
  header("Location: /");
  exit();
}

$student = null;

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
  $id = (int) $_GET["id"];
  $stmt = $db->prepare("SELECT id, nis, email, nama_lengkap, tempat_lahir, tanggal_lahir, alamat FROM user WHERE id = ?");
  $stmt->bind_param("i", $id);
} elseif (isset($_GET["nis"])) {
  $nis = trim($_GET["nis"]);
  $stmt = $db->prepare("SELECT id, nis, email, nama_lengkap, tempat_lahir, tanggal_lahir, alamat FROM user WHERE nis = ?");
  $stmt->bind_param("s", $nis);
} else {
  $_SESSION["error"] = "Parameter tidak lengkap.";
  header("Location: datasiswa.php");
  exit();
}

$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
  $_SESSION["error"] = "Siswa tidak ditemukan.";
  header("Location: datasiswa.php");
  exit();
}

function e($str) {
  return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Siswa - SimaSek</title>
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

    /* === Sidebar === */
    .sidebar {
      width: 250px;
      background: #1e40af;
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

    /* === Content === */
    .content {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* === Topbar === */
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

    /* === Card Detail Siswa === */
    .dashboard {
      padding: 30px;
      display: flex;
      justify-content: center;
    }

    .card {
      width: 90%;
      max-width: 800px;
      background: white;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
      padding: 30px;
      border-top: 5px solid #2563eb;
    }

    .profile-info {
      display: flex;
      align-items: center;
      gap: 20px;
      border-bottom: 1px solid #e5e7eb;
      padding-bottom: 20px;
      margin-bottom: 25px;
    }

    .profile-info img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      border: 3px solid #dbeafe;
    }

    .profile-info h2 {
      font-size: 1.5rem;
      color: #1e3a8a;
      margin: 0;
    }

    .profile-info p {
      margin: 4px 0 0;
      color: #475569;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px 40px;
    }

    .info-grid div {
      display: flex;
      flex-direction: column;
    }

    .info-grid label {
      color: #64748b;
      font-size: 0.9rem;
      margin-bottom: 4px;
    }

    .info-grid p {
      margin: 0;
      font-weight: 600;
      color: #0f172a;
    }

    .full {
      grid-column: span 2;
    }

    .back-btn {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 18px;
      background: #2563eb;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: background 0.25s;
    }

    .back-btn:hover {
      background: #1e3a8a;
    }

    @media(max-width: 768px) {
      .sidebar { width: 70px; align-items: center; }
      .sidebar .logo, .sidebar nav a span { display: none; }
      .sidebar nav a i { margin: 0 auto; }
      .info-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2 class="logo">SimaSek</h2>
    <nav>
      <a href="/admin/"><i class="ri-dashboard-3-line"></i> <span>Dashboard</span></a>
      <a href="datasiswa.php" class="active"><i class="ri-group-line"></i> <span>Data Siswa</span></a>
      <a href="/logout.php" class="logout"><i class="ri-logout-box-line"></i> <span>Logout</span></a>
    </nav>
  </aside>

  <main class="content">
    <header class="topbar">
      <p>Detail Siswa</p>
      <div class="profile">
        <img src="https://ui-avatars.com/api/?name=A&background=2563eb&color=fff" alt="Admin">
        <span>Admin</span>
      </div>
    </header>

    <section class="dashboard">
      <div class="card">
        <div class="profile-info">
          <img src="https://ui-avatars.com/api/?name=<?= urlencode($student['nama_lengkap']) ?>&background=2563eb&color=fff" alt="Avatar">
          <div>
            <h2><?= e($student['nama_lengkap']) ?></h2>
            <p><?= e($student['email']) ?></p>
          </div>
        </div>

        <div class="info-grid">
          <div>
            <label>NIS</label>
            <p><?= e($student['nis']) ?></p>
          </div>
          <div>
            <label>Tempat Lahir</label>
            <p><?= e($student['tempat_lahir']) ?></p>
          </div>
          <div>
            <label>Tanggal Lahir</label>
            <p><?= e($student['tanggal_lahir'] ?: '-') ?></p>
          </div>
          <div class="full">
            <label>Alamat</label>
            <p><?= nl2br(e($student['alamat'])) ?></p>
          </div>
        </div>

        <a href="datasiswa.php" class="back-btn"><i class="ri-arrow-left-line"></i> Kembali</a>
      </div>
    </section>
  </main>

</body>
</html>
