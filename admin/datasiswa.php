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
    $db->query("INSERT INTO aktivitas_terakhir (action) VALUES ('Siswa baru ditambahkan, $nama')");
    $_SESSION['success'] = "Siswa baru berhasil dibuat (NIS $nextNis, password default = a)";
  } else {
    $_SESSION['error'] = "Gagal menambah siswa: " . $db->error;
  }

  header("Location: datasiswa.php");
  exit;
}

$siswa = $db->query("SELECT * FROM user WHERE role='siswa' ORDER BY id DESC");

$success = $_SESSION['success'] ?? "";
$error   = $_SESSION['error'] ?? "";

unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Siswa - SimaSek</title>
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

    /* Dashboard layout */
    .dashboard {
      padding: 25px;
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 20px;
    }

    /* Card */
    .card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
      padding: 20px;
      border-top: 5px solid #2563eb;
    }
    .card h3 {
      color: #2563eb;
      margin-bottom: 15px;
    }

    /* Form */
    form {
      display: grid;
      gap: 10px;
    }
    label {
      font-size: 14px;
      color: #475569;
      margin-top: 5px;
    }
    input, textarea {
      padding: 8px 10px;
      border: 1px solid #cbd5e1;
      border-radius: 6px;
      font-size: 14px;
      outline: none;
    }
    input:focus, textarea:focus {
      border-color: #2563eb;
    }
    button {
      background: #2563eb;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
      margin-top: 10px;
      transition: background 0.2s;
    }
    button:hover {
      background: #1e3a8a;
    }

    /* Table */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }
    th, td {
      border-bottom: 1px solid #e5e7eb;
      padding: 10px 12px;
      text-align: left;
    }
    th {
      background: #f3f4f6;
      color: #1e3a8a;
    }
    tr:hover {
      background: #f9fafb;
    }
    td a {
      margin-right: 8px;
      font-size: 16px;
    }

    .success { color: green; }
    .error { color: red; }

    @media(max-width: 900px) {
      .dashboard { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <aside class="sidebar">
    <h2 class="logo">SimaSek</h2>
    <nav>
      <a href="/admin/"><i class="ri-dashboard-3-line"></i> <span>Dashboard</span></a>
      <a href="#" class="active"><i class="ri-group-line"></i> <span>Data Siswa</span></a>
      <a href="/logout.php" class="logout"><i class="ri-logout-box-line"></i> <span>Logout</span></a>
    </nav>
  </aside>

  <main class="content">
    <header class="topbar">
      <p>Data Siswa</p>
      <div class="profile">
        <img src="https://ui-avatars.com/api/?name=A&background=2563eb&color=fff" alt="Admin" style="width:35px;height:35px;border-radius:50%;">
      </div>
    </header>

    <section class="dashboard">

      <!-- Form Tambah -->
      <div class="card">
        <h3><i class="ri-user-add-line"></i> Tambah Siswa Baru</h3>
        <?php if ($error): ?><p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
        <?php if ($success): ?><p class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>

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
          <textarea name="alamat" rows="3" required></textarea>

          <p><strong>NIS Otomatis:</strong> <?= $nextNis ?></p>
          <button type="submit"><i class="ri-save-line"></i> Simpan</button>
        </form>
      </div>

      <!-- Daftar Siswa -->
      <div class="card">
        <h3><i class="ri-list-check"></i> Daftar Siswa</h3>
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
                  <a href="read.php?id=<?= $row['id'] ?>" title="Lihat Detail" style="color:#2563eb;"><i class="ri-information-line"></i></a>
                  <a href="update.php?id=<?= $row['id'] ?>" title="Edit" style="color:#f59e0b;"><i class="ri-edit-2-line"></i></a>
                  <a href="delete.php?id=<?= $row['id'] ?>" title="Hapus" style="color:#ef4444;" onclick="return confirm('Yakin hapus siswa ini?')"><i class="ri-delete-bin-6-line"></i></a>
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
