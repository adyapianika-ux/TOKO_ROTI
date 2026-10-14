<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$data = mysqli_query($conn, "
    SELECT p.*, pl.NamaPelanggan
    FROM penjualan p
    LEFT JOIN pelanggan pl
    ON p.PelangganID = pl.PelangganID
    ORDER BY p.TanggalPenjualan DESC
");

$total = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT SUM(TotalHarga) AS total
    FROM penjualan
"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>

    <link
        href="../bootstrap/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">

        <b class="text-white">
            Manisnya Cakery - Admin
        </b>

        <div>
            <a href="dashboard.php" class="btn btn-light">
                Beranda
            </a>

            <a href="../logout.php" class="btn btn-warning">
                Logout
            </a>
        </div>

    </div>
</nav>

<div class="container mt-4">

    <h2 class="text-danger">
        Laporan Penjualan
    </h2>

    <div class="alert alert-danger">
        <b>Total Pendapatan:</b>
        Rp <?= number_format($total['total'] ?? 0, 0, ',', '.') ?>
    </div>

    <table class="table table-bordered">

        <tr class="table-warning">
            <th>No</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>

        <?php while ($x = mysqli_fetch_assoc($data)) { ?>

        <tr>
            <td><?= $no++ ?></td>

            <td>
                <?= date('d-m-Y', strtotime($x['TanggalPenjualan'])) ?>
            </td>

            <td>
                <?= $x['NamaPelanggan'] ?? '-' ?>
            </td>

            <td>
                Rp <?= number_format($x['TotalHarga'], 0, ',', '.') ?>
            </td>

            <td>
                <a
                    href="detail_transaksi.php?id=<?= $x['PenjualanID'] ?>"
                    class="btn btn-info btn-sm">
                    Detail
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>