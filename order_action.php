<?php
session_start();
include("connection/connection.php");

if (empty($_SESSION["user_id"])) {
    header('Location: login.php'); 
    exit();
}

$user_id = $_SESSION['user_id'];
$payment_method = $_POST['pay'];
$note = $_POST['note'];

$sql = "SELECT k.produk_id, k.quantity FROM keranjang k WHERE k.user_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $produk_id = $row['produk_id'];
    $quantity = $row['quantity'];
    $metode_bayar = $_POST['pay'];
    $insert_order_sql = "INSERT INTO orders (user_id, produk_id, quantity, status, catatan, metode_bayar) VALUES (?, ?, ?, 'pending', ?, ?)
    ";

    $insert_stmt = $conn->prepare($insert_order_sql);
    $insert_stmt->bind_param("iiiss", $user_id, $produk_id, $quantity, $note, $metode_bayar);
    $insert_stmt->execute();
    $insert_stmt->close();
}

// Clear the cart
$clear_cart_sql = "DELETE FROM keranjang WHERE user_id = ?";
$clear_cart_stmt = $conn->prepare($clear_cart_sql);
$clear_cart_stmt->bind_param("i", $user_id);
$clear_cart_stmt->execute();
$clear_cart_stmt->close();

$stmt->close();
$conn->close();

header('Location: order_confirmation.php');
exit();
?>
