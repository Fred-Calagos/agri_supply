<?php

namespace App\models;

use App\Core\Model;
use App\Core\Database;

class Order extends Model
{
    protected static $table = "product_ordered";

    public static function create($data) {
        $pdo = Database::connect();
        
        $sql = "INSERT INTO " . self::$table . " (user_id, product_id, product_quantity) VALUES (:user_id, :product_id, :product_quantity)";
        
        $stmt = $pdo->prepare($sql);
        
        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':product_id' => $data['product_id'],
            ':product_quantity' => $data['product_quantity']
        ]);
    }
}
