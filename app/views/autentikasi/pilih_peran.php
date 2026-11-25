<?php
/**
 * View Halaman Awal / Pemilihan Peran (Landing Onboarding)
 * Sesuai mockup: Kamu ingin berangkat sebagai siapa?
 */
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pilih Peran - ANTARKU</title>
  <link rel="stylesheet" href="<?= $base ?>/aset/css/login.css">
</head>
<body>
  <main class="login-page">
    
    <!-- ==================== BANNER KIRI ==================== -->
    <section class="login-banner">
      <div class="banner-top">
        
        <!-- Logo Antarku (Ukuran Lebih Besar & Jelas) -->
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

        <!-- Judul Besar Halaman Awal -->
        <h1 class="banner-heading">
          Tujuanmu.<br>
          Pilihanmu.<br>
          Harga sepakatmu.
        </h1>

        <!-- Deskripsi Halaman Awal -->
        <p class="banner-desc">
          Perjalanan nyaman dimulai dari kesepakatan.<br>
          Tentukan tarifmu dan temukan driver terbaik.
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

              <!-- Titik Jemput -->
              <circle cx="78" cy="178" r="9" fill="#007a53"/>
              <circle cx="78" cy="178" r="5" fill="#ffffff"/>
              <circle cx="78" cy="178" r="2.5" fill="#007a53"/>

              <!-- Mobil Ikon -->
              <g transform="translate(186, 126)">
                <circle cx="9" cy="9" r="12" fill="#ffffff" filter="drop-shadow(0 2px 4px rgba(0,0,0,0.15))"/>
                <svg x="1" y="1" width="16" height="16" viewBox="0 0 24 24" fill="#007a53">
                  <path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.22.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/>
                </svg>
              </g>

              <!-- Titik Tujuan -->
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

    <!-- ==================== PILIHAN PERAN KANAN ==================== -->
    <section class="login-content">
      <div class="login-form-box">
        
        <header class="form-header">
          <h2 class="form-title">Kamu ingin berangkat sebagai siapa?</h2>
          <p class="form-subtitle">Pilih peranmu. Bisa diubah kapan saja.</p>
        </header>

        <!-- Kotak Pilihan Peran -->
        <div class="role-selector">
          
          <!-- Opsi Penumpang -->
          <div class="role-card is-selected" id="card-penumpang" onclick="pilihRole('penumpang', '<?= $base ?>/login')">
            <div class="role-card-header">
              <div class="role-card-title-group">
                <svg class="role-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                  <circle cx="7" cy="17" r="2"/>
                  <path d="M9 17h6"/>
                  <circle cx="17" cy="17" r="2"/>
                </svg>
                <span class="role-title">Penumpang</span>
              </div>
              <svg class="role-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </div>
            <p class="role-desc">Pesan mobil dan tentukan tarifmu.</p>
          </div>

          <!-- Opsi Driver -->
          <div class="role-card" id="card-driver" onclick="pilihRole('driver', '<?= $base ?>/login/driver')">
            <div class="role-card-header">
              <div class="role-card-title-group">
                <svg class="role-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/>
                  <circle cx="7" cy="17" r="2"/>
                  <path d="M9 17h6"/>
                  <circle cx="17" cy="17" r="2"/>
                </svg>
                <span class="role-title">Driver</span>
              </div>
              <svg class="role-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </div>
            <p class="role-desc">Terima pesanan, raih penghasilan.</p>
          </div>

        </div>

        <!-- Tombol Lanjut -->
        <button id="btn-lanjut" class="btn-submit" onclick="lanjutPeran()">
          Lanjut sebagai Penumpang
        </button>

        <p class="partner-footer-text">
          Partner perjalanan, setiap hari.
        </p>

      </div>
    </section>

  </main>

  <footer class="mobile-page-footer">
    © 2026 ANTARKU · Aman di setiap perjalanan
  </footer>

  <script>
    let roleTerpilih = 'penumpang';
    let targetUrl = '<?= $base ?>/login';

    function pilihRole(role, url) {
      roleTerpilih = role;
      targetUrl = url;

      const cardPenumpang = document.getElementById('card-penumpang');
      const cardDriver = document.getElementById('card-driver');
      const btnLanjut = document.getElementById('btn-lanjut');

      if (role === 'penumpang') {
        cardPenumpang.classList.add('is-selected');
        cardDriver.classList.remove('is-selected');
        btnLanjut.textContent = 'Lanjut sebagai Penumpang';
      } else {
        cardDriver.classList.add('is-selected');
        cardPenumpang.classList.remove('is-selected');
        btnLanjut.textContent = 'Lanjut sebagai Driver';
      }
    }

    function lanjutPeran() {
      window.location.href = targetUrl;
    }
  </script>
</body>
</html>
