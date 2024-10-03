<?php
session_start();
include "connection/connection.php";

if (empty($_SESSION["user_id"])) {
    header('location:login.php'); // Mengarahkan ke halaman login jika user belum login
    exit();
} else {
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT username, CONCAT(f_name, ' ', l_name) AS fullname, email, phone, password, address, pic FROM users WHERE user_id = '$user_id'";
    $hasil = mysqli_query($conn, $sql);

    if (!$hasil) {
        die("Query error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($hasil) > 0) {
        while ($row = mysqli_fetch_assoc($hasil)) {
            $username = $row["username"];
            $nama_lengkap = $row["fullname"];
            $profile_pic = $row["pic"];
        }
    } else {
        echo "0 results";
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,400&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
            background-color: #f4f4f4;
        }
        aside {
            height: 100vh;
            background-color: #ffc700;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 20rem;
            overflow: hidden;
            transition: all 0.3s;
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 11;
        }
        .container {
            display: flex;
            flex-direction: column;
            height: 100vh;
            left: 0;
        }
        .profile-card {
            background-color: black;
            color: white;
            padding: 2rem 0;
            text-align: center;
            box-shadow: black;
        }
        .profile-card img.profile-pic {
            border-radius: 50%;
            height: 120px;
            width: 120px;
            object-fit: cover;
            border: 2px solid #dbd6d6;
        }
        .profile-card .info-user {
            padding-top: 5px;
            font-size: 1.2rem;
        }
        .profile-card .info-user h2 {
            margin-bottom: 5px;
        }
        .container .user-menu {
            padding-top: 1rem;
            flex-grow: 1;
        }
        .container .user-menu ul {
            list-style: none;
        }
        .container .user-menu ul li {
            padding: 0.6rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .container .user-menu ul li a i {
            padding-right: 9px;
        }
        .container .user-menu li a {
            color: black;
            text-decoration: none; 
            display: flex;
            align-items: center;
        }
        .container .user-menu li:hover {
            background-color: #302500;
            cursor: pointer;
        }
        .container .user-menu li:hover a {
            color: #dbd6d6;
        }
        .profile-pic-wrapper {
            position: relative;
            display: inline-block;
        }
        .profile-pic-wrapper .edit-icon {
            position: absolute;
            bottom: 2px;
            right: 15px;
            font-size: 1.2rem;
            background: #dbd6d6;
            color: black;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .content {
        width: calc(100% - 20rem);
        position: relative;
        float: right;
        transition: all 0.3s;
        }
        @media screen and (max-width: 768px) {
    /* Aturan CSS untuk tablet dan perangkat mobile */
    aside {
        width: 100%; /* Lebar penuh untuk sidebar pada perangkat kecil */
        position: static; /* Hapus position: absolute; untuk sidebar */
        box-shadow: none; /* Hapus shadow untuk sidebar */
        z-index: 1; /* Geser ke atas untuk tumpukan dengan konten */
        height: auto; /* Tinggi otomatis */
    }
    .container {
        flex-direction: column; /* Kolom perangkat kecil */
    }
    .content {
        display: none; /* Konten lebar penuh pada perangkat kecil */
    }
    /* Aturan tambahan untuk elemen lainnya yang perlu disesuaikan */
}

    </style>
</head>
<body>
<aside id="sidebar">
    <div class="container">
        <div class="profile-card">
            <div class="profile-pic-wrapper">
                <img src="images/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-pic" />
                <form id="uploadForm" action="upload_gambar.php" method="POST" enctype="multipart/form-data">
                    <input type="file" id="fileInput" name="profilePic" style="display: none" onchange="document.getElementById('uploadForm').submit();" />
                    <a onclick="document.getElementById('fileInput').click();" class="edit-icon"><i class="fas fa-pencil-alt"></i></a>
                </form>
            </div>
            <div class="info-user">
                <h2><?php echo htmlspecialchars($username); ?></h2>
                <!-- <p><?php echo htmlspecialchars($nama_lengkap); ?></p> -->
            </div>
        </div>
        <div class="user-menu">
            <ul>
                <li><a href="order_saya.php" class="load-content"><i class="material-icons">assignment</i>Orderan saya</a></li>
                <li><a href="ubah_pass.php" class="load-content"><i class="material-icons">vpn_key</i>Ubah Password</a></li>
                <li><a href="useredit.php" class="load-content"><i class="material-icons">edit</i>Ubah Profil</a></li>
                <li><a href="index.php"><i class="material-icons">home</i>Home</a></li>
                <li><a href="login.php"><i class="material-icons">exit_to_app</i>Logout</a></li>
            </ul>
        </div>
    </div>
</aside>
<section>
    <div class="content" id="main-content">
        <div class="load-content" data-target="welcomeuser.php"></div>
    </div>
</section>
<script>
   function logout() {
        // Logic for logout
        alert("You have been logged out.");
        window.location.href = "login.php";
    }
    $(document).ready(function () {
        $('#main-content .load-content').load('welcomeuser.php');
        $(".load-content").on("click", function (e) {
            e.preventDefault();
            var target = $(this).attr("href"); 
            $("#main-content").load(target, function (response, status, xhr) {
                if (status === "error") {
                    $("#main-content").html("Sorry, but there was an error: " + xhr.status + " " + xhr.statusText);
                }
            });
            if ($(window).width() <= 768) {
                window.location.href = target; // Mengarahkan ke halaman yang di-klik
            }
        });
    });
</script>
</body>
</html>
<?php 
} 
?>
