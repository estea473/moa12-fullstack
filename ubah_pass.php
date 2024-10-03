<!-- <?php
session_start();
include "connection/connection.php";

$userid = $_SESSION["user_id"];
$sql = "SELECT password FROM users WHERE user_id = '$userid'";
$hasil = mysqli_query($conn, $sql);

if (!$hasil) {
  die("Query error: " . mysqli_error($conn));
}

if (mysqli_num_rows($hasil) > 0) {
  // Output data dari setiap baris
  while ($row = mysqli_fetch_assoc($hasil)) {
      $pass = $row['password'];
  }
} else {
  echo "0 results";
}

$conn->close();
?> -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Password</title>
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,400&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="edit-profile.css" />
  </head>
  <body>
    <div class="edit-container">
      <!-- <h2>Edit Profile</h2> -->
      <form action="ubah_pass_action.php" method="POST">
        <div class="edit">
          <label for="password">Password:</label>
          <input type="password"  name="password" placeholder="Masukkan password baru"/>
          <!-- <?php echo htmlspecialchars($pass); ?> -->
          <input type="password" name="conf_pass" placeholder="Masukkan kembali password"/>
        </div>
        <div class="btn">
          <input type="submit" name="simpan" value="SIMPAN" />
          <input type="button" value="CANCEL" onclick="window.location.href='user.php'" />
        </div>
      </form>
    </div>
  </body>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Poppins, sans-serif;
      background-color: white;
      display: flex;
      height: 100vh;
      background-color: #1e1e1e;
      align-items: center;
      margin: 0;
    }
    .edit-container {
      margin-left: 3rem;
      width: 50rem;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      display: flex;
    }
  
    form .edit {
      display: flex;
      flex-direction: column;
    }
    form .edit label {
      margin-bottom: 10px;
      color: white;
      font-size: 20px;
    }
    .btn{
      display: flex;
      flex-direction: row;
    }
    input[name="username"]{
      background-color: whitesmoke;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 3px;
      font-size: 16px;
      margin-bottom: 15px;
      width: 30rem;
    }
    input[type="submit"], 
    input[type="button"] {
      background-color: #ffc700;
      color: black;
      font-size: 16px;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
      margin-right: 10px;
      transition: background-color 0.3s ease;
      width: 10rem;
    }
    input[type="submit"]:hover, 
    input[type="button"]:hover {
      background-color: black;
      color: white;
    }
    @media screen and (max-width: 768px) {
      *{
        font-size: 60%;
      }
        .edit-container {
            width: 90%;
        }

    }
  </style>
</html>
