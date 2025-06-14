<?php
$host = 'localhost'; 
$db   = 'emendoza-rosales_db';     //DB name
$user = 'emendoza-rosales';          // DB username
$pass = 'pFojveTj';          // secret sauce

try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage()); 
    die("Connection failed.");
}