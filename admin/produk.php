<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM produk ORDER BY ProdukID DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produk - Manisnya Cakery</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery - Produk</b>

        <div>
            <a href="dashboard.php" class="btn btn-light">Beranda</a>
            <a href="../logout.php" class="btn btn-warning">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2 class="text-danger">Data Produk</h2>
        <a href="tambah_produk.php" class="btn btn-warning">
            + Tambah
        </a>
    </div>

    <div class="card p-3">
        <table class="table table-bordered text-center">

            <tr class="table-warning">
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            <?php $no = 1; ?>

            <?php while ($x = mysqli_fetch_assoc($data)) { ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= $x['NamaProduk'] ?></td>
                <td>Rp <?= number_format($x['Harga'], 0, ',', '.') ?></td>
                <td><?= $x['Stok'] ?></td>

                <td>
                    <a href="edit_produk.php?id=<?= $x['ProdukID'] ?>"
                       class="btn btn-primary btn-sm">Edit</a>

                    <a href="hapus_produk.php?id=<?= $x['ProdukID'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus produk ini?')">
                        Hapus
                    </a>
                </td>
            </tr>

            <?php } ?>

        </table>
    </div>

</div>

</body>
</html>