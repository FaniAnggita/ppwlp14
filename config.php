<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "inventory";

$conn = mysqli_connect($host, $user, $password, $dbname);
// Mengecek koneksi ke database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


