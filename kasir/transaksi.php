<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'kasir') {
    header("Location: ../login.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery - Kasir</b>
        <a href="dashboard.php" class="btn btn-warning">Kembali</a>
    </div>
</nav>

<div class="card p-4 m-4 mx-auto" style="max-width:600px">

    <h2 class="text-danger mb-4">Transaksi Penjualan</h2>

    <form action="proses_transaksi.php" method="POST">

        <label>Nama Pelanggan</label>
        <input name="nama_pelanggan" class="form-control mb-3"
               placeholder="Masukkan nama pelanggan" required>

        <label>Produk</label>

        <div id="daftar-produk">

            <div class="produk d-flex gap-2 mb-2">

                <select name="produk[]" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>

                    <?php while ($p = mysqli_fetch_assoc($produk)) { ?>
                        <option value="<?= $p['ProdukID'] ?>">
                            <?= $p['NamaProduk'] ?> -
                            Rp <?= number_format($p['Harga'],0,',','.') ?>
                        </option>
                    <?php } ?>

                </select>

                <input type="number" name="jumlah[]"
                       class="form-control" style="width:90px"
                       placeholder="Qty" min="1" required>

            </div>

        </div>

        <button type="button" onclick="tambahProduk()"
                class="btn btn-secondary mb-3">
            + Tambah Produk
        </button>

        <br>

        <button name="simpan" class="btn btn-warning">
            Simpan Transaksi
        </button>

    </form>

</div>

<script>
function tambahProduk() {
    let x = document.querySelector('.produk').cloneNode(true);
    x.querySelector('select').value = "";
    x.querySelector('input').value = "";
    document.getElementById('daftar-produk').appendChild(x);
}
</script>

</body>
</html>