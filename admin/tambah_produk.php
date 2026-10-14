<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "INSERT INTO produk
        (NamaProduk,Harga,Stok)
        VALUES ('$nama','$harga','$stok')");

    header("Location: produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery</b>
        <a href="produk.php" class="btn btn-warning">Kembali</a>
    </div>
</nav>

<div class="card p-4 m-4 mx-auto" style="max-width:500px">

    <h3 class="text-danger">Tambah Produk</h3>

    <form method="POST">

        <input name="nama" class="form-control mb-2"
               placeholder="Nama Produk" required>

        <input name="harga" type="number"
               class="form-control mb-2"
               placeholder="Harga" required>

        <input name="stok" type="number"
               class="form-control mb-3"
               placeholder="Stok" required>

        <button name="simpan" class="btn btn-warning">
            Simpan
        </button>

        <a href="produk.php" class="btn btn-secondary">
            Batal
        </a>

    </form>

</div>

</body>
</html>