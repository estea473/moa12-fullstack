<?php
session_start();
include "../connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username = '$user' AND password = '$pass'";
    $hasil = mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($hasil);

    if (mysqli_num_rows($hasil) > 0) {
        $_SESSION["adm_id"] = $row['adm_id'];
        echo "<script>
                alert('Login berhasil!');
                window.location.href = 'dash.php';
              </script>";
    } else {
        echo "<script>
                alert('Username atau password salah!');
                window.location.href = 'login.php';
              </script>";
    }
} else {
    echo "Invalid request method.";
}
?>