<?php
session_start();
error_reporting(E_ALL);
include("../connection/connection.php");

if(isset($_POST['add_product'])){
   $product_name = $_POST['product_name'];
   $product_description = $_POST['product_description'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'images/'.$product_image;

   if(empty($product_name) || empty($product_price) || empty($product_image)){
      $message[] = 'Please fill out all fields';
      
   } else {
      // Check if product name already exists
      $check_query = "SELECT * FROM produk WHERE nama_produk = '$product_name'";
      $result = mysqli_query($conn, $check_query);
      if(mysqli_num_rows($result) > 0){
         $message[] = 'Product name already exists';
      } else {
         $insert = "INSERT INTO produk(nama_produk, deskripsi, harga, img) VALUES('$product_name', '$product_description', '$product_price', '$product_image')";
         $upload = mysqli_query($conn, $insert);
         if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            echo "<script>
                    alert('Produk berhasil ditambahkan');
                    window.location.href = 'dash.php';
                  </script>";
            // header('location:dash.php');
            exit();
         } else {
            $message[] = 'Could not add the product';
         }
      }
   }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php
   if(isset($message)){
      foreach($message as $msg){
         echo '<span class="message">'.$msg.'</span>';
      }
   }
   ?>
   <div class="container">
      <div class="admin-product-form-container">
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <h3>Add a new product</h3>
            <input type="text" placeholder="Enter product name" name="product_name" class="box">
            <input type="text" placeholder="Enter product description" name="product_description" class="box">
            <input type="number" placeholder="Enter product price" name="product_price" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
            <input type="submit" class="btnpro" name="add_product" value="Add Product">
         </form>
      </div>
   </div>
</body>
</html>