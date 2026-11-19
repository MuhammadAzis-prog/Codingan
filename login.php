<?php
include "koneksi.php";
include "auth.php";

// Jika sudah login, langsung ke halaman modul
if (sudah_login()) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($koneksi, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];
        header("Location: index.php");
        exit;
    }
    $error = "Username atau password salah.";
}

$pesan = $error != "" ? $error : ($_GET['pesan'] ?? "");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Supplier Bahan Baku</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Sistem Restoran &amp; Cafe</h1>
  <p>Login Modul Supplier Bahan Baku</p>
</header>

<div class="container" style="max-width:420px">
  <?php if ($pesan != ""): ?>
    <p><b><?= htmlspecialchars($pesan) ?></b></p>
  <?php endif; ?>

  <form method="post">
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" required autofocus>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <button type="submit" name="login" class="btn">Login</button>
  </form>
</div>

</body>
</html>
