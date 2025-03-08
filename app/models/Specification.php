<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Specification extends Model
{
    protected static $table = "specification";

    
    public static function all() {
        $stmt = Database::connect()->query("SELECT * FROM " . static::$table . " ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function searchSpecification($query)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM ". self::$table ." WHERE name LIKE :query LIMIT 10");
        $stmt->execute(['query' => "%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
