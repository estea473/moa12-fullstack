<?php
session_start();
include "connection/connection.php";

// Periksa apakah pengguna telah login
if (empty($_SESSION["user_id"])) {
    header('location:login.php');
    exit();
}

if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
    $user_id = $_SESSION["user_id"];
    $fileTmpPath = $_FILES['profilePic']['tmp_name'];
    $fileName = $_FILES['profilePic']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

    if (in_array($fileExtension, $allowedfileExtensions)) {
        $uploadFileDir = 'images/';
        $newFileName = $user_id . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sql = "UPDATE users SET pic='$newFileName' WHERE user_id='$user_id'";
            mysqli_query($conn, $sql);
            $_SESSION['message'] = 'Profile picture updated successfully';
        } else {
            $_SESSION['message'] = 'Error moving the uploaded file';
        }
    } else {
        $_SESSION['message'] = 'Invalid file type';
    }
} else {
    $_SESSION['message'] = 'Error uploading the file';
}

header('location:user.php');
exit();
?>
