<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pengurus";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}