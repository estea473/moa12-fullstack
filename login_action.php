<?php
session_start();
include "connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$user' ";
    $hasil = mysqli_query($conn, $sql);
    $row=mysqli_fetch_array($hasil);

    if(is_array($row)) {
        if (password_verify($pass, $row['password'])){
            $_SESSION["user_id"] = $row['user_id']; 
            header("refresh:1;url=index.php"); 
        } 
        else{
            echo "<script>
                    alert('Username atau password salah!');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Username atau password salah!');
                window.location.href = 'login.php';
              </script>";
    }
} else {
    echo "Invalid request method.";
}
// ?>