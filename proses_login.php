<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE Username='$username'");

$data = mysqli_fetch_assoc($query);

if ($data && password_verify($password, $data['Password'])) {

    $_SESSION['login'] = true;
    $_SESSION['nama'] = $data['Nama'];
    $_SESSION['role'] = $data['Role'];

    if ($data['Role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: kasir/dashboard.php");
    }

} else {
    echo "Username atau password salah!";
}
?>