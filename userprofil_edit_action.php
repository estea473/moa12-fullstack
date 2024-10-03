<?php
session_start();
include "connection/connection.php";

$userid = $_SESSION["user_id"];
$email = $_POST["email"];
$f_name = $_POST["f_name"];
$l_name = $_POST["l_name"];
$alamat = $_POST["alamat"];
$phone = $_POST["phone"];

    $sql = "UPDATE users SET email='$email', f_name='$f_name', l_name='$l_name', address='$alamat', phone='$phone' WHERE user_id='$userid'";
    $hasil = mysqli_query($conn, $sql);
    if($hasil){
        echo "<script> alert('Data berhasil di ubah'); window.location.href='user.php'</script>";
        exit();
    }
    else{
        echo "Data gagal disimpan";
    }
?>
