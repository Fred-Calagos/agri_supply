<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Cart extends Model
{
 protected static $table = "product_cart";

 public static function countItems($user_id) {
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT COUNT(id) as total FROM product_cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(mode: PDO::FETCH_ASSOC);
    return $row['total'] ?? 0; // Return count, or 0 if no records found
}
public static function totalItems($user_id) {
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT pc.*, p.product_name, p.image_path, p.shipping_fee, p.stocks , p.product_description, p.selling_price FROM " 
    . self::$table . " pc
    JOIN products p ON pc.product_id = p.id
    WHERE user_id = ? ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
}
}
