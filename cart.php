<?php
session_start();
include "connection/connection.php";

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT k.produk_id, k.user_id, p.nama_produk, p.harga, p.img, k.quantity
    FROM keranjang k
    JOIN produk p ON k.produk_id = p.produk_id
    WHERE k.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = array();
while ($row = $result->fetch_assoc()) {
    $row['img'] = "admin/images/" . $row['img'];
    $cartItems[] = $row;
}

echo json_encode($cartItems);

$stmt->close();
$conn->close();
?>
