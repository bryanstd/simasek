<?php
session_start();
include '../connection.php';

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
  <title>Kartu Pelajar - SimaSek</title>
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

    .profile-header {
      display: flex;
      align-items: center;
      gap: 20px;
      border-bottom: 2px solid #e5e7eb;
      padding-bottom: 15px;
      margin-bottom: 20px;
    }

    .profile-header img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      border: 3px solid #2563eb;
      object-fit: cover;
    }

    .profile-header h5 {
      font-size: 1.3rem;
      color: #1e3a8a;
      margin: 0;
    }

    .profile-header small {
      color: #64748b;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px 40px;
      font-size: 0.95rem;
    }

    .info-grid label {
      color: #64748b;
      margin-bottom: 3px;
      display: block;
    }

    .info-grid p {
      font-weight: 600;
      color: #0f172a;
      margin: 0;
    }

    .btn-back {
      background: #2563eb;
      color: #fff;
      border-radius: 8px;
      padding: 10px 22px;
      text-decoration: none;
      font-weight: 500;
      display: inline-block;
      margin-top: 25px;
      transition: background 0.3s;
    }

    .btn-back:hover {
      background: #1e3a8a;
    }

    @media(max-width: 768px) {
      .info-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <h2 class="logo">SimaSek</h2>
    <nav>
      <a href="biodata.php"><i class="ri-id-card-line"></i> <span>Biodata</span></a>
      <a href="kartupelajar.php" class="active"><i class="ri-bank-card-line"></i> <span>Kartu Pelajar</span></a>
      <a href="../logout.php" class="logout"><i class="ri-logout-box-line"></i> <span>Logout</span></a>
    </nav>
  </aside>

  <!-- Content -->
  <main class="content">
    <header class="topbar">
      <p>Kartu Pelajar</p>
      <div class="profile">
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($siswa['nama_lengkap']); ?>&background=2563eb&color=fff" alt="Avatar">
      </div>
    </header>

    <section class="dashboard">
      <div class="card">
        <div class="profile-header">
          <img src="https://ui-avatars.com/api/?name=<?= urlencode($siswa['nama_lengkap']); ?>&background=2563eb&color=fff" alt="Foto Profil">
          <div>
            <h5><?= htmlspecialchars($siswa['nama_lengkap']); ?></h5>
            <small><?= htmlspecialchars($siswa['email']); ?></small>
          </div>
        </div>

        <h3><i class="ri-bank-card-2-line"></i> Informasi Kartu Pelajar</h3>
        <div class="info-grid">
          <div>
            <label>NIS</label>
            <p><?= htmlspecialchars($siswa['nis']); ?></p>
          </div>
          <div>
            <label>Tempat Lahir</label>
            <p><?= htmlspecialchars($siswa['tempat_lahir']); ?></p>
          </div>
          <div>
            <label>Tanggal Lahir</label>
            <p><?= htmlspecialchars($siswa['tanggal_lahir']); ?></p>
          </div>
          <div>
            <label>Alamat</label>
            <p><?= htmlspecialchars($siswa['alamat']); ?></p>
          </div>
        </div>

        <a href="biodata.php" class="btn-back"><i class="ri-arrow-left-line"></i> Kembali</a>
      </div>
    </section>
  </main>

</body>
</html>
