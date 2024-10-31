<?php
$host = 'localhost';
$db = 'auth_db';
$user = 'root';
$pass = ''; 

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>