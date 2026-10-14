<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manisnya Cakery</title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width:400px">

        <h3 class="text-center text-danger mb-3">
            Manisnya Cakery
        </h3>

        <p class="text-center text-muted">
            Login Admin / Kasir
        </p>

        <form action="proses_login.php" method="POST">

            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password"
                       class="form-control" required>
            </div>

            <button type="submit" name="login"
                    class="btn btn-danger w-100">
                Login
            </button>

        </form>

    </div>
</div>

</body>
</html>