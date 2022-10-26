<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "capstone_2";

// PDO Connection
try {
   $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
}