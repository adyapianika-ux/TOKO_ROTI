<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$d = mysqli_query($conn, "
    SELECT p.NamaPelanggan, MAX(j.TanggalPenjualan) t
    FROM pelanggan p LEFT JOIN penjualan j
    ON p.PelangganID=j.PelangganID
    GROUP BY p.PelangganID
    ORDER BY t DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pelanggan</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar bg-danger p-3">
    <div class="container">
        <b class="text-white">Manisnya Cakery - Admin</b>
        <div>
            <a href="dashboard.php" class="btn btn-light">Beranda</a>
            <a href="../logout.php" class="btn btn-warning">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-danger">Data Pelanggan</h2>

    <div class="card p-3">
        <table class="table table-bordered">
            <tr class="table-warning">
                <th>No</th><th>Nama</th><th>Tanggal</th>
            </tr>

            <?php $no=1; while($x=mysqli_fetch_assoc($d)){ ?>
            <tr class="<?= $no>5?'tambahan d-none':'' ?>">
                <td><?= $no++ ?></td>
                <td><?= $x['NamaPelanggan'] ?></td>
                <td><?= $x['t'] ? date('d-m-Y',strtotime($x['t'])) : '-' ?></td>
            </tr>
            <?php } ?>
        </table>

        <?php if($no>6){ ?>
        <button onclick="lihat()" id="btn" class="btn btn-warning btn-sm">
            Lihat Lebih Banyak
        </button>
        <?php } ?>
    </div>
</div>

<script>
function lihat(){
    document.querySelectorAll('.tambahan')
    .forEach(x=>x.classList.toggle('d-none'));

    btn.innerText=btn.innerText=='Lihat Lebih Banyak'
        ?'Lebih Sedikit':'Lihat Lebih Banyak';
}
</script>

</body>
</html>