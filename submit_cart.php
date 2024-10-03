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
$items = $data['items'];

// Prepare statement for updating and inserting
$updateStmt = $conn->prepare("UPDATE keranjang SET quantity = ? WHERE produk_id = ? AND user_id = ?");
$updateStmt->bind_param("iii", $quantity, $produk_id, $user_id);

$insertStmt = $conn->prepare("INSERT INTO keranjang (produk_id, user_id, quantity) VALUES (?, ?, ?)");
$insertStmt->bind_param("iii", $produk_id, $user_id, $quantity);

// Process each item
foreach ($items as $item) {
    $produk_id = $item['produk_id'];
    $quantity = $item['quantity'];

    if ($quantity > 0) {
        // Check if the item already exists in the cart
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM keranjang WHERE produk_id = ? AND user_id = ?");
        $checkStmt->bind_param("ii", $produk_id, $user_id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Update the quantity if the item already exists
            $updateStmt->execute();
        } else {
            // Insert the item if it does not exist
            $insertStmt->execute();
        }
    }
}

// Close statements and connection
$updateStmt->close();
$insertStmt->close();
$conn->close();

http_response_code(200);
echo json_encode(["message" => "Cart updated successfully"]);
?>
