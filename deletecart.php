<?php
session_start();
include "connection/connection.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "User not logged in"]);
    exit;
}

// Get the JSON payload
$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id']; // Get user_id from session
$produk_id = $data['produk_id'];

// Delete the item from the cart
$stmt = $conn->prepare("DELETE FROM keranjang WHERE produk_id = ? AND user_id = ?");
$stmt->bind_param("ii", $produk_id, $user_id);
$stmt->execute();
$stmt->close();
$conn->close();

http_response_code(200);
echo json_encode(["message" => "Product removed from cart successfully"]);
?>
