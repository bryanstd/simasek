<?php
session_start();
include '../connection.php';

// Cek login

$email = $_SESSION['usertype'];
$query = "SELECT * FROM user WHERE email = '$email' AND role = 'siswa'";
$result = mysqli_query($db, $query);
$siswa = mysqli_fetch_assoc($result);

if (!$siswa) {
    echo "Data siswa tidak ditemukan!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biodata Siswa - SimaSek</title>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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
      background: linear-gradient(180deg, #1e3a8a, #1e40af);
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 25px 20px;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }
    .logo {
      font-size: 22px;
      font-weight: 700;
      margin-bottom: 35px;
      text-align: center;
      letter-spacing: 0.5px;
    }
    nav a {
      color: #e2e8f0;
      text-decoration: none;
      padding: 12px 15px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 12px;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    nav a:hover,
    nav a.active {
      background: #2563eb;
      color: #fff;
      transform: translateX(5px);
    }
    nav a.logout {
      margin-top: auto;
      background: #dc2626;
      color: white;
      text-align: center;
      justify-content: center;
      font-weight: 600;
      transition: background 0.3s ease;
    }
    nav a.logout:hover {
      background: #b91c1c;
    }

    /* Content */
    .content {
      flex: 1;
      display: flex;
      flex-direction: column;
      background: #f9fafc;
    }

    /* Topbar */
    .topbar {
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .topbar p {
      font-size: 18px;
      font-weight: 600;
      color: #1e3a8a;
    }

    .profile img {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      border: 2px solid #2563eb;
      object-fit: cover;
    }

    /* Dashboard layout */
    .dashboard {
      padding: 40px 25px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    /* Card */
    .card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      padding: 25px 35px;
      border-top: 5px solid #2563eb;
      width: 100%;
      max-width: 700px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card h3 {
      color: #2563eb;
      margin-bottom: 20px;
      text-align: center;
      font-weight: 600;
    }

    .avatar {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .avatar img {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid #2563eb;
      object-fit: cover;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 15px;
      text-align: left;
    }
    th {
      background: #f3f4f6;
      color: #1e3a8a;
      font-weight: 600;
      width: 35%;
    }
    td {
      background: #fff;
      color: #374151;
    }
    tr:nth-child(even) td {
      background: #f9fafb;
    }

    @media(max-width: 900px) {
      .sidebar { width: 220px; }
      .content { padding-left: 0; }
      .card { padding: 20px; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2 class="logo">SimaSek</h2>
    <nav>
      <a href="biodata.php" class="active"><i class="ri-id-card-line"></i> <span>Biodata</span></a>
      <a href="kartupelajar.php"><i class="ri-bank-card-line"></i> <span>Kartu Pelajar</span></a>
      <a href="../logout.php" class="logout"><i class="ri-logout-box-line"></i> <span>Logout</span></a>
    </nav>
  </aside>

  <!-- Content -->
  <main class="content">
    <header class="topbar">
      <p>Biodata Siswa</p>
      <div class="profile">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($siswa['nama_lengkap']); ?>&background=2563eb&color=fff" alt="Avatar">
      </div>
    </header>

    <section class="dashboard">
      <div class="card">
        <div class="avatar">
          <img src="https://ui-avatars.com/api/?name=<?= urlencode($siswa['nama_lengkap']); ?>&background=2563eb&color=fff" alt="Foto Profil">
        </div>
        <h3><i class="ri-user-line"></i> Profil Lengkap</h3>
        <table>
          <tr><th>NIS</th><td><?= htmlspecialchars($siswa['nis']); ?></td></tr>
          <tr><th>Nama Lengkap</th><td><?= htmlspecialchars($siswa['nama_lengkap']); ?></td></tr>
          <tr><th>Tempat Lahir</th><td><?= htmlspecialchars($siswa['tempat_lahir']); ?></td></tr>
          <tr><th>Tanggal Lahir</th><td><?= htmlspecialchars($siswa['tanggal_lahir']); ?></td></tr>
          <tr><th>Alamat</th><td><?= htmlspecialchars($siswa['alamat']); ?></td></tr>
          <tr><th>Email</th><td><?= htmlspecialchars($siswa['email']); ?></td></tr>
        </table>
      </div>
    </section>
  </main>

</body>
</html>
