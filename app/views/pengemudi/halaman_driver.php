<?php

$base = '/antarku/public';

$escape = static function ($nilai): string {
    return htmlspecialchars((string) ($nilai ?? ''), ENT_QUOTES, 'UTF-8');
};

$rupiah = static function ($nilai): string {
    return 'Rp' . number_format((float) $nilai, 0, ',', '.');
};

$tanggal = static function ($nilai): string {
    return $nilai ? date('d/m/Y H:i', strtotime($nilai)) : '—';
};

$menu = [
    ['label' => 'Beranda', 'url' => '/pengemudi/dasbor', 'key' => 'dasbor'],
    ['label' => 'Pesanan masuk', 'url' => '/pengemudi/pesanan', 'key' => 'pesanan'],
    ['label' => 'Riwayat', 'url' => '/pengemudi/riwayat', 'key' => 'riwayat'],
    ['label' => 'Pendapatan', 'url' => '/pengemudi/pendapatan', 'key' => 'pendapatan'],
];

$menuAktif = $halaman === 'detail' ? 'pesanan' : $halaman;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $escape($judul) ?> - ANTARKU</title>
    <link rel="stylesheet" href="<?= $base ?>/aset/css/dashboard-driver.css">

    <style>
        .driver-page .driver-logo {
            color: #0a7f5a;
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
        }

        .driver-page .driver-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .driver-page .driver-summary > div {
            background: #e8f4ee;
            color: #103e32;
            padding: 20px;
            border-radius: 14px;
        }

        .driver-page .driver-summary strong {
            display: block;
            font-size: 25px;
            margin: 8px 0;
        }

        .driver-page .driver-orders {
            display: grid;
            gap: 18px;
        }

        .driver-page .driver-order {
            background: #f3f8f5;
            border: 1px solid #e0ebe4;
            border-radius: 14px;
            padding: 20px;
        }

        .driver-page .driver-order h2 {
            margin: 0 0 12px;
            font-size: 20px;
        }

        .driver-page .driver-status {
            display: inline-block;
            background: #e1efe7;
            color: #075b40;
            border-radius: 6px;
            padding: 5px 9px;
            margin-bottom: 12px;
        }

        .driver-page .driver-data {
            display: grid;
            grid-template-columns: minmax(100px, 140px) minmax(0, 1fr);
            gap: 10px 15px;
            margin: 14px 0;
        }

        .driver-page .driver-data dt {
            color: #52675e;
        }

        .driver-page .driver-data dd {
            margin: 0;
            overflow-wrap: anywhere;
        }

        .driver-page .driver-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 18px;
        }

        .driver-page .driver-actions .btn {
            width: auto;
        }

        .driver-page .driver-table-wrap {
            overflow-x: auto;
        }

        .driver-page .driver-table {
            width: 100%;
            border-collapse: collapse;
        }

        .driver-page .driver-table th,
        .driver-page .driver-table td {
            text-align: left;
            padding: 14px 10px;
            border-bottom: 1px solid #e0ebe4;
        }

        .driver-page .driver-table th {
            color: #52675e;
        }

        @media (max-width: 600px) {
            .driver-page .driver-summary {
                grid-template-columns: 1fr;
            }

            .driver-page .driver-data {
                grid-template-columns: 1fr;
                gap: 4px;
            }

            .driver-page .driver-data dd {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
<div class="app driver-page">
    <aside class="sidebar">
        <a class="driver-logo" href="<?= $base ?>/pengemudi/dasbor">
            ANTARKU
        </a>

        <span class="sidebar__label">DRIVER PARTNER</span>

        <ul class="nav">
            <?php foreach ($menu as $item): ?>
                <li>
                    <a
                        class="nav__item <?= $menuAktif === $item['key'] ? 'is-active' : '' ?>"
                        href="<?= $base . $item['url'] ?>"
                        <?= $menuAktif === $item['key'] ? 'aria-current="page"' : '' ?>
                    >
                        <?= $escape($item['label']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="sidebar__verified">
            <strong>Driver Partner</strong>
            <?= $escape($pengemudi['kendaraan']) ?>
        </div>

        <div class="sidebar__profile">
            <strong><?= $escape($pengemudi['nama']) ?></strong>
            <span>★ <?= $escape($pengemudi['rating']) ?></span>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span>Driver / <?= $escape($judul) ?></span>
            <span><?= $escape($pengemudi['nama']) ?></span>
        </header>

        <main class="content">
            <div class="greeting">
                <h1><?= $escape($judul) ?></h1>
                <p>
                    <?php if ($halaman === 'pesanan'): ?>
                        Pesanan menunggu dan perjalanan aktif milikmu.
                    <?php elseif ($halaman === 'riwayat'): ?>
                        Perjalanan selesai dan dibatalkan yang tercatat atas namamu.
                    <?php elseif ($halaman === 'pendapatan'): ?>
                        Total tarif disepakati dari perjalanan yang sudah selesai.
                    <?php else: ?>
                        Informasi penumpang, rute, dan tarif perjalanan.
                    <?php endif; ?>
                </p>
            </div>

            <section class="panel">
                <?php if ($halaman === 'pendapatan'): ?>
                    <div class="driver-summary">
                        <div>
                            <span>Pendapatan hari ini</span>
                            <strong><?= $rupiah($hariIni['total']) ?></strong>
                            <span>
                                <?= (int) $hariIni['perjalanan'] ?> perjalanan selesai
                            </span>
                        </div>

                        <div>
                            <span>Total seluruh pendapatan</span>
                            <strong><?= $rupiah($seluruhnya['total']) ?></strong>
                            <span>
                                <?= (int) $seluruhnya['perjalanan'] ?> perjalanan selesai
                            </span>
                        </div>
                    </div>

                    <?php if (!$daftar): ?>
                        <p>Belum ada perjalanan selesai yang menghasilkan pendapatan.</p>
                    <?php else: ?>
                        <div class="driver-table-wrap">
                            <table class="driver-table">
                                <thead>
                                    <tr>
                                        <th>Pesanan</th>
                                        <th>Tanggal</th>
                                        <th>Penumpang</th>
                                        <th>Pendapatan</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($daftar as $p): ?>
                                        <tr>
                                            <td>#<?= (int) $p['pesanan_id'] ?></td>
                                            <td><?= $tanggal($p['updated_at']) ?></td>
                                            <td><?= $escape($p['penumpang']) ?></td>
                                            <td>
                                                <?= $p['harga_deal'] === null
                                                    ? 'Belum dicatat'
                                                    : $rupiah($p['harga_deal']) ?>
                                            </td>
                                            <td>
                                                <a href="<?= $base ?>/pengemudi/detail-pesanan?id=<?= (int) $p['pesanan_id'] ?>">
                                                    Lihat detail
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                <?php elseif (!$daftar): ?>
                    <div class="empty">
                        <strong>
                            <?= $halaman === 'riwayat'
                                ? 'Belum ada riwayat perjalanan'
                                : 'Belum ada pesanan' ?>
                        </strong>
                        Data baru akan tampil setelah tercatat di database.
                    </div>

                <?php else: ?>
                    <div class="driver-orders">
                        <?php foreach ($daftar as $p): ?>
                            <article class="driver-order">
                                <span class="driver-status">
                                    <?= $escape(ucfirst($p['status_pesanan'])) ?>
                                </span>

                                <h2>
                                    #<?= (int) $p['pesanan_id'] ?>
                                    · <?= $escape($p['penumpang']) ?>
                                </h2>

                                <dl class="driver-data">
                                    <dt>Penjemputan</dt>
                                    <dd><?= $escape($p['asal'] ?? 'Belum diisi') ?></dd>

                                    <dt>Tujuan</dt>
                                    <dd><?= $escape($p['tujuan'] ?? 'Belum diisi') ?></dd>

                                    <dt>Harga tawaran</dt>
                                    <dd><?= $rupiah($p['harga_tawaran']) ?></dd>

                                    <dt>Harga disepakati</dt>
                                    <dd>
                                        <?= $p['harga_deal'] === null
                                            ? 'Belum disepakati'
                                            : $rupiah($p['harga_deal']) ?>
                                    </dd>
                                </dl>

                                <?php if ($halaman === 'detail'): ?>
                                    <dl class="driver-data">
                                        <dt>Jarak rute</dt>
                                        <dd>
                                            <?= $p['jarak_total'] === null
                                                ? 'Belum dicatat'
                                                : $escape($p['jarak_total']) . ' km' ?>
                                        </dd>

                                        <dt>Estimasi</dt>
                                        <dd>
                                            <?= $p['durasi'] === null
                                                ? 'Belum dicatat'
                                                : (int) $p['durasi'] . ' menit' ?>
                                        </dd>

                                        <dt>Dibuat</dt>
                                        <dd><?= $tanggal($p['created_at']) ?></dd>

                                        <dt>Diperbarui</dt>
                                        <dd><?= $tanggal($p['updated_at']) ?></dd>

                                        <dt>Catatan</dt>
                                        <dd><?= $escape($p['catatan'] ?: 'Tidak ada catatan') ?></dd>
                                    </dl>
                                <?php endif; ?>

                                <div class="driver-actions">
                                    <?php if ($halaman !== 'detail'): ?>
                                        <a
                                            class="btn btn--sm"
                                            href="<?= $base ?>/pengemudi/detail-pesanan?id=<?= (int) $p['pesanan_id'] ?>"
                                        >
                                            Lihat detail
                                        </a>
                                    <?php else: ?>
                                        <a class="btn btn--sm" href="<?= $base ?>/pengemudi/pesanan">
                                            Pesanan masuk
                                        </a>
                                        <a class="btn btn--sm" href="<?= $base ?>/pengemudi/riwayat">
                                            Riwayat
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</div>
</body>
</html>