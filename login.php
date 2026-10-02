<?php
include "koneksi.php";

// Jika sudah login, langsung arahkan ke halaman sesuai level
if ($user = pengguna()) {
    if ($user["level"] === "admin") {
        header("Location: dashboard.php");
    } else {
        header("Location: form_pendaftaran.php");
    }
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!empty($username) && !empty($password)) {
        $stmt = mysqli_prepare($koneksi, "SELECT id, username, password, level FROM users WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($hasil);

        if ($data && password_verify($password, $data["password"])) {
            $_SESSION["pengguna"] = [
                "id" => $data["id"],
                "username" => $data["username"],
                "level" => $data["level"],
            ];

            if ($data["level"] === "admin") {
                header("Location: dashboard.php");
            } else {
                header("Location: form_pendaftaran.php");
            }
            exit();
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Silakan isi semua field!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pendaftaran Siswa</title>
    <style>
        :root {
            --bg-body: #0f172a;
            --card-bg: #ffffff;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --danger-bg: #fee2e2;
            --danger-text: #991b1b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 32px 28px;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-badge {
            display: inline-block;
            background: #e0f2fe;
            color: #0284c7;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 8px;
        }

        .brand-header h1 {
            font-size: 22px;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .brand-header p {
            font-size: 13px;
            color: var(--text-muted);
        }

        .alert-error {
            background-color: var(--danger-bg);
            color: var(--danger-text);
            padding: 10px 14px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 18px;
            border: 1px solid #fecaca;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 11px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            margin-top: 6px;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        .account-helper {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--text-muted);
        }

        .account-helper strong {
            color: var(--text-dark);
        }

        .account-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 10px;
        }

        .account-btn {
            background: #f1f5f9;
            border: 1px solid var(--border);
            padding: 8px;
            border-radius: 6px;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 11px;
        }

        .account-btn:hover {
            background: #e2e8f0;
            border-color: #cbd5e1;
        }

        .account-btn .role-tag {
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }

        .role-admin { color: #2563eb; }
        .role-pendaftar { color: #059669; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-header">
        <span class="brand-badge">SMK Digital App</span>
        <h1>Masuk ke Akun</h1>
        <p>Silakan masuk sesuai hak akses Anda</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn-submit">Masuk Sekarang</button>
    </form>

    <div class="account-helper">
        <p><strong>Akun Demo Tersedia:</strong> (Klik untuk mengisi)</p>
        <div class="account-grid">
            <button type="button" class="account-btn" onclick="fillCreds('admin', 'admin')">
                <span class="role-tag role-admin">Administrator</span>
                admin / admin
            </button>
            <button type="button" class="account-btn" onclick="fillCreds('pendaftar', 'pendaftar')">
                <span class="role-tag role-pendaftar">Pendaftar</span>
                pendaftar / pendaftar
            </button>
        </div>
    </div>
</div>

<script>
function fillCreds(u, p) {
    document.getElementById('username').value = u;
    document.getElementById('password').value = p;
}
</script>

</body>
</html>
