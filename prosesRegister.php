<?php
include '../server/koneksi.php';

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

$username = $_POST['username'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi sederhana
if (empty($username) || empty($email) || empty($password)) {
    if ($isAjax) {
        echo json_encode(['status' => 'error', 'message' => 'Semua field harus diisi']);
        exit();
    } else {
        die("Semua field harus diisi");
    }
}

// Cek duplikat username atau email
$check = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' OR email='$email'");
if (mysqli_num_rows($check) > 0) {
    if ($isAjax) {
        echo json_encode(['status' => 'error', 'message' => 'Username atau Email sudah terdaftar']);
        exit();
    } else {
        die("Username atau Email sudah terdaftar");
    }
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password_hash')";
$result = mysqli_query($koneksi, $query);

if ($result) {
    if ($isAjax) {
        echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil, silakan login']);
        exit();
    } else {
        echo "Register Berhasil <a href='../login.php'>Login</a>";
    }
} else {
    if ($isAjax) {
        echo json_encode(['status' => 'error', 'message' => 'Registrasi gagal: ' . mysqli_error($koneksi)]);
        exit();
    } else {
        echo "Register Gagal: " . mysqli_error($koneksi);
    }
}
?>