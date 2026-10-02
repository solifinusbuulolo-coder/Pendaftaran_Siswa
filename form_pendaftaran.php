<?php 
include 'koneksi.php'; 
wajib_login();

$user = pengguna();
$sukses_id = isset($_GET['sukses']) && isset($_GET['id']) ? (int)$_GET['id'] : null;

// Ambil data siswa yang baru didaftarkan jika ada ID sukses
$data_sukses = null;
if ($sukses_id) {
    $q_sukses = mysqli_query($koneksi, "SELECT tb_siswa.*, tb_jurusan.nama_jurusan 
                                        FROM tb_siswa 
                                        JOIN tb_jurusan ON tb_siswa.id_jurusan = tb_jurusan.id_jurusan 
                                        WHERE tb_siswa.id = '$sukses_id'");
    if ($q_sukses && mysqli_num_rows($q_sukses) > 0) {
        $data_sukses = mysqli_fetch_assoc($q_sukses);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Siswa Baru - SMK Digital App</title>
    <style>
        :root {
            --bg-body: #f8fafc;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --card-bg: #ffffff;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
            --success-border: #a7f3d0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            color: #fff;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar .brand {
            font-size: 16px;
            font-weight: bold;
            padding-bottom: 20px;
            border-bottom: 1px solid #334155;
            color: #38bdf8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sidebar .nav-menu {
            margin-top: 20px;
            list-style: none;
        }

        .sidebar .nav-item {
            margin-bottom: 5px;
        }

        .sidebar .nav-link {
            display: block;
            padding: 10px 14px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--sidebar-hover);
            color: #ffffff;
            font-weight: 500;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            flex: 1;
            padding: 25px 30px;
            overflow-x: auto;
        }

        /* TOPBAR / HEADER */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .topbar h1 {
            font-size: 22px;
            color: var(--text-dark);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* BUTTONS */
        .btn {
            padding: 9px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: var(--text-dark);
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        .btn-green {
            background-color: #28a745;
            color: white;
        }

        .btn-green:hover {
            background-color: #218838;
        }

        /* PANEL & FORM STYLING */
        .panel {
            background: var(--card-bg);
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 26px 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            max-width: 750px;
        }

        .panel-header {
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .panel-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        textarea.form-control {
            min-height: 70px;
            resize: vertical;
        }

        /* SUCCESS ALERT */
        .alert-success {
            background-color: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            max-width: 750px;
        }

        .alert-success h4 {
            margin: 0 0 6px;
            font-size: 15px;
        }

        .alert-success p {
            font-size: 13px;
            margin-bottom: 12px;
        }

        .btn-print {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-print:hover {
            background: #059669;
        }
    </style>
</head>
<body>

<!-- SIDEBAR NAVIGATION -->
<aside class="sidebar">
    <div class="brand">SMK Digital App</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard Utama</a></li>
        <li class="nav-item"><a href="form_pendaftaran.php" class="nav-link active">Form Pendaftaran</a></li>
        <li class="nav-item"><a href="jurusan.php" class="nav-link">Master Data Jurusan</a></li>
        <li class="nav-item" style="margin-top: 25px; border-top: 1px solid #334155; padding-top: 10px;">
            <a href="logout.php" class="nav-link" style="color: #f87171;" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Keluar (Logout)</a>
        </li>
    </ul>
</aside>

<!-- MAIN CONTENT AREA -->
<main class="main-content">
    <!-- TOPBAR DENGAN 2 TOMBOL DI POJOK KANAN ATAS -->
    <header class="topbar">
        <h1>Form Pendaftaran Siswa Baru</h1>
        <div class="topbar-actions">
            <a href="dashboard.php" class="btn btn-secondary">&laquo; Kembali ke Dashboard Admin</a>
            <a href="jurusan.php" class="btn btn-primary">Master Jurusan &raquo;</a>
        </div>
    </header>

    <?php if ($data_sukses): ?>
        <div class="alert-success">
            <h4>Pendaftaran Berhasil Disimpan!</h4>
            <p>Data pendaftaran siswa atas nama <strong><?php echo htmlspecialchars($data_sukses['nama']); ?></strong> (NIS: <?php echo htmlspecialchars($data_sukses['nis']); ?>) untuk jurusan <strong><?php echo htmlspecialchars($data_sukses['nama_jurusan']); ?></strong> telah berhasil tersimpan.</p>
            <a href="cetak.php?id=<?php echo (int)$data_sukses['id']; ?>" target="_blank" class="btn-print">Cetak Kartu Bukti Pendaftaran &raquo;</a>
        </div>
    <?php endif; ?>

    <!-- PANEL FORM PENDAFTARAN DARI FORM.PDF -->
    <section class="panel">
        <div class="panel-header">
            <div class="panel-title">Formulir Pendaftaran Siswa Baru</div>
        </div>

        <!-- FORM PENDAFTARAN DENGAN UPLOAD FILE -->
        <form action="simpan.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>NIS:</label>
                <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS..." required>
            </div>
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap..." required>
            </div>
            <div class="form-group">
                <label>Pilih Jurusan (Relasi Data):</label>
                <select name="id_jurusan" class="form-control" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <?php
                    $jur = mysqli_query($koneksi, "SELECT * FROM tb_jurusan");
                    if ($jur) {
                        while ($j = mysqli_fetch_assoc($jur)) {
                            echo "<option value='{$j['id_jurusan']}'>" . htmlspecialchars($j['nama_jurusan']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Upload Pasfoto (JPG/PNG, Max 2MB):</label>
                <input type="file" name="foto" class="form-control" accept="image/*" required>
            </div>
            <div class="form-group">
                <label>Alasan Masuk:</label>
                <textarea name="alasan" rows="2" class="form-control" placeholder="Tuliskan alasan memilih jurusan..." required></textarea>
            </div>
            <button type="submit" class="btn btn-green">Daftar Sekarang</button>
        </form>
    </section>
</main>

</body>
</html>
