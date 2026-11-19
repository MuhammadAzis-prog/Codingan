<?php
// auth.php - pengganti "middleware" pada PHP native.
// Dipanggil di setiap halaman modul untuk mengecek login & role.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
function sudah_login() {
    return isset($_SESSION['id_user']);
}

// Ambil role user saat ini (admin / petugas / null jika guest)
function role_user() {
    return $_SESSION['role'] ?? null;
}

// Middleware "auth": Guest diarahkan ke halaman login
function wajib_login() {
    if (!sudah_login()) {
        header("Location: login.php?pesan=" . urlencode("Silakan login terlebih dahulu."));
        exit;
    }
}

// Middleware "role": hanya role tertentu yang boleh masuk
// contoh: wajib_role(['admin'])  atau  wajib_role(['admin','petugas'])
function wajib_role(array $role_diizinkan) {
    wajib_login();
    if (!in_array(role_user(), $role_diizinkan, true)) {
        header("Location: index.php?pesan=" . urlencode("Anda tidak punya hak akses untuk aksi tersebut."));
        exit;
    }
}

// Helper untuk menyembunyikan tombol di tampilan
function adalah_admin() {
    return role_user() === 'admin';
}
