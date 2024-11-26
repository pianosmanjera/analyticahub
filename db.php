<?php
$host = 'sql12.freesqldatabase.com';
$db = 'sql12747413';
$user = 'sql12747413'; // Change this if your MySQL username is different
$pass = '14zs7L8ZYH'; // Add your password if you set one for MySQL

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>