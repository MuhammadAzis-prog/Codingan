<?php
include "koneksi.php";
include "auth.php";
wajib_login(); // Guest -> redirect ke login

$cari = isset($_GET['cari']) ? trim($_GET['cari']) : "";

if ($cari != "") {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM supplier
        WHERE nama_supplier LIKE ? OR barang_pasokan LIKE ? OR alamat_toko LIKE ?
        ORDER BY id_supplier ASC");
    $like = "%" . $cari . "%";
    mysqli_stmt_bind_param($stmt, "sss", $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
} else {
    $data = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id_supplier ASC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supplier Bahan Baku</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Sistem Restoran &amp; Cafe</h1>
  <p>Modul Supplier Bahan Baku</p>
  <div class="navbar">
    <span><?= htmlspecialchars($_SESSION['nama']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)</span>
    <a href="logout.php" class="btn">Logout</a>
  </div>
</header>

<div class="container">

  <?php if (isset($_GET['pesan'])): ?>
    <p><b><?= htmlspecialchars($_GET['pesan']) ?></b></p>
  <?php endif; ?>

  <div class="toolbar">
    <form method="get">
      <input type="text" name="cari" placeholder="Cari supplier..." value="<?= htmlspecialchars($cari) ?>">
      <button type="submit" class="btn">Cari</button>
      <a href="tambah.php" class="btn">Tambah Supplier</a>
    </form>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Supplier</th>
        <th>Jenis Pasokan</th>
        <th>Barang Pasokan</th>
        <th>Alamat Toko</th>
        <th>Telepon</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($row = mysqli_fetch_assoc($data)): ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
        <td><?= $row['jenis_pasokan'] ?></td>
        <td><?= htmlspecialchars($row['barang_pasokan']) ?></td>
        <td><?= htmlspecialchars($row['alamat_toko']) ?></td>
        <td><?= htmlspecialchars($row['no_telepon']) ?></td>
        <td>
          <a href="edit.php?id=<?= $row['id_supplier'] ?>" class="btn">Edit</a>
          <?php if (adalah_admin()): ?>
          <a href="hapus.php?id=<?= $row['id_supplier'] ?>" class="btn"
             onclick="return confirm('Yakin hapus supplier ini?')">Hapus</a>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>

      <?php if ($no == 1): ?>
      <tr><td colspan="7">Data supplier tidak ditemukan.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</div>

<footer>Studi Kasus 10 - Modul Individu D: Supplier Bahan Baku MUHAMMAD AZIS_102022500021</footer>

</body>
</html>