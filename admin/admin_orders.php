<?php
session_start();
include("../connection/connection.php");

if (empty($_SESSION["adm_id"])) {
    header('location:index.php');
    exit();
}

// Query untuk mengambil data pesanan
$sql = "
    SELECT o.order_id, u.username, p.nama_produk, u.address, o.quantity, o.order_date, o.status, o.catatan, o.metode_bayar
    FROM orders o
    JOIN produk p ON o.produk_id = p.produk_id
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.order_id DESC
";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Orders</title>
     <!-- Font Awesome CDN Link -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/order.css">
</head>
<body>
    <div class="container">
        <table>
            <h1>Kembali ke <a href="dash.php">dashboard</a></h1>
            <thead>
                <tr>
                    <th>ID Order</th>
                    <th>Username</th>
                    <th>Nama Produk</th>
                    <th>Alamat</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pesanan</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Metode Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['order_id'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['nama_produk'] ?></td>
                        <td class="alamat"><?= $row['address']?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td><?= $row['order_date'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td class = "catatan"><?= $row['catatan'] ?></td>
                        <td><?= $row['metode_bayar'] ?></td>
                        <td>
                        <form action="update_order_status.php" method="post">
                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                <?php if ($row['status'] == 'pending'): ?>
                                    <button type="submit" name="action" value="accept">Terima</button>
                                    <button type="submit" name="action" value="reject">Tolak</button>
                                <?php elseif ($row['status'] == 'diproses'): ?>
                                    <button type="submit" name="action" value="complete">Selesai</button>   
                                <?php endif; ?>
                               
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
