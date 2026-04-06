<?php
session_start();
include '../server/koneksi.php';

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

$login = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Cari user berdasarkan username ATAU email
$query = "SELECT * FROM users WHERE username = '$login' OR email = '$login'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username']; // simpan username asli
        
        if (isset($_POST['remember'])) {
            setcookie("username", $user['username'], time() + (86400 * 30), "/");
        }
        
        if ($isAjax) {
            echo json_encode(['status' => 'success', 'message' => 'Login berhasil', 'username' => $user['username']]);
            exit();
        } else {
            header("Location: ../dashboard.php");
            exit();
        }
    } else {
        $error = "Password salah!";
    }
} else {
    $error = "Username atau Email tidak ditemukan!";
}

if ($isAjax) {
    echo json_encode(['status' => 'error', 'message' => $error]);
    exit();
} else {
    echo $error . " <a href='../login.php'>Kembali</a>";
}
?>