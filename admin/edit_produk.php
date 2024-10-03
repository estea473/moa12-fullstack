<?php
session_start();
error_reporting(E_ALL);
include("../connection/connection.php");

if (isset($_POST['update_product'])) {
   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_description = $_POST['product_description'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'images/' . $product_image;

   if (empty($product_name) || empty($product_price)) {
      $message[] = 'Please fill out all fields';
   } else {
      // Check if product name already exists
      $check_query = "SELECT * FROM produk WHERE nama_produk = '$product_name' AND produk_id != '$product_id'";
      $result = mysqli_query($conn, $check_query);
      if (mysqli_num_rows($result) > 0) {
         $message[] = 'Product name already exists';
      } else {
         if (empty($product_image)) {
            $update = "UPDATE produk SET nama_produk='$product_name', deskripsi='$product_description', harga='$product_price' WHERE produk_id='$product_id'";
         } else {
            $update = "UPDATE produk SET nama_produk='$product_name', deskripsi='$product_description', harga='$product_price', img='$product_image' WHERE produk_id='$product_id'";
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
         }
         $upload = mysqli_query($conn, $update);
         if ($upload) {
            $message[] = 'Product updated successfully';
            header('location:dash.php');
         } else {
            $message[] = 'Could not update the product';
         }
      }
   }
}

if (isset($_GET['edit'])) {
   $edit_id = $_GET['edit'];
   $edit_query = mysqli_query($conn, "SELECT * FROM produk WHERE produk_id = $edit_id");
   if (mysqli_num_rows($edit_query) > 0) {
      $fetch_edit = mysqli_fetch_assoc($edit_query);
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($message)) {
            foreach ($message as $msg) {
                echo '<span class="message">' . $msg . '</span>';
            }
        }
        ?>
        <form action="edit_produk.php" method="post" enctype="multipart/form-data">
            <h3>Update product</h3>
            <input type="hidden" name="product_id" value="<?php echo $fetch_edit['produk_id']; ?>">
            <input type="text" placeholder="Enter product name" name="product_name" class="box" value="<?php echo $fetch_edit['nama_produk']; ?>">
            <input type="text" placeholder="Enter product description" name="product_description" class="box" value="<?php echo $fetch_edit['deskripsi']; ?>">
            <input type="number" placeholder="Enter product price" name="product_price" class="box" value="<?php echo $fetch_edit['harga']; ?>">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
           <div class="btn_container">
            <input type="submit" class="btnpro" name="update_product" value="Update Product">
           <a href="dash.php" class="btndel">Cancel</a>
         </div> 
            
        </form>
    </div>
</body>
</html>
