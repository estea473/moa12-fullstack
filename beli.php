<?php
session_start();
error_reporting(0);
include("connection/connection.php");

if (empty($_SESSION["user_id"])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve cart items for the logged-in user
$sql = "
    SELECT k.produk_id, k.user_id, p.nama_produk, p.deskripsi, p.harga, p.img, k.quantity, u.address
    FROM keranjang k
    JOIN produk p ON k.produk_id = p.produk_id
    JOIN users u ON k.user_id = u.user_id
    WHERE k.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$products_in_cart = array();
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    $row['img'] = "admin/images/" . $row['img']; // Adjust image path
    $products_in_cart[$row['produk_id']] = $row;
    $subtotal += $row['harga'] * $row['quantity'];
    $alamat = $row['address'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/beli.css">
<script>
async function removeProduct(produkId) {
    const response = await fetch('deletecart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            produk_id: produkId
        })
    });

    if (response.ok) {
        location.reload(); // Reload the page to update the cart UI
    } else {
        const result = await response.json();
        console.error('Failed to remove product:', result.message);
    }
}
</script>
</head>
<body>
    <div class="row">
        <section class="box">
            <h3>Pesanan Anda</h3>
            <div class="pesanan" id="pesananList">
                <!-- Daftar produk akan ditambahkan di sini -->
                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Produk</td>
                            <td>Harga</td>
                            <td>Jumlah</td>
                            <td>Total</td>
                            <!-- <td>Aksi</td> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products_in_cart)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Anda belum menambahkan produk apapun di keranjang belanja</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($products_in_cart as $product): ?>
                        <tr>
                            <td class="img">
                                <a href="index.php?page=product&id=<?=$product['produk_id']?>">
                                    <img src="<?=$product['img']?>" width="50" height="50" alt="<?=$product['nama_produk']?>">
                                </a>
                            </td>
                            <td>
                                <a href="index.php?page=product&id=<?=$product['produk_id']?>" class="nama-produk"><?=$product['nama_produk']?></a>
                                <br>
                            </td>
                            <td class="price">Rp<?=$product['harga']?></td>
                            <td class="quantity">
                                <span><?=$product['quantity']?></span>
                            </td>
                            <td class="price">Rp<?=$product['harga'] * $product['quantity']?></td>
                            <!-- <td>
                                <button onclick="removeProduct(<?=$product['produk_id']?>)">Hapus</button>
                            </td> -->
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="alamat">
                    <p>Alamat : <?=$alamat?></p>
                </div>
            </div>
        </section>
        <section class="payment">
            <h3>Pembayaran</h3>
            <p class="subtotal">Subtotal: <span class="total">Rp <?=$subtotal?></span></p> 
            <div class="methode">
                <form action="order_action.php" method="post">
                    <label for="pay">Metode Pembayaran</label>
                    <select id="pay" name="pay">
                        <option value="none" disabled>--None--</option>
                        <?php foreach (['COD', 'Transfer Bank'] as $option): ?>
                            <option value="<?=$option?>" <?=($option == $metode_bayar) ? 'selected' : ''?>><?=$option?></option>
                        <?php endforeach; ?>
                    </select><br><br>
                    <label for="note">Catatan (optional):</label>
                    <textarea id="note" name="note" placeholder="Tulis catatan anda"></textarea>
                    <button type="submit" class="btn">Pesan Sekarang</button>
                </form>
            </div>  
        </section>
    </div>
</body>
</html>

