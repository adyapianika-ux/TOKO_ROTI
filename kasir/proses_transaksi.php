<?php
include "../koneksi.php";

$nama = $_POST['nama_pelanggan'];
$produk = $_POST['produk'];
$jumlah = $_POST['jumlah'];

mysqli_query($conn, "INSERT INTO pelanggan (NamaPelanggan)
VALUES ('$nama')");

$pelanggan = mysqli_insert_id($conn);
$total = 0;

for ($i = 0; $i < count($produk); $i++) {

    $id = $produk[$i];
    $qty = $jumlah[$i];

    $p = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM produk WHERE ProdukID='$id'"
    ));

    $total += $p['Harga'] * $qty;
}

mysqli_query($conn, "INSERT INTO penjualan
(TanggalPenjualan, TotalHarga, PelangganID)
VALUES (CURDATE(), '$total', '$pelanggan')");

$penjualan = mysqli_insert_id($conn);

for ($i = 0; $i < count($produk); $i++) {

    $id = $produk[$i];
    $qty = $jumlah[$i];

    $p = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM produk WHERE ProdukID='$id'"
    ));

    $subtotal = $p['Harga'] * $qty;

    mysqli_query($conn, "INSERT INTO detailpenjualan
    (PenjualanID, ProdukID, JumlahProduk, Subtotal)
    VALUES ('$penjualan','$id','$qty','$subtotal')");

    mysqli_query($conn, "UPDATE produk
    SET Stok = Stok - $qty
    WHERE ProdukID='$id'");
}

header("Location: riwayat.php");
exit;
?>