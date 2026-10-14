<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'kasir') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kasir</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery - Kasir</b>
        <a href="../logout.php" class="btn btn-warning">Logout</a>
    </div>
</nav>

<div class="container mt-4">

    <h2 class="text-danger">Dashboard Kasir</h2>

    <p>Selamat datang, <b><?= $_SESSION['nama'] ?></b></p>

    <div class="row g-3">

        <div class="col-md-6">
            <a href="transaksi.php" class="text-decoration-none text-dark">
                <div class="card p-4 text-center">
                    <h3>🛒</h3>
                    <h5>Transaksi</h5>
                    <p>Melakukan transaksi penjualan</p>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="riwayat.php" class="text-decoration-none text-dark">
                <div class="card p-4 text-center">
                    <h3>📋</h3>
                    <h5>Riwayat Transaksi</h5>
                    <p>Melihat transaksi yang sudah dilakukan</p>
                </div>
            </a>
        </div>

    </div>

</div>

</body>
</html>