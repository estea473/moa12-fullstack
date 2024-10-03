<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/user.css">
</head>
<body>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>User Profil</th>
                <th>Username</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No Telp</th>
                <!-- <th>Password</th> -->
                <th>Alamat</th>
                <th>Tanggal Join</th>
            </tr>
        </thead>
        <tbody>
        <?php
        session_start();
        error_reporting(E_ALL);
        include("../connection/connection.php");

        $sql = "SELECT pic, username, CONCAT(f_name, ' ', l_name) AS fullname, email, phone, password, address, date FROM users ORDER BY username ASC";
        $hasil = mysqli_query($conn, $sql);
        $no = 1;
        while ($data = mysqli_fetch_array($hasil)){
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><img src="../images/<?php echo $data['pic']; ?>" alt="User Profile"></td>
                <td><?php echo $data['username']; ?></td> 
                <td clas=nama><?php echo $data['fullname']; ?></td>
                <td class="email"><?php echo $data['email']; ?></td> 
                <td class="no"><?php echo $data['phone']; ?></td>
                <!-- <td><?php echo substr($data['password'], 0, 10); ?></td> -->
                <td class="alamat"><?php echo $data['address']; ?></td>
                <td class="tgl" style="font-size: 0.8rem;"><?php echo $data['date']; ?></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</body>
<style>

</style>
</html>
