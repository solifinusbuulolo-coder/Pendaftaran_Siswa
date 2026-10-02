<?php
include "koneksi.php";
wajib_level("admin");

$id = (int) ($_GET["id"] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT * FROM tb_siswa WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$data) {
    header("Location: index.php");
    exit();
}
$pesan = ambil_pesan();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Pendaftar</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="wrap">
<div class="card" style="max-width:600px;margin:0 auto;">
    <div class="top">
        <h1>Edit Pendaftar</h1>
        <a class="btn btn-ghost" href="index.php">Kembali</a>
    </div>
    <?php if ($pesan): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($pesan["teks"]); ?></div>
    <?php endif; ?>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo (int) $data["id"]; ?>">
        <div class="form-group">
            <label>NIS</label>
            <input type="text" name="nis" value="<?php echo htmlspecialchars($data["nis"]); ?>" required>
        </div>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($data["nama"]); ?>" required>
        </div>
        <div class="row2">
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="<?php echo htmlspecialchars((string) ($data["tempat_lahir"] ?? "")); ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars((string) ($data["tanggal_lahir"] ?? "")); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Jurusan</label>
            <select name="jurusan">
                <option value="RPL" <?php if ($data["jurusan"] == "RPL") echo "selected"; ?>>Rekayasa Perangkat Lunak</option>
                <option value="TKJ" <?php if ($data["jurusan"] == "TKJ") echo "selected"; ?>>Teknik Komputer & Jaringan</option>
                <option value="MM" <?php if ($data["jurusan"] == "MM") echo "selected"; ?>>Multimedia</option>
            </select>
        </div>
        <div class="form-group">
            <label>Alasan Masuk</label>
            <textarea name="alasan" rows="3"><?php echo htmlspecialchars($data["alasan"]); ?></textarea>
        </div>
        <button type="submit" class="btn">Simpan</button>
        <a href="index.php" class="btn btn-ghost">Batal</a>
    </form>
</div>
</div>
</body>
</html>
