<?php
// config/db.php
$host     = "localhost";
$username = "root";     // Default XAMPP username
$password = "";         // Default XAMPP password
$dbname   = "inventory"; // Updated database name

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>

