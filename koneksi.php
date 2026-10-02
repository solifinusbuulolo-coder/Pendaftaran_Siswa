<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_siswa";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Helper: ambil data pengguna yang sedang login
function pengguna() {
    return $_SESSION["pengguna"] ?? null;
}

// Helper: pastikan pengguna sudah login
function wajib_login() {
    if (!pengguna()) {
        header("Location: login.php");
        exit();
    }
}

// Helper: pastikan level pengguna sesuai
function wajib_level($level) {
    wajib_login();
    $p = pengguna();
    if ($p["level"] !== $level) {
        if ($p["level"] === "pendaftar") {
            header("Location: form_pendaftaran.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    }
}

// Helper: flash message
function set_pesan($tipe, $teks) {
    $_SESSION["pesan"] = ["tipe" => $tipe, "teks" => $teks];
}

function ambil_pesan() {
    if (isset($_SESSION["pesan"])) {
        $pesan = $_SESSION["pesan"];
        unset($_SESSION["pesan"]);
        return $pesan;
    }
    return null;
}
?>
