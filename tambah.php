<?php
include "koneksi.php";
include "auth.php";
wajib_role(['admin', 'petugas']);

if (isset($_POST['simpan'])) {
    $nama   = trim($_POST['nama_supplier']);
    $jenis  = $_POST['jenis_pasokan'];
    $barang = trim($_POST['barang_pasokan']);
    $alamat = trim($_POST['alamat_toko']);
    $telp   = trim($_POST['no_telepon']);

    $stmt = mysqli_prepare($koneksi, "INSERT INTO supplier
        (nama_supplier, jenis_pasokan, barang_pasokan, alamat_toko, no_telepon)
        VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $nama, $jenis, $barang, $alamat, $telp);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?pesan=" . urlencode("Supplier berhasil ditambahkan."));
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Supplier</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <h1>Tambah Supplier</h1>
  <p>Modul Supplier Bahan Baku</p>
</header>

<div class="container">
  <form method="post">

    <div class="form-group">
      <label>Nama Supplier</label>
      <input type="text" name="nama_supplier" required>
    </div>

    <div class="form-group">
      <label>Jenis Pasokan</label>
      <select name="jenis_pasokan" required>
        <option value="Segar">Segar</option>
        <option value="Kering">Kering</option>
      </select>
    </div>

    <div class="form-group">
      <label>Barang Pasokan</label>
      <input type="text" name="barang_pasokan" placeholder="Contoh: Sayuran, daging, beras" required>
    </div>

    <div class="form-group">
      <label>Alamat Toko / Vendor</label>
      <textarea name="alamat_toko" rows="3" required></textarea>
    </div>

    <div class="form-group">
      <label>No. Telepon</label>
      <input type="text" name="no_telepon" required>
    </div>

    <button type="submit" name="simpan" class="btn">Simpan</button>
    <a href="index.php" class="btn">Batal</a>

  </form>
</div>

</body>
</html>