<?php
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$namaUser = $_SESSION['nama'] ?? 'Penumpang';
$emailUser = $_SESSION['email'] ?? '';
$noHpUser = $_SESSION['no_hp'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda Penumpang - ANTARKU</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #1e293b; min-height: 100vh; }
    header.navbar {
      background: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      padding: 16px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 10;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      color: #0d3b2e;
      font-weight: 800;
      font-size: 18px;
    }
    .brand svg { width: 36px; height: 36px; }
    .nav-user {
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .badge-user {
      background: #eaf5ee;
      color: #007a53;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
    }
    .btn-logout {
      background: #fee2e2;
      color: #dc2626;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 13px;
      text-decoration: none;
      transition: background 0.2s;
    }
    .btn-logout:hover { background: #fecaca; }
    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .welcome-card {
      background: linear-gradient(135deg, #0d3b2e 0%, #007a53 100%);
      color: #ffffff;
      border-radius: 20px;
      padding: 36px;
      box-shadow: 0 10px 25px -5px rgba(0, 122, 83, 0.25);
      margin-bottom: 30px;
    }
    .welcome-card h1 { font-size: 28px; margin-bottom: 8px; font-weight: 800; }
    .welcome-card p { opacity: 0.9; font-size: 15px; }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }
    .card {
      background: #ffffff;
      border-radius: 16px;
      padding: 24px;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);
    }
    .card h3 { font-size: 17px; margin-bottom: 12px; color: #0f172a; }
    .card p { font-size: 14px; color: #64748b; line-height: 1.5; margin-bottom: 16px; }
    .btn-primary {
      display: inline-block;
      background: #007a53;
      color: #ffffff;
      padding: 10px 18px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      transition: background 0.2s;
    }
    .btn-primary:hover { background: #006344; }
  </style>
</head>
<body>
  <header class="navbar">
    <a href="<?= $base ?>/penumpang/beranda" class="brand">
      <img src="<?= $base ?>/aset/gambar/logo.png" alt="ANTARKU" style="height: 38px; width: auto; object-fit: contain;">
    </a>
    <div class="nav-user">
      <span class="badge-user">Penumpang: <?= htmlspecialchars($namaUser) ?></span>
      <a href="<?= $base ?>/logout" class="btn-logout">Keluar</a>
    </div>
  </header>

  <main class="container">
    <div class="welcome-card">
      <h1>Selamat Datang, <?= htmlspecialchars($namaUser) ?>!</h1>
      <p>Perjalanan nyaman dengan harga yang kamu tentukan sendiri.</p>
    </div>

    <div class="grid">
      <div class="card">
        <h3>Pesan Perjalanan Baru</h3>
        <p>Tentukan titik jemput dan tujuan, lalu ajukan tawaran tarif terbaikmu ke driver terdekat.</p>
        <a href="<?= $base ?>/pemesanan" class="btn-primary">Pesan Sekarang</a>
      </div>
      <div class="card">
        <h3>Informasi Akun</h3>
        <p><strong>Nama:</strong> <?= htmlspecialchars($namaUser) ?><br>
           <strong>Email:</strong> <?= htmlspecialchars($emailUser) ?><br>
           <strong>Nomor HP:</strong> <?= htmlspecialchars($noHpUser) ?></p>
      </div>
    </div>
  </main>
</body>
</html>
