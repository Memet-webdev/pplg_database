<?php
$host = "localhost"; // Ganti sesuai host database kamu
$user = "root";      // Ganti sesuai username database kamu
$pass = "";          // Ganti sesuai password database kamu
$dbname = "user_db"; // Ganti sesuai nama database kamu

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
