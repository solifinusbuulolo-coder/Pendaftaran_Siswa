<?php
include "koneksi.php";

// Jika belum login, halaman yang pertama muncul adalah login.php
if (!pengguna()) {
    header("Location: login.php");
    exit();
}

// Jika sudah login, arahkan sesuai peran/level
$user = pengguna();
if ($user["level"] === "admin") {
    header("Location: dashboard.php");
} else {
    header("Location: form_pendaftaran.php");
}
exit();
?>
