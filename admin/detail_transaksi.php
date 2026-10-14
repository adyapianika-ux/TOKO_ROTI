<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($conn, "
    SELECT d.*,p.NamaProduk,p.Harga
    FROM detailpenjualan d
    JOIN produk p ON d.ProdukID=p.ProdukID
    WHERE d.PenjualanID='$id'
");

$t = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT p.*,pl.NamaPelanggan
    FROM penjualan p
    LEFT JOIN pelanggan pl ON p.PelangganID=pl.PelangganID
    WHERE p.PenjualanID='$id'
"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery - Admin</b>
        <a href="laporan.php" class="btn btn-light">Kembali</a>
    </div>
</nav>

<div class="container mt-4">

    <h2 class="text-danger">Detail Transaksi</h2>

    <div class="card p-3 mb-3">
        <b>Tanggal:</b>
        <?= date('d-m-Y',strtotime($t['TanggalPenjualan'])) ?>

        <b>Pelanggan:</b>
        <?= $t['NamaPelanggan'] ?? '-' ?>
    </div>

    <div class="card p-3">

        <table class="table table-bordered">

            <tr class="table-warning">
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>

            <?php while($x=mysqli_fetch_assoc($data)){ ?>

            <tr>
                <td><?= $x['NamaProduk'] ?></td>
                <td>Rp <?= number_format($x['Harga'],0,',','.') ?></td>
                <td><?= $x['JumlahProduk'] ?></td>
                <td>Rp <?= number_format($x['Subtotal'],0,',','.') ?></td>
            </tr>

            <?php } ?>

        </table>

        <h5 class="text-danger">
            Total: Rp <?= number_format($t['TotalHarga'],0,',','.') ?>
        </h5>

    </div>

</div>

</body>
</html>