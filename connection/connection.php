<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "MyBanana";

// Create connection
//$conn = mysqli_connect($servername, $username, $password, $database);

$conn  = new mysqli($servername, $username,  $password, $database);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>