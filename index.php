<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connection.php");
error_reporting(0);
session_start();
if(empty($_SESSION["user_id"]))
{
	header('location:login.php');
}
else
{
  ?>
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Banana HEHE</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,400&display=swap"
      rel="stylesheet"
    />
    <!-- Swiper CSS -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />
    <!-- cdn icon link  -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
      <!-- Google Material Icons -->
      <link
      href="https://fonts.googleapis.com/css2?family=Material+Icons"
      rel="stylesheet"
    />
    <!-- custom css file  -->
    <link rel="stylesheet" href="css/style.css" />
  </head>

  <body>
    <!-- Header Start  -->
    <header class="header">
      <div class="logoContent">
        <a href="#" class="logo"><img src="images/pis.png" alt="" /></a>
        <h1 class="logoName">Banana<span>Hehe</span></h1>
      </div>

      <nav class="navbar">
        <a href="#home">Home</a>
        <a href="#product">Produk</a>
        <a href="#blogs">Best Seller</a>
        <a href="#review">Review</a>
        <a href="#lokasi">Lokasi</a>
      </nav>

      <div class="icon">
        <!-- Search Icon -->
        <div class="search-icon">
          <i class="fas fa-search"></i>
        </div>

        <!-- Search Form -->
        <div class="search-content">
          <input type="search" id="searchInput" placeholder="Search..." />
          <button onclick="searchProducts()">
            <i class="fas fa-search"></i>
          </button>
        </div>

        <!-- Cart Container -->
        <div class="cart-container">
          <i class="fas fa-shopping-cart" id="cart"></i>
          <span class="cart-count">0</span>
        </div>

        <!-- User Profile -->
        <div class="user-container">
          <i class="fas fa-user" id="user"></i>
          <ul class="user-menu" id="user-menu">
            <li><a href="user.php"><i class="material-icons">person</i>Profil</a></li>
            <li><a href="logout.php"><i class="material-icons">logout</i>Logout</a></li>
           
          </ul>
        </div>

        <!-- Menu Bar -->
        <i class="fas fa-bars" id="menu-bar"> </i>
      </div>
    </header>

    <!-- Sidebar Menu -->
    <div id="mySidebar" class="sidebar">
      <a href="#home">Home</a>
      <a href="#product">Produk</a>
      <a href="#blogs">Best Seller</a>
      <a href="#review">Review</a>
      <a href="#lokasi">Lokasi</a>
    </div>
    <!-- Header End -->

    <!-- Home Start  -->
    <section class="home" id="home">
      <div class="homeContent">
        <div class="text">
          <h2>Hehe dulu dong!</h2>
          <p>
            Selamat datang di BananaHehe! Nikmati kelezatan alami dengan produk
            olahan pisang terbaik dari BananaHehe.
          </p>
        </div>
        <div class="home-btn">
          <a href="#product"><button>Beli Sekarang</button></a>
        </div>
      </div>
    </section>

    <!-- Home End  -->

    <!-- Produk Start  -->
<section class="product" id="product">
  <div class="heading">
    <h2>Produk<span>Kami</span></h2>
  </div>
  <div class="menu-row">
    <!-- <?php
    // Langkah 2: Query untuk mengambil data produk
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);

    // Langkah 3: Iterasi dan tampilkan hasil query
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        ?>
        <div class="product-item">
          <div class="img">
            <img src="<?= $row['img'] ?>" alt="<?= $row['nama_produk'] ?>" />
          </div>
          <div class="product-content">
            <h3><?= $row['nama_produk'] ?></h3>
            <p><?= $row['deskripsi'] ?></p>
            <span class="price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></span>
            <form method="post" action="cart.php">
              <input type="hidden" name="product_id" value="<?= $row['produk_id'] ?>">
              <button type="submit" name="order_now">Order Now</button>
            </form>
          </div>
        </div>
        <?php
      }
    } else {
      echo "Tidak ada produk yang ditemukan.";
    }

    // Tutup koneksi database
    $conn->close();
    ?> -->
  </div>
</section>
<!-- Produk End  -->


    <!-- Best Produk Start  -->
    <!-- Swiper slider -->
    <section class="blogs" id="blogs">
      <div class="swiper-container blogs-row">
        <div class="swiper-wrapper">
          <!-- Slide 1 -->
          <div class="swiper-slide box">
            <div class="img">
              <img src="images/paipis.jpg" alt="" />
            </div>
            <div class="content">
              <h3>Banana Cheese Pie</h3>
              <p>
                Banana cheese pie adalah kue pie yang menggabungkan dua bahan
                utama yaitu pisang dan keju. Kulit pai yang renyah sebagai
                dasar, diisi dengan campuran pisang yang telah dimasak bersama
                dengan keju untuk memberikan rasa yang lezat. Kombinasi antara
                manisnya pisang yang lembut dan gurihnya keju yang meleleh
                membuat banana cheese pie menjadi camilan yang menggoda dan
                favorit untuk dinikmati.
              </p>
              <p>
                Banana cheese pie adalah pilihan yang sempurna untuk dinikmati
                bersama secangkir kopi atau teh juga sebagai camilan lezat kapan
                saja selama hari. Rasanya yang unik dan menggoda membuatnya
                menjadi favorit bagi banyak orang yang menyukai kombinasi manis
                dan gurih dalam sepotong pie.
              </p>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="swiper-slide box">
            <div class="img">
              <img src="images/chesban.jpg" alt="" />
            </div>
            <div class="content">
              <h3>Pisang Cokju</h3>
              <p>
                Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                Eligendi dolorum voluptatum corporis accusamus aperiam fugiat
                tempora blanditiis labore dolor aliquid maxime nobis laborum sed
                soluta voluptatibus aspernatur natus, dicta quisquam.
              </p>
              <p>
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Totam
                ab ullam reiciendis sint eaque at.
              </p>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="swiper-slide box">
            <div class="img">
              <img src="images/kerpis.jpg" alt="" />
            </div>
            <div class="content">
              <h3>Banana Chips</h3>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus,
                nobis saepe itaque deleniti dolorum explicabo voluptatum sint
                atque aspernatur nemo!
              </p>
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima
                aut laborum exercitationem facilis, doloribus perferendis!
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Best Produk End  -->

    <!-- Tentang Kami Start  -->
    <section class="About">
      <div class="box">
        <h3>Tentang Kami</h3>
        <p>
          Biar pisang bicara atas nama kelezatan! Dengan produk pisang Banana
          Hehe, kami berkomitmen untuk memberikan pengalaman berbelanja yang tak
          terlupakan dan rasa yang tiada duanya
        </p>
        <a href="tentangkami.html"><button class="SeeMore">See More</button></a>
      </div>
    </section>
    <!-- Tentang Kami End  -->

    <!-- Review Start -->
<section class="review" id="review">
  <div class="heading">
    <h2>Client<span>Review</span></h2>
  </div>
  <div class="swiper-container review-row">
    <div class="swiper-wrapper">
      <?php
      session_start();
      error_reporting(0);
      include "connection/connection.php";

      // Menampilkan review dari database
      $sql = "SELECT r.isi, u.username, u.pic FROM review r JOIN users u ON u.user_id = r.user_id";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="swiper-slide box">';
              echo '<div class="client-review">';
              echo '<p>' . htmlspecialchars($row['isi']) . '</p>';
              echo '</div>';
              echo '<div class="client-info">';
              echo '<div class="img">';
              echo '<img src="images/' . htmlspecialchars($row['pic']) . '" alt="" />';
              echo '</div>';
              echo '<div class="clientDetailed">';
              echo '<h3>' . htmlspecialchars($row['username']) . '</h3>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
          }
      } else {
          echo '<p>No reviews found.</p>';
      }

      mysqli_close($conn);
      ?>
    </div>
  </div>
  <div class="review-form">
    <h2>Masukkan review anda</h2>
    <form method="POST" action="review.php">
      <textarea id="review" name="review" rows="4" required></textarea>
      <button type="submit">Submit Review</button>
    </form>
  </div>
</section>
<!-- Review End -->

    <!-- Kontak Start -->
    <section id="lokasi" class="lokasi">
      <div class="heading">
        <h2>Lokasi<span>Kami</span></h2>
      </div>
      <div class="row">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1175.3186861011561!2d110.40856103048355!3d-7.759560359422695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversitas%20Amikom%20Yogyakarta!5e0!3m2!1sid!2sid!4v1714567942948!5m2!1sid!2sid"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          class="map"
        ></iframe>
      </div>
    </section>
    <!-- Kontak End -->

    <!-- Footer Start -->
    <footer class="footer" id="contact">
      <div class="logo">
        <h2>Banana<span>Hehe</span></h2>
      </div>
      <div class="share">
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="#" class="fab fa-twitter"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-whatsapp"></a>
      </div>
      <div class="content">
        <a href="#">Home</a>
        <a href="#">Produk</a>
        <a href="#">Best Seller</a>
        <a href="#">Review</a>
        <a href="#">Lokasi</a>
      </div>
      <div class="credit">@ 2024 Banana Hehe. All rights reserved.</div>
    </footer>
    <!-- Footer End -->

      <!-- List Cart Start -->
    <form class="cart" method="POST" action="submit_cart.php">
      <ul class="listCart"></ul>
      <div class="checkOut">
        <div class="total">0</div>
        <!-- <div class="buy">Beli</div> -->
        <button class="buy" type="submit">Check Out</button>
      </div>
    </form>
    <!-- List Cart End -->

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Cart End -->
    <script src="script.js"></script>
  </body>
</html>
<?php
}
?>