<?php
session_start();
include("connection/connection.php");

if (empty($_SESSION["user_id"])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve orders for the logged-in user
$sql = "
    SELECT o.order_id, o.produk_id, p.img, p.nama_produk, o.quantity, o.order_date, o.status, o.catatan, u.user_id
    FROM `orders` o
    JOIN produk p ON o.produk_id = p.produk_id
    JOIN users u ON o.user_id = u.user_id
    WHERE o.user_id = ? AND DATE(o.order_date) = CURDATE()
    ORDER BY o.order_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = array();

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        }
        body {
            font-family: "Poppins", sans-serif;
            background-color:  #1e1e1e;
            margin: 0;
            padding: 0;
         }
        .produk-container ul::-webkit-scrollbar {
            width: 8px;
            background-color: rgba(0, 0, 0, 0); 
        }
        .produk-container ul::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.5); 
            border-radius: 10px;
        }
        .produk-container ul::-webkit-scrollbar-thumb:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
        .produk-container ul {
            scrollbar-width: thin; 
        }
        .produk-container ul:hover {
            scrollbar-color: rgba(0, 0, 0, 0.7) rgba(0, 0, 0, 0); 
        }
        .produk-container {
            width: 700px;
            margin: 50px 3rem;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .produk-container h1 {
            color: white;
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .produk-container ul {
            list-style-type: none;
            padding: 0;
            overflow: auto;
            max-height: 600px; 
        }
        .produk-container li {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        .produk-container  img {
            border-radius: 4px;
            width: 100px;
            height: 100px;
            float: left;
            margin-right: 20px;
            object-fit: cover;
        }
        .status-pending {
            color: orange;
            font-weight: bold;
        }
        .status-diproses {
            color: blue;
            font-weight: bold;
        }
        .status-dikirim {
            color: green;
            font-weight: bold;
        }
        .status-complete {
            color: gray;
            font-weight: bold;
        }
        @media screen and (max-width: 768px) {
            .produk-container {
                width: 80%;
                padding: 10px;
                margin: 30px auto;
            }
            .produk-container h1 {
                font-size: 20px;
            }
            .produk-container li {
                padding: 15px;
            }
            .produk-container img {
                width: 80px;
                height: 80px;
                margin-right: 10px;
                object-fit: cover;
            }
        }
    </style>
</head>
<body>
    <div class="produk-container">
        <h1>Hari ini order apa aja ya?</h1>
        <?php if (empty($orders)): ?>
            <p>Tidak ada pesanan yang ditemukan.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($orders as $order): ?>
                <li>
                    <img src="admin/images/<?=$order['img']?>" alt="<?=$order['nama_produk']?>" />
                    <div>
                        <h3><?=$order['nama_produk']?></h3>
                        <p><strong>Jumlah:</strong> <?=$order['quantity']?></p>
                        <p><strong>Tanggal Pesanan:</strong> <?=$order['order_date']?></p>
                        <p><strong>Status:</strong> <span class="status status-<?=$order['status']?>"><?=$order['status']?></span></p>
                        <p><strong>Catatan:</strong> <?=$order['catatan']?></p>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>

