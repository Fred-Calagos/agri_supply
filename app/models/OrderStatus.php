<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class OrderStatus extends Model
{
    protected static $table = "order_status";

    public static function getPendingId() {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT id FROM " . self::$table . " WHERE id = 1 LIMIT 1");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['id'] : null; // Return only the ID
    }
    
}
