<?php
session_start();
error_reporting(E_ALL);
include("../connection/connection.php");

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "CALL delete_product(?)";
    $hasil = mysqli_prepare($conn, $sql);

    if ($hasil === false) {
        die('MySQL prepare error: ' . mysqli_error($conn));
    }

    // Bind parameter
    mysqli_stmt_bind_param($hasil, "i", $id);

    // Jalankan statement
    if (mysqli_stmt_execute($hasil)) {
        echo 'success';
        header('location: dash.php');
    } else {
        echo 'error';
    }

    // Tutup statement
    mysqli_stmt_close($hasil);
    mysqli_close($conn);

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/admin.css">
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
        <div class="product-display">
            <?php
            $select = mysqli_query($conn, "SELECT * FROM produk");
            ?>
            <table class="product-display-table">
                <thead>
                    <tr>
                        <th>Img</th>
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($select)) { ?>
                        <tr>
                            <td><img src="images/<?php echo $row['img']; ?>" height="100" alt=""></td>
                            <td><?php echo $row['nama_produk']; ?></td>
                            <td><?php echo $row['deskripsi']; ?></td>
                            <td>Rp<?php echo number_format($row['harga'], 2); ?>/-</td>
                            <td>
                                <a href="edit_produk.php?edit=<?php echo $row['produk_id']; ?>" class="btn" name="edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="admin_produk.php" method="GET" style="display: inline;">
                                    <input type="hidden" name="delete" value="<?php echo $row['produk_id']; ?>">
                                    <button type="submit" class="btn delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
