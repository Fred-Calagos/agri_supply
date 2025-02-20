<?php

namespace App\Core;
use PDO;
use PDOException;

class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            try {
                self::$pdo = new PDO("mysql:host=localhost;dbname=bsab_db", "root", "root");
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database error: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
