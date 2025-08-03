<?php
$hostName = 'localhost';
$dbName = 'projet_x';
$userName = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$hostName;dbname=$dbName;charset=utf8mb4", $userName, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}