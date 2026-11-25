<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../core/Session.php';
require_once __DIR__ . '/../models/PenggunaModel.php';
require_once __DIR__ . '/../models/PengemudiModel.php';

class AutentikasiController extends Controller
{
    private PenggunaModel $penggunaModel;
    private PengemudiModel $pengemudiModel;

    public function __construct()
    {
        Session::start();
        $this->penggunaModel = new PenggunaModel();
        $this->pengemudiModel = new PengemudiModel();
    }

    /**
     * Tampilkan halaman awal / pemilihan peran (Landing Page Onboarding)
     */
    public function pilihPeran(): void
    {
        if (Session::get('role') === 'penumpang') {
            $this->redirect('/penumpang/beranda');
        } elseif (Session::get('role') === 'driver') {
            $this->redirect('/pengemudi/dasbor');
        }

        $this->view('autentikasi/pilih_peran', [
            'judul' => 'ANTARKU - Perjalanan Lebih Dekat',
        ]);
    }

    /**
     * Tampilkan halaman login penumpang
     */
    public function masukPenumpang(): void
    {
        if (Session::get('role') === 'penumpang') {
            $this->redirect('/penumpang/beranda');
        } elseif (Session::get('role') === 'driver') {
            $this->redirect('/pengemudi/dasbor');
        }

        $error = Session::getFlash('error');
        $success = Session::getFlash('success');
        $oldIdentifier = Session::getFlash('old_identifier', '');

        $this->view('autentikasi/masuk', [
            'peran'         => 'penumpang',
            'judul'         => 'Login Penumpang - ANTARKU',
            'error'         => $error,
            'success'       => $success,
            'oldIdentifier' => $oldIdentifier,
        ]);
    }

    /**
     * Proses autentikasi login penumpang
     */
    public function prosesMasukPenumpang(): void
    {
        $identifier = trim($_POST['identifier'] ?? '');
        $password   = $_POST['password'] ?? '';

        if (empty($identifier) || empty($password)) {
            Session::setFlash('error', 'Silakan masukkan email/nomor telepon dan password.');
            Session::setFlash('old_identifier', $identifier);
            $this->redirect('/login');
        }

        $user = $this->penggunaModel->cariPenumpang($identifier);

        if (!$user) {
            Session::setFlash('error', 'Akun penumpang tidak ditemukan atau kredensial salah.');
            Session::setFlash('old_identifier', $identifier);
            $this->redirect('/login');
        }

        $passwordValid = password_verify($password, $user['password']) || ($password === $user['password']);

        if (!$passwordValid) {
            Session::setFlash('error', 'Email, nomor telepon, atau password salah.');
            Session::setFlash('old_identifier', $identifier);
            $this->redirect('/login');
        }

        // Login sukses
        Session::set('user_id', (int) $user['user_id']);
        Session::set('nama', $user['nama']);
        Session::set('email', $user['email']);
        Session::set('no_hp', $user['no_hp']);
        Session::set('role', 'penumpang');
        Session::set('logged_in', true);

        $this->redirect('/penumpang/beranda');
    }

    /**
     * Tampilkan halaman login driver
     */
    public function masukDriver(): void
    {
        if (Session::get('role') === 'driver') {
            $this->redirect('/pengemudi/dasbor');
        } elseif (Session::get('role') === 'penumpang') {
            $this->redirect('/penumpang/beranda');
        }

        $error = Session::getFlash('error');
        $success = Session::getFlash('success');
        $oldIdDriver = Session::getFlash('old_id_driver', '');

        $this->view('autentikasi/masuk', [
            'peran'       => 'driver',
            'judul'       => 'Login Driver - ANTARKU',
            'error'       => $error,
            'success'     => $success,
            'oldIdDriver' => $oldIdDriver,
        ]);
    }

    /**
     * Proses autentikasi login driver
     */
    public function prosesMasukDriver(): void
    {
        $idDriver = trim($_POST['id_driver'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($idDriver) || empty($password)) {
            Session::setFlash('error', 'Silakan masukkan ID Driver dan password.');
            Session::setFlash('old_id_driver', $idDriver);
            $this->redirect('/login/driver');
        }

        $driver = $this->pengemudiModel->cariUntukLogin($idDriver);

        if (!$driver) {
            Session::setFlash('error', 'ID Driver tidak terdaftar atau kredensial salah.');
            Session::setFlash('old_id_driver', $idDriver);
            $this->redirect('/login/driver');
        }

        $passwordValid = password_verify($password, $driver['password']) || ($password === $driver['password']);

        if (!$passwordValid) {
            Session::setFlash('error', 'ID Driver atau password salah.');
            Session::setFlash('old_id_driver', $idDriver);
            $this->redirect('/login/driver');
        }

        // Login sukses
        Session::set('user_id', (int) $driver['user_id']);
        Session::set('id_pengemudi', (int) $driver['driver_id']);
        Session::set('driver_id', (int) $driver['driver_id']);
        Session::set('nama', $driver['nama']);
        Session::set('role', 'driver');
        Session::set('logged_in', true);

        $this->redirect('/pengemudi/dasbor');
    }

    /**
     * Keluar dari sesi
     */
    public function keluar(): void
    {
        $role = Session::get('role');
        Session::destroy();
        Session::start();
        Session::setFlash('success', 'Anda telah berhasil keluar.');

        if ($role === 'driver') {
            $this->redirect('/login/driver');
        } else {
            $this->redirect('/login');
        }
    }

    /**
     * Tampilkan halaman pendaftaran (Sign In / Sign Up)
     */
    public function daftar(): void
    {
        if (Session::get('role') === 'penumpang') {
            $this->redirect('/penumpang/beranda');
        } elseif (Session::get('role') === 'driver') {
            $this->redirect('/pengemudi/dasbor');
        }

        $error = Session::getFlash('error');
        $success = Session::getFlash('success');
        $oldNama = Session::getFlash('old_nama', '');
        $oldEmail = Session::getFlash('old_email', '');
        $oldNoHp = Session::getFlash('old_no_hp', '');

        $this->view('autentikasi/daftar', [
            'judul'    => 'Daftar Akun - ANTARKU',
            'error'    => $error,
            'success'  => $success,
            'oldNama'  => $oldNama,
            'oldEmail' => $oldEmail,
            'oldNoHp'  => $oldNoHp,
        ]);
    }

    /**
     * Proses pendaftaran akun penumpang baru
     */
    public function prosesDaftar(): void
    {
        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $noHp     = trim($_POST['no_hp'] ?? '');
        $password = $_POST['password'] ?? '';

        Session::setFlash('old_nama', $nama);
        Session::setFlash('old_email', $email);
        Session::setFlash('old_no_hp', $noHp);

        if (empty($nama) || empty($email) || empty($noHp) || empty($password)) {
            Session::setFlash('error', 'Semua kolom wajib diisi.');
            $this->redirect('/daftar');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::setFlash('error', 'Format alamat email tidak valid.');
            $this->redirect('/daftar');
        }

        // Cek email duplikat
        if ($this->penggunaModel->cariByEmail($email)) {
            Session::setFlash('error', 'Email sudah terdaftar. Silakan gunakan email lain atau masuk.');
            $this->redirect('/daftar');
        }

        // Cek nomor hp duplikat
        if ($this->penggunaModel->cariByEmailAtauHp($noHp)) {
            Session::setFlash('error', 'Nomor telepon sudah terdaftar. Silakan gunakan nomor lain.');
            $this->redirect('/daftar');
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $dataBaru = [
            'nama'     => $nama,
            'email'    => $email,
            'no_hp'    => $noHp,
            'password' => $passwordHash,
            'role'     => 'penumpang',
        ];

        try {
            $userId = $this->penggunaModel->tambah($dataBaru);

            if ($userId) {
                Session::setFlash('success', 'Pendaftaran berhasil! Akun kamu sudah aktif, silakan masuk.');
                Session::setFlash('old_identifier', $email);
                $this->redirect('/login');
            } else {
                Session::setFlash('error', 'Gagal mendaftar akun. Silakan coba beberapa saat lagi.');
                $this->redirect('/daftar');
            }
        } catch (\PDOException $e) {
            Session::setFlash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
            $this->redirect('/daftar');
        }
    }
}
