<?php 
session_start();
error_reporting(0);
include "connection/connection.php";

// Mengambil data dari form
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$email = $_POST['email'];
$username = $_POST['username'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];
$def_pic = "user.png";

// Validasi password untuk mengandung huruf, angka, dan minimal 8 karakter
if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d).{8,}$/', $password)) {
    echo "<script>
            alert('Password harus mengandung huruf, angka, dan minimal 8 karakter');
            window.history.back();
          </script>";
    exit();
}

// Periksa apakah password dan konfirmasi password cocok
if ($confirmPassword !== $password) {
    echo "<script>
            alert('Password yang anda masukkan tidak cocok');
            window.history.back();
          </script>";
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Periksa apakah email sudah terdaftar
$email_check_query = "SELECT * FROM users WHERE email = ?";
$email_check_stmt = $conn->prepare($email_check_query);
$email_check_stmt->bind_param("s", $email);
$email_check_stmt->execute();
$email_check_stmt->store_result();

if ($email_check_stmt->num_rows > 0) {
    echo "<script>
            alert('Email sudah terdaftar, gunakan email lain');
            window.history.back();
          </script>";
    $email_check_stmt->close();
    $conn->close();
    exit();
}

// Periksa apakah username sudah terdaftar
$username_check_query = "SELECT * FROM users WHERE username = ?";
$username_check_stmt = $conn->prepare($username_check_query);
$username_check_stmt->bind_param("s", $username);
$username_check_stmt->execute();
$username_check_stmt->store_result();

if ($username_check_stmt->num_rows > 0) {
    echo "<script>
            alert('Username sudah terdaftar');
            window.history.back();
          </script>";
    $username_check_stmt->close();
    $conn->close();
    exit();
}

// Gunakan prepared statement untuk menghindari SQL injection
$sql_insert = "INSERT INTO users (f_name, l_name, email, username, phone, address, password, pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$insert_user_stmt = $conn->prepare($sql_insert);
$insert_user_stmt->bind_param("ssssssss", $firstname, $lastname, $email, $username, $phone, $address, $hashed_password, $def_pic);

if ($insert_user_stmt->execute()) {
    echo "<script>
            alert('Daftar Berhasil');
            window.location.href = 'login.php';
          </script>";
} else {
    echo "Data gagal disimpan: " . $insert_user_stmt->error;
}

// Tutup statement dan koneksi
$email_check_stmt->close();
$username_check_stmt->close();
$insert_user_stmt->close();
$conn->close();
?>
