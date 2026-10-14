<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$produk = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS jumlah FROM produk"));

$pelanggan = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS jumlah FROM pelanggan"));

$transaksi = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS jumlah FROM penjualan"));

$pendapatan = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT SUM(TotalHarga) AS total FROM penjualan"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery - Admin</b>

        <a href="../logout.php" class="btn btn-warning">
            Logout
        </a>
    </div>
</nav>

<div class="container mt-4">

    <h2 class="text-danger">Dashboard Admin</h2>

    <p>
        Selamat datang, <b><?= $_SESSION['nama']; ?></b>
    </p>

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card p-3">
                <p>Jumlah Produk</p>
                <h3><?= $produk['jumlah']; ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <p>Jumlah Pelanggan</p>
                <h3><?= $pelanggan['jumlah']; ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <p>Jumlah Transaksi</p>
                <h3><?= $transaksi['jumlah']; ?></h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <p>Total Pendapatan</p>
                <small>Seluruh transaksi</small>
                <h5>
                    Rp <?= number_format(
                        $pendapatan['total'] ?? 0, 0, ',', '.'
                    ); ?>
                </h5>
            </div>
        </div>

    </div>

    <div class="row g-3">

        <div class="col-md-4">
            <div class="card p-3">
                <h4 class="text-danger">Kelola Produk</h4>
                <p>Tambah, edit, dan hapus produk.</p>
                <a href="produk.php" class="btn btn-warning">
                    Lihat Produk
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4 class="text-danger">Data Pelanggan</h4>
                <p>Melihat data pelanggan.</p>
                <a href="pelanggan.php" class="btn btn-warning">
                    Lihat Pelanggan
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h4 class="text-danger">Laporan Penjualan</h4>
                <p>Melihat laporan seluruh transaksi.</p>
                <a href="laporan.php" class="btn btn-warning">
                    Lihat Laporan
                </a>
            </div>
        </div>

    </div>

</div>

</body>
</html>