<?php
session_start();
include './connection.php';
include './auth/validation.php';

$islogin = false;
$error = "";

if (!empty($_SESSION['usertype']) && !empty($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: /admin/");
        exit;
    } elseif ($_SESSION['role'] === 'siswa') {
        header("Location: /siswa/");
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password']));

    $check = isUserValid($db, $email, $password);

    if ($check) {
        $_SESSION['usertype'] = $check['email'];
        $_SESSION['role'] = $check['role'];
        $_SESSION['nama'] = $check['nama_lengkap'];
        $islogin = true;

        if ($check['role'] === 'admin') {
            header("Location: /admin/");
            exit;
        } elseif ($check['role'] === 'siswa') {
            header("Location: /siswa/");
            exit;
        } else {
            $error = "Role tidak dikenali!";
        }
    } else {
        $error = "Email atau password salah, silakan coba lagi!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | SimaSek</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body class="login-page">
  <div class="login-container">
    <img src="https://cdn-icons-png.freepik.com/512/9703/9703596.png" class="login-logo">
    <h1 class="title">Login SimaSek</h1>
    <p class="subtitle">Silakan login sebagai <b>Admin</b> atau <b>Siswa</b></p>

    <?php if (!empty($error)): ?>
      <p style="color: red; text-align:center;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
      <label>Email</label>
      <input type="text" name="email" required>

      <label>Password</label>
      <input type="password" name="password" required>

      <button type="submit" class="btn-submit">Login</button>
    </form>
  </div>
</body>
</html>
