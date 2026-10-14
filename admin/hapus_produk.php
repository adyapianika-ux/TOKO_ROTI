<?php
include "../koneksi.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM produk WHERE ProdukID='$id'");

header("Location: produk.php");
exit;
?>