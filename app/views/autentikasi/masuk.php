<?php
/**
 * View Halaman Login Antarku (Penumpang & Driver)
 * Variabel yang tersedia:
 * - $peran: 'penumpang' | 'driver'
 * - $judul: string
 * - $error: string|null
 * - $success: string|null
 * - $oldIdentifier: string
 * - $oldIdDriver: string
 */
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$isDriver = ($peran ?? 'penumpang') === 'driver';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($judul ?? 'Masuk - ANTARKU') ?></title>
  <link rel="stylesheet" href="<?= $base ?>/aset/css/login.css">
</head>
<body>
  <main class="login-page">
    
    <!-- ==================== BANNER KIRI ==================== -->
    <section class="login-banner">
      <div class="banner-top">
        
        <!-- Logo Antarku -->
        <a href="<?= $base ?>/" class="brand-logo" title="ANTARKU">
          <img src="<?= $base ?>/aset/gambar/logo.png" alt="ANTARKU" class="brand-logo-img">
        </a>

        <!-- Badge Baris Sub-judul -->
        <div class="banner-badge-row">
          <span class="banner-badge">PERJALANAN LEBIH DEKAT</span>
          <svg class="banner-target-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="9"/>
            <path d="M12 3v18M3 12h18"/>
          </svg>
        </div>

        <!-- Judul Besar -->
        <h1 class="banner-heading">
          Perjalanan nyaman,<br>
          dengan harga yang<br>
          kamu tentukan.
        </h1>

        <!-- Deskripsi -->
        <p class="banner-desc">
          Temukan driver terdekat, ajukan tarif terbaik, dan berangkat tanpa ragu bersama ANTARKU
        </p>

        <!-- Kartu Rute & Peta -->
        <div class="route-card">
          <div class="map-container">
            
            <!-- Chip Durasi & Jarak -->
            <div class="map-chip">
              <span class="chip-dot"></span>
              <span>25 mnt • 8,4 km</span>
            </div>

            <!-- SVG Ilustrasi Peta Interaktif / Rute -->
            <svg class="map-graphic" viewBox="0 0 440 220" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Jalan-jalan peta background -->
              <path d="M-20 60 L460 160" stroke="#d5e8dc" stroke-width="16" stroke-linecap="round"/>
              <path d="M-20 60 L460 160" stroke="#f4fbf6" stroke-width="12" stroke-linecap="round"/>

              <path d="M120 -20 L300 240" stroke="#d5e8dc" stroke-width="20" stroke-linecap="round"/>
              <path d="M120 -20 L300 240" stroke="#f4fbf6" stroke-width="16" stroke-linecap="round"/>

              <path d="M-30 180 L470 40" stroke="#d5e8dc" stroke-width="14" stroke-linecap="round"/>
              <path d="M-30 180 L470 40" stroke="#f4fbf6" stroke-width="10" stroke-linecap="round"/>

              <path d="M340 -20 L220 240" stroke="#d5e8dc" stroke-width="12" stroke-linecap="round"/>
              <path d="M340 -20 L220 240" stroke="#f4fbf6" stroke-width="8" stroke-linecap="round"/>

              <!-- Teks Nama Tempat -->
              <text x="35" y="110" font-family="'Plus Jakarta Sans', sans-serif" font-size="8.5" font-weight="700" fill="#719483" letter-spacing="0.5">KEBAYORAN BARU</text>
              <text x="280" y="80" font-family="'Plus Jakarta Sans', sans-serif" font-size="8.5" font-weight="700" fill="#719483" letter-spacing="0.5">MENTENG</text>
              <text x="140" y="195" font-family="'Plus Jakarta Sans', sans-serif" font-size="8.5" font-weight="700" fill="#719483" letter-spacing="0.5">SENAYAN</text>
              <text x="175" y="130" font-family="'Plus Jakarta Sans', sans-serif" font-size="7.5" font-weight="600" fill="#527d68" transform="rotate(-30 175 130)">Jl. Jenderal Sudirman</text>

              <!-- Garis Rute Hijau Tebal -->
              <path d="M78 178 C110 160, 160 150, 205 125 C250 100, 280 90, 298 84" 
                    stroke="#007a53" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>

              <!-- Titik Jemput (Origin) -->
              <circle cx="78" cy="178" r="9" fill="#007a53"/>
              <circle cx="78" cy="178" r="5" fill="#ffffff"/>
              <circle cx="78" cy="178" r="2.5" fill="#007a53"/>

              <!-- Mobil Ikon di Tengah Rute -->
              <g transform="translate(186, 126)">
                <circle cx="9" cy="9" r="12" fill="#ffffff" filter="drop-shadow(0 2px 4px rgba(0,0,0,0.15))"/>
                <svg x="1" y="1" width="16" height="16" viewBox="0 0 24 24" fill="#007a53">
                  <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                </svg>
              </g>

              <!-- Titik Tujuan (Destination) -->
              <circle cx="298" cy="84" r="8" fill="#111827"/>
              <circle cx="298" cy="84" r="4" fill="#ffffff"/>
            </svg>

            <!-- Tombol Zoom -->
            <div class="map-zoom">
              <span class="zoom-btn" title="Perbesar">+</span>
              <span class="zoom-btn" title="Perkecil">−</span>
            </div>

          </div>

          <!-- Bagian Bawah Kartu Rute -->
          <div class="route-footer-card">
            <h3 class="route-footer-title">Harga disepakati bersama</h3>
            <p class="route-footer-sub">Transparan sebelum kamu berangkat.</p>
          </div>
        </div>

      </div>

      <!-- Footer Kiri -->
      <footer class="banner-footer">
        <span class="footer-copy">© 2026 ANTARKU · Aman di setiap perjalanan</span>
      </footer>
    </section>

    <!-- ==================== FORM KANAN ==================== -->
    <section class="login-content">
      <div class="login-form-box">
        
        <header class="form-header">
          <h2 class="form-title">Selamat datang kembali</h2>
          <p class="form-subtitle">Masuk untuk melanjutkan perjalananmu.</p>
        </header>

        <!-- Pesan Error / Sukses -->
        <?php if (!empty($error)): ?>
          <div class="alert alert-error">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span><?= htmlspecialchars($error) ?></span>
          </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
          <div class="alert alert-success">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span><?= htmlspecialchars($success) ?></span>
          </div>
        <?php endif; ?>

        <!-- Formulir Login -->
        <?php if ($isDriver): ?>
          <!-- FORM DRIVER -->
          <form action="<?= $base ?>/login/driver" method="POST">
            <div class="form-group">
              <label for="id_driver" class="form-label">ID Driver</label>
              <input 
                type="text" 
                id="id_driver" 
                name="id_driver" 
                class="form-input" 
                placeholder="Contoh: DR-SBY-kodeunik" 
                value="<?= htmlspecialchars($oldIdDriver ?? '') ?>" 
                required 
                autofocus
              >
            </div>

            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <div class="password-wrapper">
                <input 
                  type="password" 
                  id="password" 
                  name="password" 
                  class="form-input" 
                  placeholder="••••••••" 
                  required
                >
                <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Lihat password">
                  <svg id="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>
            </div>

            <div class="form-extra-row">
              <a href="javascript:alert('Silakan hubungi admin Antarku untuk reset kata sandi.');" class="forgot-link">Lupa password?</a>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>

            <div class="register-row">
              Belum punya akun? <a href="javascript:alert('Silakan hubungi kantor perwakilan Antarku untuk pendaftaran kemitraan Driver.');" class="register-link">Hubungi admin</a>
            </div>

            <p class="terms-text">
              Dengan masuk, kamu menyetujui Syarat Layanan dan Kebijakan Privasi ANTARKU.
            </p>

            <div class="switch-role-row">
              <a href="<?= $base ?>/login" class="switch-role-link">Masuk sebagai Penumpang</a>
            </div>
          </form>

        <?php else: ?>
          <!-- FORM PENUMPANG -->
          <form action="<?= $base ?>/login" method="POST">
            <div class="form-group">
              <label for="identifier" class="form-label">Email atau nomor telepon</label>
              <input 
                type="text" 
                id="identifier" 
                name="identifier" 
                class="form-input" 
                placeholder="nama@email.com" 
                value="<?= htmlspecialchars($oldIdentifier ?? '') ?>" 
                required 
                autofocus
              >
            </div>

            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <div class="password-wrapper">
                <input 
                  type="password" 
                  id="password" 
                  name="password" 
                  class="form-input" 
                  placeholder="••••••••" 
                  required
                >
                <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Lihat password">
                  <svg id="eye-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>
            </div>

            <div class="form-extra-row">
              <a href="javascript:alert('Fitur reset kata sandi akan segera hadir.');" class="forgot-link">Lupa password?</a>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>

            <div class="register-row">
              Belum punya akun? <a href="<?= $base ?>/daftar" class="register-link">Daftar sekarang</a>
            </div>

            <p class="terms-text">
              Dengan masuk, kamu menyetujui Syarat Layanan dan Kebijakan Privasi ANTARKU.
            </p>

            <div class="switch-role-row">
              <a href="<?= $base ?>/login/driver" class="switch-role-link">Masuk sebagai Driver</a>
            </div>
          </form>
        <?php endif; ?>

      </div>
    </section>

  </main>

  <footer class="mobile-page-footer">
    © 2026 ANTARKU · Aman di setiap perjalanan
  </footer>

  <script>
    function togglePassword() {
      const pwd = document.getElementById('password');
      const icon = document.getElementById('eye-icon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
      } else {
        pwd.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
      }
    }
  </script>
</body>
</html>
