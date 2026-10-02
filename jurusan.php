<?php 
include 'koneksi.php'; 
wajib_level('admin'); 

if (isset($_POST['tambah'])) {
    $nama_jurusan = mysqli_real_escape_string($koneksi, $_POST['nama_jurusan']);
    if (!empty(trim($nama_jurusan))) {
        mysqli_query($koneksi, "INSERT INTO tb_jurusan (nama_jurusan) VALUES ('$nama_jurusan')");
    }
    header("Location: jurusan.php");
    exit();
}

if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM tb_jurusan WHERE id_jurusan='$id'");
    header("Location: jurusan.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Jurusan - SMK Digital App</title>
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
        }

        .topbar h1 {
            font-size: 22px;
            color: var(--text-dark);
        }

        .user-profile {
            font-size: 13px;
            color: var(--text-muted);
            background: white;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid var(--border);
        }

        /* PANEL & TABLE STYLING */
        .panel {
            background: var(--card-bg);
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            max-width: 800px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* BUTTONS & INPUTS */
        .btn {
            padding: 8px 16px;
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

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: var(--text-dark);
        }

        .form-row {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        th {
            background: #f1f5f9;
            color: #475569;
            font-weight: 600;
        }

        tr:hover td {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>

<!-- SIDEBAR NAVIGATION -->
<aside class="sidebar">
    <div class="brand">SMK Digital App</div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard Utama</a></li>
        <li class="nav-item"><a href="form_pendaftaran.php" class="nav-link">Form Pendaftaran</a></li>
        <li class="nav-item"><a href="jurusan.php" class="nav-link active">Master Data Jurusan</a></li>
        <li class="nav-item" style="margin-top: 25px; border-top: 1px solid #334155; padding-top: 10px;">
            <a href="logout.php" class="nav-link" style="color: #f87171;" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Keluar (Logout)</a>
        </li>
    </ul>
</aside>

<!-- MAIN CONTENT AREA -->
<main class="main-content">
    <!-- TOPBAR -->
    <header class="topbar">
        <h1>Master Data Jurusan</h1>
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <a href="dashboard.php" class="btn btn-secondary">&laquo; Kembali ke Dashboard Admin</a>
            <a href="form_pendaftaran.php" class="btn btn-primary">Kembali ke Form Pendaftaran</a>
            <a href="logout.php" class="btn btn-danger" style="padding: 9px 14px;" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Keluar</a>
        </div>
    </header>

    <!-- PANEL KELOLA JURUSAN -->
    <section class="panel">
        <div class="panel-header">
            <div class="panel-title">Kelola Data Jurusan</div>
        </div>

        <form method="POST" class="form-row">
            <input type="text" name="nama_jurusan" class="form-control" placeholder="Nama Jurusan Baru (contoh: Rekayasa Perangkat Lunak)" required>
            <button type="submit" name="tambah" class="btn btn-primary" style="white-space: nowrap;">+ Tambah Jurusan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Nama Jurusan</th>
                    <th style="width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($koneksi, "SELECT * FROM tb_jurusan ORDER BY id_jurusan ASC");
                if ($q && mysqli_num_rows($q) > 0) {
                    while ($r = mysqli_fetch_assoc($q)) {
                        echo "<tr>
                            <td>{$r['id_jurusan']}</td>
                            <td><strong>" . htmlspecialchars($r['nama_jurusan']) . "</strong></td>
                            <td style='text-align: center;'>
                                <a href='jurusan.php?hapus={$r['id_jurusan']}' class='btn btn-danger' style='padding: 5px 12px;' onclick=\"return confirm('Hapus jurusan ini? Data siswa terkait juga dapat terpengaruh.')\">Hapus</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align: center; color: #94a3b8; padding: 20px;'>Belum ada jurusan tersimpan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</main>

</body>
</html>
