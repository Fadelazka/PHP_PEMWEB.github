Berikut adalah penjelasan rinci dari setiap file dan folder yang telah kita buat untuk sistem Login, Register, Lupa Sandi, serta website pemesanan tiket DDELTIKET. 
Penjelasan mencakup fungsi, alur kerja, dan hubungan antar kode.

ddeltiket/
│
├── index.php                    # Halaman utama (single page application)
├── lupa_password.php            # Form input email untuk reset password
├── reset_password.php           # Form ganti password dengan token
│
├── server/
│   └── koneksi.php              # Koneksi ke database
│
├── proses/
│   ├── prosesLogin.php          # Proses login (AJAX + session)
│   ├── prosesRegister.php       # Proses registrasi (AJAX)
│   ├── prosesLupaPassword.php   # Generate token reset password
│   ├── prosesResetPassword.php  # Update password baru
│   └── logout.php               # Hapus session & cookie
│
└── assets/ (opsional)           # Tempat CSS/JS eksternal (tidak wajib)

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
);

- Fungsi kolom:
id : nomor unik, auto increment.
username : nama lengkap pengguna (harus unik).
email : alamat email (harus unik, digunakan untuk login dan reset password).
password : hash password (hasil password_hash()).

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `token` (`token`)
);

- Fungsi kolom:
email : alamat email yang minta reset.
token : token random unik (satu kali pakai).
expires_at : batas waktu token berlaku (biasanya 1 jam).

🔧 Penjelasan Kode per File
1. server/koneksi.php
Koneksi ke database. Hanya ini yang perlu diubah jika berpindah database.

php
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_ddeltiket";
$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) die("Koneksi gagal: " . mysqli_connect_error());
?>
2. proses/prosesRegister.php
Menerima data dari form registrasi (via AJAX).

Validasi apakah username/email sudah ada.

Hash password dengan password_hash().

Simpan ke tabel users.

Kembalikan response JSON.

3. proses/prosesLogin.php
Menerima data login (bisa berupa email atau username).

Query mencari user dengan username = '$login' OR email = '$login'.

Verifikasi password dengan password_verify().

Jika berhasil, buat session $_SESSION['username'].

Jika centang "Ingat Saya", buat cookie username.

Response JSON.

4. proses/logout.php
Hapus session dan cookie, lalu redirect ke index.php.

5. lupa_password.php (halaman form)
Form input email.

Menampilkan pesan sukses/error dari session.

Kirim POST ke proses/prosesLupaPassword.php.

6. proses/prosesLupaPassword.php
Cek apakah email terdaftar.

Hapus token lama untuk email itu.

Buat token random (bin2hex(random_bytes(32))).

Simpan token dan waktu kadaluarsa (1 jam) ke tabel password_resets.

Buat link reset: http://.../reset_password.php?token=....

Simulasi: langsung tampilkan link di halaman (atau kirim email jika sudah pakai SMTP).

7. reset_password.php
Menerima parameter token dari URL.

Cek token di database, pastikan belum kadaluarsa.

Tampilkan form untuk password baru.

Setelah submit, hash password baru, update di tabel users.

Hapus token yang sudah digunakan.

Redirect ke halaman login.

8. index.php (halaman utama)
Ini adalah file terbesar. Isinya:

Session check di awal PHP: session_start() dan $isLoggedIn.

HTML dengan Tailwind CSS.

JavaScript untuk:

Menampilkan data destinasi & paket (hardcoded).

Fungsi navigateTo() untuk berpindah halaman (home, auth, destinasi, paket).

Fungsi handleAuth() untuk login/register via AJAX.

Fungsi openDestinasiPage() dan openPaketPage() yang memeriksa isLoggedIn sebelum menampilkan pemesanan.

Fitur dark mode, typing effect, dll.

Modal / popup login/register sebenarnya adalah halaman tersendiri (page-auth) di dalam satu file.

Tips: Kode index.php cukup panjang, tapi prinsipnya adalah single page application sederhana dengan menyembunyikan/menampilkan div.

📝 Panduan Membuat dari Nol (Langkah demi Langkah)
Langkah 1: Siapkan Lingkungan
Install XAMPP / MAMP.

Nyalakan Apache & MySQL.

Buat folder baru di htdocs, misal ddeltiket.

Langkah 2: Buat Database dan Tabel
Buka phpMyAdmin, buat database db_ddeltiket.

Jalankan SQL untuk users dan password_resets (lihat di atas).

Langkah 3: Buat File server/koneksi.php
Salin kode koneksi, sesuaikan nama database.

Langkah 4: Buat File Proses (Login, Register, Logout)
Salin kode dari prosesLogin.php, prosesRegister.php, logout.php yang sudah disediakan.
Pastikan path include koneksi.php benar.

Langkah 5: Buat Halaman index.php
Ini yang paling kompleks. Anda bisa:

Ambil kode index.php dari jawaban sebelumnya (yang sudah lengkap dengan session dan JavaScript).

Atau buat bertahap: buat dulu HTML statis, lalu tambahkan PHP session, lalu AJAX.

Langkah 6: Buat Fitur Lupa Sandi
Buat lupa_password.php (form email).

Buat proses/prosesLupaPassword.php (buat token, simpan ke DB, tampilkan link).

Buat reset_password.php (form ganti password + proses update).

Jangan lupa buat tabel password_resets.

Langkah 7: Uji Coba
Buka http://localhost/ddeltiket/index.php.

Coba registrasi akun baru.

Login dengan akun tersebut.

Klik salah satu kartu destinasi – harusnya langsung masuk ke halaman pemesanan (karena sudah login).

Klik "Lupa Sandi", masukkan email, dapatkan link reset, ganti password.

Login dengan password baru.

Langkah 8: (Opsional) Upgrade Kirim Email
Ganti bagian prosesLupaPassword.php dengan PHPMailer agar benar-benar mengirim email ke pengguna.

🧠 Penjelasan Logika Penting
✅ Keamanan Password
Tidak pernah menyimpan password asli di database.

Gunakan password_hash($password, PASSWORD_DEFAULT) saat registrasi.

Gunakan password_verify($input, $hash) saat login.

✅ Proteksi Halaman Pemesanan
Di index.js (bagian JavaScript), fungsi openDestinasiPage() dan openPaketPage() dicek:

javascript
if (!isLoggedIn) {
  showToast("Silakan Login terlebih dahulu.", true);
  navigateTo('page-auth');
  return;
}
Variabel isLoggedIn diambil dari PHP <?= $isLoggedIn ? 'true' : 'false' ?> di awal.

✅ Token Reset Password
Token dibuat dengan random_bytes(32) lalu bin2hex() – aman dan sulit ditebak.

Token disimpan di database bersama expires_at.

Saat reset, token dicocokkan dan waktu dicek expires_at > NOW().

Setelah berhasil, token dihapus agar tidak bisa dipakai lagi.

✅ Fitur "Ingat Saya"
Saat login, jika remember dicentang, server membuat cookie username dengan waktu kadaluarsa 30 hari.

Pada kunjungan berikutnya, sebelum menampilkan halaman, PHP bisa membaca cookie dan melakukan auto-login (walaupun di kode kita tidak diimplementasikan, tapi cookie bisa dimanfaatkan).

🚀 Tips agar Tidak Error
Perhatikan tipe data kolom – email dan password harus VARCHAR, bukan INT.

Jika error tablespace (#1813) – stop MySQL, hapus file .ibd di folder database, start lagi.

Gunakan database baru daripada pusing memperbaiki yang corrupt.

Pastikan file koneksi.php path-nya benar – jika file proses di folder proses/, maka include '../server/koneksi.php';.

Cek error log – buka xampp/mysql/data/mysql_error.log untuk melihat penyebab error.

📚 Kesimpulan
Sistem yang kita buat ini sudah mencakup fitur standar aplikasi web modern: registrasi, login, manajemen session, dan reset password. Meskipun untuk reset password masih simulasi, struktur kodenya sudah siap di-upgrade ke pengiriman email sungguhan.

Dengan memahami alur dan logika di atas, Anda bisa mengembangkan lebih lanjut, misalnya:

Menambahkan halaman profil.

Fitur ganti password dari dalam dashboard.

Validasi input lebih ketat (filter email, panjang password).

Menggunakan prepared statement untuk mencegah SQL injection (karena kode di atas masih rentan, ini penting untuk keamanan riil).
