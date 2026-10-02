<?php
include 'koneksi.php';
wajib_level('admin');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    $q = mysqli_query($koneksi, "SELECT foto FROM tb_siswa WHERE id='$id'");
    if ($q && mysqli_num_rows($q) > 0) {
        $data = mysqli_fetch_assoc($q);
        $foto_lama = $data['foto'];

        if (!empty($foto_lama) && file_exists("uploads/" . $foto_lama)) {
            unlink("uploads/" . $foto_lama);
        }
    }

    $sql = "DELETE FROM tb_siswa WHERE id='$id'";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
