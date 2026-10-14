<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'kasir') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT p.*, pl.NamaPelanggan
    FROM penjualan p
    JOIN pelanggan pl ON p.PelangganID=pl.PelangganID
    WHERE PenjualanID='$id'
"));

$detail = mysqli_query($conn, "
    SELECT d.*, p.NamaProduk
    FROM detailpenjualan d
    JOIN produk p ON d.ProdukID=p.ProdukID
    WHERE PenjualanID='$id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    <div class="card p-3 mx-auto" style="max-width:600px">

        <h3 class="text-danger">Detail Transaksi</h3>

        <p>
            <b>No:</b> <?= $data['PenjualanID'] ?><br>
            <b>Tanggal:</b> <?= $data['TanggalPenjualan'] ?><br>
            <b>Pelanggan:</b> <?= $data['NamaPelanggan'] ?><br>
            <b>Kasir:</b> <?= $_SESSION['nama'] ?>
        </p>

        <table class="table table-bordered">

            <tr class="table-warning">
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>

            <?php while ($d = mysqli_fetch_assoc($detail)) { ?>

            <tr>
                <td><?= $d['NamaProduk'] ?></td>
                <td><?= $d['JumlahProduk'] ?>x</td>
                <td>
                    Rp <?= number_format($d['Subtotal'], 0, ',', '.') ?>
                </td>
            </tr>

            <?php } ?>

        </table>

        <h5 class="text-danger">
            Total: Rp <?= number_format($data['TotalHarga'], 0, ',', '.') ?>
        </h5>

        <div class="mt-3">
            <a href="riwayat.php" class="btn btn-secondary">
                Kembali
            </a>

            <a href="cetak.php?id=<?= $id ?>" class="btn btn-warning">
                Cetak
            </a>
        </div>

    </div>

</div>

</body>
</html>