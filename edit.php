<?php
include "koneksi.php";
include "auth.php";
wajib_role(['admin', 'petugas']);

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (isset($_POST['update'])) {
    $id     = (int) $_POST['id_supplier'];
    $nama   = trim($_POST['nama_supplier']);
    $jenis  = $_POST['jenis_pasokan'];
    $barang = trim($_POST['barang_pasokan']);
    $alamat = trim($_POST['alamat_toko']);
    $telp   = trim($_POST['no_telepon']);

    $stmt = mysqli_prepare($koneksi, "UPDATE supplier SET
        nama_supplier=?, jenis_pasokan=?, barang_pasokan=?, alamat_toko=?, no_telepon=?
        WHERE id_supplier=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $nama, $jenis, $barang, $alamat, $telp, $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?pesan=" . urlencode("Supplier berhasil diperbarui."));
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM supplier WHERE id_supplier=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$row) {
    header("Location: index.php?pesan=" . urlencode("Data tidak ditemukan."));
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Supplier</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Edit Supplier</h1>
  <p>Modul Supplier Bahan Baku</p>
</header>

<div class="container">
  <form method="post">

    <input type="hidden" name="id_supplier" value="<?= $row['id_supplier'] ?>">

    <div class="form-group">
      <label>Nama Supplier</label>
      <input type="text" name="nama_supplier" value="<?= htmlspecialchars($row['nama_supplier']) ?>" required>
    </div>

    <div class="form-group">
      <label>Jenis Pasokan</label>
      <select name="jenis_pasokan" required>
        <option value="Segar"  <?= $row['jenis_pasokan'] == 'Segar'  ? 'selected' : '' ?>>Segar</option>
        <option value="Kering" <?= $row['jenis_pasokan'] == 'Kering' ? 'selected' : '' ?>>Kering</option>
      </select>
    </div>

    <div class="form-group">
      <label>Barang Pasokan</label>
      <input type="text" name="barang_pasokan" value="<?= htmlspecialchars($row['barang_pasokan']) ?>" required>
    </div>

    <div class="form-group">
      <label>Alamat Toko / Vendor</label>
      <textarea name="alamat_toko" rows="3" required><?= htmlspecialchars($row['alamat_toko']) ?></textarea>
    </div>

    <div class="form-group">
      <label>No. Telepon</label>
      <input type="text" name="no_telepon" value="<?= htmlspecialchars($row['no_telepon']) ?>" required>
    </div>

    <button type="submit" name="update" class="btn">Update</button>
    <a href="index.php" class="btn">Batal</a>

  </form>
</div>

</body>
</html>