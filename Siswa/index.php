<?php
session_start();
include '../connection.php';

// Jika user sudah login
if (isset($_SESSION['usertype'])) {
    $email = $_SESSION['usertype'];

    // Cek role user
    $query = "SELECT role FROM user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['role'] === 'admin') {
            header("Location: ../admin/index.php");
            exit();
        } elseif ($user['role'] === 'siswa') {
            header("Location: biodata.php");
            exit();
        }
    }
}
?>
