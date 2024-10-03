<?php
session_start();
include "connection/connection.php";

if (empty($_SESSION["user_id"])) {
    header('location:login.php'); // Mengarahkan ke halaman login jika user belum login
    exit();
} else {
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT username FROM users WHERE user_id = '$user_id'";
    $hasil = mysqli_query($conn, $sql);

    if (!$hasil) {
        die("Query error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($hasil) > 0) {
        while ($row = mysqli_fetch_assoc($hasil)) {
            $username = $row["username"];
        }
    } else {
        echo "0 results";
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
    <title>welcome</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body {
        display: flex;
        align-items: center;
        text-align: center;
        height: 100vh;
        background-image: url(images/bananabg.jpg);
        font-family: "Poppins", sans-serif;
    }
    .dashboard-content {
        padding: 20px;
        width: 75rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }
    h1{
        font-size: 3rem;
        margin-bottom: 3px;
    }
    h2{
        font-size: 1.2rem;
    }
</style>
<body>
    <div class="dashboard-content">
        <h1>HALLOOO HEHE</h1>
        <h2>Selamat datang, <?php echo htmlspecialchars($username); ?></h2>
    </div>
</body>
</html>
<?php } ?> 