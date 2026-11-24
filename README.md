# Antarku: Perjalanan Lebih Dekat

Aplikasi ride-hailing roda empat berbasis web dengan sistem tawar-menawar harga (bidding). Proyek Evaluasi Akhir Semester mata kuliah Manajemen Proyek, Kelompok 3, Jurusan Informatika, UPN "Veteran" Jawa Timur.

## Teknologi

- PHP Native (tanpa framework), pola MVC
- MySQL (phpMyAdmin)
- Leaflet.js + OpenStreetMap
- HTML5, CSS3, JavaScript, AJAX
- XAMPP, Git, GitHub

## Cara Menjalankan

1. Clone repositori ke `htdocs`:
   ```
   git clone https://github.com/Iqlimazkiya/antarku.git
   ```
2. Jalankan Apache dan MySQL di XAMPP.
3. Buat database `antarku` di phpMyAdmin, lalu impor `database/antarku.sql`.
4. Salin `config/database.example.php` menjadi `config/database.php`, lalu sesuaikan isinya.
5. Buka `http://localhost/antarku/public/` di peramban.

## Struktur Folder

| Folder             | Fungsi                                         |
| ------------------ | ---------------------------------------------- |
| `app/controllers/` | Logika alur fitur (`api/` untuk endpoint JSON) |
| `app/models/`      | Akses data MySQL                               |
| `app/views/`       | Tampilan halaman                               |
| `app/middleware/`  | Cek login dan peran                            |
| `app/helpers/`     | Fungsi bantu (format rupiah, jarak haversine)  |
| `core/`            | Router, Controller, Model, Database, Session   |
| `routes/`          | Daftar rute URL                                |
| `config/`          | Pengaturan aplikasi, database, dan peta        |
| `public/`          | Front controller dan aset statis               |
| `database/`        | Skema SQL dan ERD                              |
| `storage/`         | Log dan berkas unggahan                        |
| `docs/`            | Charter, mockup, wawancara, panduan            |
| `tests/`           | Kasus uji black-box dan laporan bug            |

## Alur Kerja Git

- `main`: versi utama yang stabil.
- Setiap anggota bekerja di branch atas namanya sendiri.
- Sebelum mulai kerja: `git pull origin main` ke branch sendiri.
- Setelah selesai: push ke branch sendiri, lalu buat Pull Request ke `main`.
- Pesan commit singkat dan jelas, misalnya `Tambah halaman login`.

## Anggota

| Nama                        | Peran                  | Branch       |
| --------------------------- | ---------------------- | ------------ |
| Annette Subiono             | Project Manager        | `annette`    |
| Iqlima Noura Azkiya         | System Analyst         | `iqlima`     |
| Vania Ulayya Rihadatul A    | UI/UX Designer         | `vania`      |
| (Database Administrator)    | Database Administrator | -            |
| Ellysabeth Joanita Putri K  | Backend Developer 1    | `ellysabeth` |
| Angeline Riendra Tatipang   | Backend Developer 2    | `angeline`   |
| Eva Salsabilla              | Frontend Developer 1   | `eva`        |
| Paulenta Silvania Silitonga | Frontend Developer 2   | `paulenta`   |
| Abel Dwi Rahmawati. S       | Quality Assurance      | `abel`       |
| Regina Caeli Endyarni       | Technical Writer       | `regina`     |
