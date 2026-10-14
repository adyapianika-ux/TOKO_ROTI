<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? $_POST['id'];

if (isset($_POST['simpan'])) {

    foreach ($_POST['detail'] as $i => $d) {
        $j = (int)$_POST['jumlah'][$i];
        mysqli_query($conn, "UPDATE detailpenjualan SET JumlahProduk='$j'
        WHERE DetailID='$d'");
    }

    if (!empty($_POST['produk']) && $_POST['jumlah_baru'] > 0) {
        $p = $_POST['produk'];
        $j = $_POST['jumlah_baru'];

        $cek = mysqli_query($conn, "SELECT * FROM detailpenjualan
        WHERE PenjualanID='$id' AND ProdukID='$p'");

        if (mysqli_num_rows($cek)) {
            $x = mysqli_fetch_assoc($cek);
            $j += $x['JumlahProduk'];

            mysqli_query($conn, "UPDATE detailpenjualan SET JumlahProduk='$j'
            WHERE DetailID='{$x['DetailID']}'");
        } else {
            $x = mysqli_fetch_assoc(mysqli_query($conn,
                "SELECT Harga FROM produk WHERE ProdukID='$p'"));

            mysqli_query($conn, "INSERT INTO detailpenjualan
            (PenjualanID,ProdukID,JumlahProduk,Subtotal)
            VALUES ('$id','$p','$j',{$x['Harga']}*$j)");
        }
    }

    $total = 0;

    $data = mysqli_query($conn, "SELECT d.*,p.Harga FROM detailpenjualan d
    JOIN produk p ON d.ProdukID=p.ProdukID WHERE d.PenjualanID='$id'");

    while ($x = mysqli_fetch_assoc($data)) {
        $sub = $x['Harga'] * $x['JumlahProduk'];
        $total += $sub;

        mysqli_query($conn, "UPDATE detailpenjualan SET Subtotal='$sub'
        WHERE DetailID='{$x['DetailID']}'");
    }

    mysqli_query($conn, "UPDATE penjualan SET TotalHarga='$total'
    WHERE PenjualanID='$id'");

    header("Location: riwayat.php");
    exit;
}

$data = mysqli_query($conn, "SELECT d.*,p.NamaProduk
FROM detailpenjualan d JOIN produk p ON d.ProdukID=p.ProdukID
WHERE d.PenjualanID='$id'");

$produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY NamaProduk");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaksi</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery - Kasir</b>
        <a href="dashboard.php" class="btn btn-light">Beranda</a>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-danger">Edit Transaksi</h2>

    <div class="card p-3">
        <form method="POST">

            <input type="hidden" name="id" value="<?= $id ?>">

            <table class="table table-bordered">
                <tr class="table-warning">
                    <th>Produk</th><th>Jumlah</th>
                </tr>

                <?php while ($x = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td>
                        <?= $x['NamaProduk'] ?>
                        <input type="hidden" name="detail[]"
                               value="<?= $x['DetailID'] ?>">
                    </td>
                    <td>
                        <input type="number" name="jumlah[]"
                               value="<?= $x['JumlahProduk'] ?>"
                               min="1" class="form-control" style="width:100px">
                    </td>
                </tr>
                <?php } ?>
            </table>

            <h5>Tambah Barang</h5>

            <select name="produk" class="form-select mb-2">
                <option value="">-- Pilih Produk --</option>

                <?php while ($p = mysqli_fetch_assoc($produk)) { ?>
                <option value="<?= $p['ProdukID'] ?>">
                    <?= $p['NamaProduk'] ?> -
                    Rp <?= number_format($p['Harga'],0,',','.') ?>
                </option>
                <?php } ?>
            </select>

            <input type="number" name="jumlah_baru" value="1" min="1"
                   class="form-control mb-3" style="width:100px">

            <button name="simpan" class="btn btn-warning">Simpan</button>
            <a href="riwayat.php" class="btn btn-secondary">Kembali</a>

        </form>
    </div>
</div>

</body>
</html>