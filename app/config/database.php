<?php

// $host = 'localhost';
// $db = 'bsab_db';
// $user = 'root';
// $pass = 'root';
//for website database
$host = 'sql102.infinityfree.com';
$db = 'if0_38379224_agti_supply';
$user = 'if0_38379224';
$pass = 'agriSupply2025 ';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

return $pdo;
