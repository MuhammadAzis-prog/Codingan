<?php
include "koneksi.php";
include "auth.php";
wajib_role(['admin']); // hanya admin yang boleh menghapus

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$stmt = mysqli_prepare($koneksi, "DELETE FROM supplier WHERE id_supplier=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: index.php?pesan=" . urlencode("Supplier berhasil dihapus."));
exit;