<?php
$base       = '/antarku/public';
$pengemudi  = $pengemudi  ?? ['nama' => 'Budi Santoso', 'kendaraan' => 'Toyota Avanza · B 1234 SJK', 'rating' => '4,9'];
$pesanan    = $pesanan    ?? [];
$online     = $online     ?? false;
$pendapatan = $pendapatan ?? 0;
$perjalanan = $perjalanan ?? 0;

$namaDepan = explode(' ', trim($pengemudi['nama']))[0];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dasbor Pengemudi - Antarku</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <link rel="stylesheet" href="<?= $base ?>/aset/css/dashboard-driver.css">
</head>
<body>
<div class="app" id="app" data-online="<?= $online ? '1' : '0' ?>">

  <aside class="sidebar">
    <a class="sidebar__logo" href="#"><img src="<?= $base ?>/aset/gambar/logo.png" alt="Antarku"></a>
    <span class="sidebar__label">DRIVER PARTNER</span>

    <ul class="nav">
      <li><a class="nav__item is-active" href="#">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        <span>Beranda</span></a></li>
      <li><a class="nav__item" href="#">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m21 8-2 2-1.5-3.7A2 2 0 0 0 15.646 5H8.4a2 2 0 0 0-1.903 1.257L5 10 3 8"/><path d="M7 14h.01"/><path d="M17 14h.01"/><rect width="18" height="8" x="3" y="10" rx="2"/><path d="M5 18v2"/><path d="M19 18v2"/></svg>
        <span>Pesanan masuk</span></a></li>
      <li><a class="nav__item" href="#">
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        <span>Riwayat</span></a></li>
      <li><a class="nav__item" href="#">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
        <span>Pendapatan</span></a></li>
    </ul>

    <div class="sidebar__verified">
      <svg class="icon-shield" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
      <strong>Partner terverifikasi</strong>
      <?= htmlspecialchars($pengemudi['kendaraan']) ?>
    </div>

    <div class="sidebar__profile">
      <strong><?= htmlspecialchars($pengemudi['nama']) ?></strong>
      <span>★ <?= htmlspecialchars($pengemudi['rating']) ?> · Driver Partner</span>
    </div>
  </aside>

  <div class="main">
    <header class="topbar">
      <span>Driver / Dashboard
        <span data-show="online">online</span><span data-show="offline">offline</span>
      </span>
      <span class="badge-status">
        <span data-show="online">Online</span><span data-show="offline">Offline</span>
      </span>
    </header>

    <main class="content">
      <div class="greeting">
        <h1>Siap jalan, <?= htmlspecialchars($namaDepan) ?>?</h1>
        <p>Setiap perjalanan, peluang baru untuk penghasilanmu.</p>
      </div>

      <div class="grid">
        <section class="panel">

          <div class="status-card">
            <div>
              <strong>
                <span data-show="online">Kamu sedang online</span>
                <span data-show="offline">Kamu sedang offline</span>
              </strong>
              <small>
                <span data-show="online">Siap menerima pesanan</span>
                <span data-show="offline">Aktifkan untuk mulai menerima pesanan</span>
              </small>
            </div>
            <label class="switch">
              <input type="checkbox" id="toggle-online" <?= $online ? 'checked' : '' ?> aria-label="Status online">
              <span class="switch__track"></span>
            </label>
          </div>

          <div class="earnings">
            <div>
              <span class="earnings__label">PENDAPATAN HARI INI</span>
              <span class="earnings__value">Rp<?= number_format($pendapatan, 0, ',', '.') ?></span>
            </div>
            <span class="earnings__trips"><?= (int) $perjalanan ?> perjalanan</span>
          </div>

          <!-- tampilan online -->
          <div data-show="online">
            <h2 class="section-title">Pesanan di sekitarmu</h2>

            <div class="order-list">
              <?php if (empty($pesanan)): ?>
                <div class="empty">
                  <strong>Belum ada pesanan</strong>
                  Pesanan baru di area sekitarmu akan muncul di sini.
                </div>
              <?php else: foreach ($pesanan as $i => $p): ?>
                <article class="order">
                  <span class="order__chip"><span class="js-jarak" data-idx="<?= $i ?>"><?= htmlspecialchars($p['jarak']) ?></span> km dari kamu</span>
                  <div class="order__row">
                    <span class="order__name"><?= htmlspecialchars($p['penumpang']) ?></span>
                    <span class="order__price">Rp<?= number_format($p['tarif'], 0, ',', '.') ?></span>
                  </div>
                  <p class="order__route"><?= htmlspecialchars($p['asal']) ?> → <?= htmlspecialchars($p['tujuan']) ?></p>
                  <p class="order__meta"><?= htmlspecialchars($p['jarak_total']) ?> km · ±<?= (int) $p['durasi'] ?> menit · <?= htmlspecialchars($p['pembayaran']) ?></p>
                  <a class="btn btn--sm" href="#">Lihat detail</a>
                </article>
              <?php endforeach; endif; ?>
            </div>

            <p class="note">Tentukan pesanan yang cocok untukmu.<br>Kamu bebas menyepakati harga.</p>
          </div>

          <!-- tampilan offline -->
          <div data-show="offline">
            <h2 class="section-title">Ambil jeda, lanjut kapan saja.</h2>
            <p class="note">Aktifkan status online untuk menemukan pesanan di area sekitarmu.</p>
          </div>

          <!-- tombol bawah -->
          <a class="btn btn--spaced" href="#" data-show="online">Lihat pesanan masuk</a>
          <button class="btn btn--spaced" type="button" id="btn-mulai" data-show="offline">Mulai online</button>
        </section>

        <section class="map">
          <div class="map__pill map__pill--area" id="pill-area">Area aktif · Mencari lokasi…</div>
          <div class="map__canvas" id="peta"></div>
        </section>
      </div>
    </main>
  </div>

</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  var ONLINE  = <?= $online ? 'true' : 'false' ?>;
  var PESANAN = <?= json_encode($pesanan, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

  (function () {
    var DEFAULT_POS = [-6.2441, 106.8001];

    var peta = L.map('peta', { zoomControl: false }).setView(DEFAULT_POS, 14);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(peta);

    L.control.zoom({ position: 'bottomright' }).addTo(peta);

    // titik posisi kita
    var marker = L.circleMarker(DEFAULT_POS, {
      radius: 9, color: '#fff', weight: 3,
      fillColor: '#0a7f5a', fillOpacity: 1
    }).addTo(peta).bindTooltip('Lokasimu', {
      permanent: true, direction: 'top', offset: [0, -10], className: 'eta-tip'
    });

    function titikLabel(ll, teks) {
      return L.marker(ll, {
        icon: L.divIcon({
          className: 'pin',
          html: '<span class="pin__dot"></span><span class="pin__label">' + teks + '</span>',
          iconSize: [0, 0]
        })
      }).addTo(peta);
    }

    function hav(a, b) { 
      var rad = Math.PI / 180, R = 6371000;
      var dLat = (b[0] - a[0]) * rad, dLng = (b[1] - a[1]) * rad;
      var x = Math.pow(Math.sin(dLat / 2), 2) +
              Math.cos(a[0] * rad) * Math.cos(b[0] * rad) * Math.pow(Math.sin(dLng / 2), 2);
      return 2 * R * Math.asin(Math.sqrt(x));
    }
    function fmtKm(m) { return (m / 1000).toFixed(1).replace('.', ','); }

    function setChip(idx, meter) {
      var el = document.querySelector('.js-jarak[data-idx="' + idx + '"]');
      if (el) el.textContent = fmtKm(meter);
    }

    /* rute jemput ke tujuan - */
    var order = PESANAN[0];
    var adaRute = ONLINE && order &&
                  order.asal_lat != null && order.asal_lng != null &&
                  order.tujuan_lat != null && order.tujuan_lng != null;

    var jemput, tujuan;
    var sudahFokus = false;

    if (adaRute) {
      sudahFokus = true;

      jemput = [order.asal_lat,   order.asal_lng];
      tujuan = [order.tujuan_lat, order.tujuan_lng];

      titikLabel(jemput, 'Jemput');
      titikLabel(tujuan, 'Tujuan');
      peta.fitBounds(L.latLngBounds([jemput, tujuan]), { padding: [80, 80] });

      var urlRute = 'https://router.project-osrm.org/route/v1/driving/' +
                    jemput[1] + ',' + jemput[0] + ';' + tujuan[1] + ',' + tujuan[0] +
                    '?overview=full&geometries=geojson';

      fetch(urlRute)
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (!res.routes || !res.routes.length) throw new Error();
          var garis = res.routes[0].geometry.coordinates.map(function (c) { return [c[1], c[0]]; });
          var layerRute = L.polyline(garis, { color: '#0a7f5a', weight: 5, opacity: .95 }).addTo(peta);
          peta.fitBounds(layerRute.getBounds(), { padding: [80, 80] });
        })
        .catch(function () {
          L.polyline([jemput, tujuan], { color: '#0a7f5a', weight: 4, dashArray: '8 8' }).addTo(peta);
        });
    }

    /* area aktif  */
    var areaEl = document.getElementById('pill-area');
    var lastGeo = null, lastGeoTime = 0;

    function perbaruiArea(ll) {
      var now = Date.now();
      if (lastGeo && (hav(lastGeo, ll) < 500 || now - lastGeoTime < 5000)) return;
      lastGeo = ll; lastGeoTime = now;

      fetch('https://nominatim.openstreetmap.org/reverse?format=jsonv2&zoom=14&accept-language=id' +
            '&lat=' + ll[0] + '&lon=' + ll[1])
        .then(function (r) { return r.json(); })
        .then(function (res) {
          var a = res.address || {};
          var nama = a.city_district || a.suburb || a.town || a.city || a.county || a.state;
          if (nama) areaEl.textContent = 'Area aktif · ' + nama;
        })
        .catch(function () {});
    }

    /*  jarak & ETA posisi kita dan titik jemput */
    var lastRoute = null, lastRouteTime = 0;

    function hitungKeJemput(ll) {
      if (!adaRute) return;
      var now = Date.now();
      if (lastRoute && (hav(lastRoute, ll) < 30 || now - lastRouteTime < 8000)) return;
      lastRoute = ll; lastRouteTime = now;

      var url = 'https://router.project-osrm.org/route/v1/driving/' +
                ll[1] + ',' + ll[0] + ';' + jemput[1] + ',' + jemput[0] + '?overview=false';

      fetch(url)
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (!res.routes || !res.routes.length) throw new Error();
          var r0 = res.routes[0];
          marker.setTooltipContent(Math.max(1, Math.round(r0.duration / 60)) + ' mnt · ' + fmtKm(r0.distance) + ' km');
          setChip(0, r0.distance);
        })
        .catch(function () {
          var m = hav(ll, jemput);
          marker.setTooltipContent('≈ ' + fmtKm(m) + ' km');
          setChip(0, m);
        });
    }
    function hitungChip(ll) {
      for (var i = adaRute ? 1 : 0; i < PESANAN.length; i++) {
        var p = PESANAN[i];
        if (p.asal_lat != null && p.asal_lng != null) setChip(i, hav(ll, [p.asal_lat, p.asal_lng]));
      }
    }

    /* gps */
    if (navigator.geolocation) {
      navigator.geolocation.watchPosition(function (pos) {
        var ll = [pos.coords.latitude, pos.coords.longitude];
        marker.setLatLng(ll);
        if (!sudahFokus) { sudahFokus = true; peta.setView(ll, 15); }

        perbaruiArea(ll);
        if (ONLINE) { hitungKeJemput(ll); hitungChip(ll); }
      }, function () {
        areaEl.textContent = 'Area aktif · Lokasi tidak tersedia';
      }, { enableHighAccuracy: true, maximumAge: 5000, timeout: 15000 });
    } else {
      areaEl.textContent = 'Area aktif · Lokasi tidak tersedia';
    }

    setTimeout(function () { peta.invalidateSize(); }, 200);
    window.addEventListener('resize', function () { peta.invalidateSize(); });
  })();

  (function () {
    var app    = document.getElementById('app');
    var toggle = document.getElementById('toggle-online');
    var mulai  = document.getElementById('btn-mulai');

    function setOnline(on) {
      var sebelumnya = app.dataset.online === '1';

      app.dataset.online = on ? '1' : '0';
      toggle.checked = on;

      fetch('<?= $base ?>/pengemudi/status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ online: on })
      })
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (!res.ok) throw new Error();
        window.location.reload();
      })
      .catch(function () {
        app.dataset.online = sebelumnya ? '1' : '0';
        toggle.checked = sebelumnya;
        alert('Gagal mengubah status. Coba lagi.');
      });
    }

    toggle.addEventListener('change', function () { setOnline(toggle.checked); });
    mulai.addEventListener('click',  function () { setOnline(true); });
  })();
</script>
</body>
</html>