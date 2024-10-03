<?php
session_start();
include("../connection/connection.php");

if (empty($_SESSION["adm_id"])) {
    header('location:index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>CRUD Dashboard</title>
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet" />
    <style>
        .top-navbar, .xp-topbar, .xp-profilebar {
            width: 100%;
        }
        .xp-profilebar nav {
            justify-content: flex-end;
        }
        .xp-menubar {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <div id="sidebar">
            <div class="sidebar-header">
                <h3>
                    <img src="images/pis.png" class="img-fluid" alt="Logo" /><span>BananaHehe</span>
                </h3>
                
            </div>
            <ul class="list-unstyled component m-0">
                <li class="dropdown">
                    <a href="#productSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">inventory_2</i>Products
                    </a>
                    <ul class="collapse list-unstyled menu" id="productSubmenu">
                        <li><a href="#" class="load-content" data-target="admin_produk.php">All Products</a></li>
                        <li><a href="#" class="load-content" data-target="add_produk.php">Add Product</a></li>
                    </ul>
                </li>
                <li><a href="#" class="load-content" data-target="show_user.php"><i class="material-icons">person</i>User</a></li>
                <li><a href="#"class="load-content" data-target="admin_review.php"><i class="material-icons">rate_review</i>Review</a></li>
                <li><a href="#" class="load-content" data-target="admin_orders.php"><i class="material-icons">shopping_cart</i>Order</a></li>
                <li><a href="logout.php"><i class="material-icons">logout</i>Logout</a></li>
            </ul>
        </div>
        <div id="content">  
            <div id="main-content">
                <div class="load-content" data-target="main-content.php"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- <script src="/js/custom.js"></script> -->
    <script type="text/javascript">
        $(document).ready(function () {
            // Load initial content from main-content.php into .load-content div
            $('#main-content .load-content').load('main-content.php');
            $("#sidebarCollapse").on("click", function () {
                $("#sidebar").toggleClass("active");
                $("#content").toggleClass("active");
            });

            $(".more-button, .body-overlay").on("click", function () {
                $("#sidebar, .body-overlay").toggleClass("show-nav");
            });

            $(".load-content").on("click", function (e) {
                e.preventDefault();
                var target = $(this).data("target");
                $("#main-content").load(target, function (response, status, xhr) {
                    if (status === "error") {
                        $("#main-content").html("Sorry, but there was an error: " + xhr.status + " " + xhr.statusText);
                    }
                });
            });
        });
    </script>
    
</body>
</html>
