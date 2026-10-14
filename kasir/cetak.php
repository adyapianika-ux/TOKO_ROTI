<?php
include "../koneksi.php";

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
    <title>Cetak Struk</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="card p-3 my-3 mx-auto" style="max-width:350px">

    <h4 class="text-center text-danger">Manisnya Cakery</h4>
    <p class="text-center">Struk Penjualan</p>

    <small>
        Tanggal: <?= $data['TanggalPenjualan'] ?><br>
        Pelanggan: <?= $data['NamaPelanggan'] ?>
    </small>

    <hr>

    <table class="table table-sm">

        <?php while ($d = mysqli_fetch_assoc($detail)) { ?>

        <tr>
            <td><?= $d['NamaProduk'] ?></td>
            <td><?= $d['JumlahProduk'] ?>x</td>
            <td>
                Rp <?= number_format($d['Subtotal'],0,',','.') ?>
            </td>
        </tr>

        <?php } ?>

    </table>

    <b>
        Total: Rp <?= number_format($data['TotalHarga'],0,',','.') ?>
    </b>

    <p class="text-center mt-4">
        Terima kasih 
    </p>

</div>

<script>
window.onload = function() {
    window.print();
};

window.onafterprint = function() {
    window.location.href = "detail_transaksi.php?id=<?= $id ?>";
};
</script>

</body>
</html>