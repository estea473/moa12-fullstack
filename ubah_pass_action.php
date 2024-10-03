<?php
session_start();
include "connection/connection.php";
// Periksa apakah user sudah login
if (!isset($_SESSION["user_id"])) {
    header('location:login.php');
    exit();
}

// Ambil data dari form
$userid = $_SESSION["user_id"];
$pass = $_POST["password"];
$confpass = $_POST["conf_pass"];

// Validasi input
if (empty($pass) || empty($confpass)) {
    echo "<script>alert('Password dan konfirmasi password harus diisi'); window.location.href='user.php';</script>";
    exit();
}

if ($pass !== $confpass) {
    echo "<script>alert('Password dan konfirmasi password tidak cocok'); window.location.href='user.php';</script>";
    exit();
}

// Hash password
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

// Persiapkan dan eksekusi query
$sql = "UPDATE users SET password = ? WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $hashed_pass, $userid);

if ($stmt->execute()) {
    echo "<script>alert('Password berhasil diubah'); window.location.href='user.php';</script>";
} else {
    echo "<script>alert('Data gagal disimpan');</script>";
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
