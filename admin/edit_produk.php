<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM produk WHERE ProdukID='$id'"
));

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    mysqli_query($conn, "UPDATE produk SET
        NamaProduk='$nama', Harga='$harga', Stok='$stok'
        WHERE ProdukID='$id'");

    header("Location: produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="card p-4 m-4 mx-auto" style="max-width:500px">

    <h3 class="text-danger">Edit Produk</h3>

    <form method="POST">

        <input name="nama" class="form-control mb-2"
               value="<?= $data['NamaProduk'] ?>" required>

        <input name="harga" type="number"
               class="form-control mb-2"
               value="<?= $data['Harga'] ?>" required>

        <input name="stok" type="number"
               class="form-control mb-3"
               value="<?= $data['Stok'] ?>" required>

        <button name="simpan" class="btn btn-warning">
            Simpan
        </button>

        <a href="produk.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>