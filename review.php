<?php 
session_start();
error_reporting(0);
include "connection/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review = $_POST['review'];
    $user = $_SESSION["user_id"];

    if (!empty($review) && !empty($user)) {
        // Menggunakan prepared statement untuk keamanan
        $stmt = $conn->prepare("INSERT INTO review (isi, user_id) VALUES (?, ?)");
        $stmt->bind_param("si", $review, $user);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Review anda berhasil ditambahkan');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menambahkan review');
                    window.location.href = 'index.php';
                  </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
                alert('Review atau user tidak valid');
                window.location.href = 'index.php';
              </script>";
    }
}

$conn->close();
?>
