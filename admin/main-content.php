<?php
session_start();
include("../connection/connection.php");

if (empty($_SESSION["adm_id"])) {
    header('location:index.php');
    exit();
}

$adm_id = $_SESSION['adm_id'];
$sql = "SELECT username FROM admin WHERE adm_id = '$adm_id'";
$hasil = mysqli_query($conn, $sql);
if (!$hasil) {
    die("Query error: " . mysqli_error($conn));
}

$username = "";
if (mysqli_num_rows($hasil) > 0) {
    // Output data dari setiap baris
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom CSS File Link -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url(images/bananabg.jpg);
            font-family: "Poppins", sans-serif;
        }
        .dashboard-content {
            text-align: center;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="dashboard-content">
        <h1>Dashboard</h1>
        <h2>Selamat datang, <?php echo htmlspecialchars($username); ?></h2>
        <!-- Tambahkan konten lain dari dashboard di sini -->
    </div>
    
    <!-- JavaScript links -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
