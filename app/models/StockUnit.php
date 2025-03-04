<?php

namespace App\models;

use App\Core\Database;
use App\Core\Model;
use PDO;

class StockUnit extends Model
{
 protected static $table = 'stock_units';

 public static function searchStockUnits($query)
 {
     $pdo = Database::connect();
     $stmt = $pdo->prepare("SELECT name FROM ". self::$table ." WHERE name LIKE :query LIMIT 10");
     $stmt->execute(['query' => "%$query%"]);
     return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
}
