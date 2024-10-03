<?php
session_start();
include("../connection/connection.php");

if (empty($_SESSION["adm_id"])) {
    header('location:index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];

    // Update status berdasarkan aksi yang dipilih
    switch ($action) {
        case 'accept':
            // Lakukan sesuai kebutuhan untuk menangani penerimaan pesanan
            $new_status = 'diproses';
            break;
        case 'reject':
            // Lakukan sesuai kebutuhan untuk menangani penolakan pesanan
            $new_status = 'ditolak';
            break;
        case 'complete':
            // Tandai pesanan sebagai selesai
            $new_status = 'selesai';
            break;
        default:
            // Aksi lainnya jika diperlukan
            break;
    }

    // Update status pesanan dalam database
    $update_sql = "UPDATE orders SET status = '$new_status' WHERE order_id = $order_id";

    if (mysqli_query($conn, $update_sql)) {
        header('location:admin_orders.php');
        exit();
    } else {
        echo "Update status gagal: " . mysqli_error($conn);
    }
}
?>
