<?php
// db_connect.php - Connects to MySQL securely

$host = 'localhost';
$db   = 'internship_db'; // Your database name from Step 2
$user = 'root';        // Default XAMPP/MAMP user
$pass = '';             // Default XAMPP/MAMP password (often empty)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    // Ensures PDO throws exceptions on errors
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     // Failsafe if the connection cannot be established
     die("Database connection failed: " . $e->getMessage());
}
?>