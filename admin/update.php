<?php
session_start();
include '../connection.php';

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Cek ID siswa
if (!isset($_GET['id'])) {
    echo "ID siswa tidak ditemukan!";
    exit();
}

$id = intval($_GET['id']);

// Ambil data siswa berdasarkan ID
$stmt = $db->prepare("SELECT * FROM user WHERE id = ? AND role = 'siswa'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();

if (!$siswa) {
    echo "Data siswa tidak ditemukan!";
    exit();
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = htmlspecialchars(trim($_POST['nis']));
    $nama_lengkap = htmlspecialchars(trim($_POST['nama_lengkap']));
    $email = htmlspecialchars(trim($_POST['email']));
    $tempat_lahir = htmlspecialchars(trim($_POST['tempat_lahir']));
    $tanggal_lahir = htmlspecialchars(trim($_POST['tanggal_lahir']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));
    $password = $_POST['password'];

    if (empty($nis) || empty($nama_lengkap) || empty($email)) {
        $error = "NIS, Nama Lengkap, dan Email wajib diisi!";
    } else {
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "UPDATE user SET nis=?, nama_lengkap=?, email=?, tempat_lahir=?, tanggal_lahir=?, alamat=?, password=? WHERE id=? AND role='siswa'";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sssssssi", $nis, $nama_lengkap, $email, $tempat_lahir, $tanggal_lahir, $alamat, $password_hash, $id);
        } else {
            $query = "UPDATE user SET nis=?, nama_lengkap=?, email=?, tempat_lahir=?, tanggal_lahir=?, alamat=? WHERE id=? AND role='siswa'";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssssssi", $nis, $nama_lengkap, $email, $tempat_lahir, $tanggal_lahir, $alamat, $id);
        }

        if ($stmt->execute()) {
            $db->query("INSERT INTO aktivitas_terakhir (action) VALUES ('Data siswa diperbarui: $nama_lengkap')");
            $_SESSION['success'] = "Data siswa berhasil diperbarui!";
            header("Location: datasiswa.php");
            exit();
        } else {
            $error = "Gagal memperbarui data siswa.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Siswa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen">

  <div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Data Siswa</h1>

    <?php if (isset($error)): ?>
      <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-2 rounded mb-4">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="bg-white shadow-md rounded-xl p-6 space-y-5">

      <div>
        <label class="block text-gray-700 font-medium mb-1">NIS</label>
        <input type="text" name="nis" value="<?= htmlspecialchars($siswa['nis']) ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="<?= htmlspecialchars($siswa['nama_lengkap']) ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($siswa['email']) ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-gray-700 font-medium mb-1">Tempat Lahir</label>
          <input type="text" name="tempat_lahir" value="<?= htmlspecialchars($siswa['tempat_lahir']) ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
          <label class="block text-gray-700 font-medium mb-1">Tanggal Lahir</label>
          <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($siswa['tanggal_lahir']) ?>" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Alamat</label>
        <textarea name="alamat" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?= htmlspecialchars($siswa['alamat']) ?></textarea>
      </div>

      <div>
        <label class="block text-gray-700 font-medium mb-1">Password (kosongkan jika tidak diubah)</label>
        <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div class="flex justify-between items-center pt-4">
        <a href="datasiswa.php" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">← Kembali</a>
        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Perubahan</button>
      </div>

    </form>
  </div>

</body>
</html>
