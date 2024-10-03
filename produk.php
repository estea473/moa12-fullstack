<?php
session_start(); 
error_reporting(0); 
include("connection/connection.php");

$searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT produk_id, nama_produk, deskripsi, harga, img FROM produk";
if (!empty($searchTerm)) {
    $sql .= " WHERE nama_produk LIKE '%$searchTerm%'";
}

$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Adjust image path to be relative to the directory where images are stored
        $row['img'] = "admin/images/" . $row['img'];
        $products[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($products);
?>
