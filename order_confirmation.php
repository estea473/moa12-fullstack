<?php
session_start();

if (empty($_SESSION["user_id"])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Pastikan file CSS ini ada -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 18px;
            color: #666;
        }
        a.button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pesanan Anda Telah Berhasil</h1>
        <p>Terima kasih telah berbelanja di toko kami. Pesanan Anda sedang diproses.</p>
        <p>Anda dapat memeriksa status pesanan Anda di <a href="user.php">Orderan Saya</a>.</p>
        <a href="index.php" class="button">Kembali ke Beranda</a>
    </div>
</body>
</html>
