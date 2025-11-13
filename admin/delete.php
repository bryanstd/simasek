<?php
session_start();
include '../connection.php';

if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Parameter ID tidak valid.";
    header("Location: siswa.php");
    exit;
}

$id = (int) $_GET['id'];

$stmt = $db->prepare('SELECT nama_lengkap FROM user WHERE id = ?');
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Siswa tidak ditemukan.";
    header("Location: datasiswa.php");
    exit;
}

$row = $result->fetch_assoc();
$nama = $row['nama_lengkap'];
$stmt->close();

$stmt = $db->prepare('DELETE FROM user WHERE id = ?');
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $action = "Siswa dihapus: " . $nama;
    $log_stmt = $db->prepare("INSERT INTO aktivitas_terakhir (action) VALUES (?)");
    $log_stmt->bind_param("s", $action);
    $log_stmt->execute();
    $log_stmt->close();

    $_SESSION['success'] = "Siswa '$nama' berhasil dihapus!";
} else {
    $_SESSION['error'] = "Gagal menghapus siswa: " . $stmt->error;
}

$stmt->close();

header("Location: datasiswa.php");
exit;
?>
