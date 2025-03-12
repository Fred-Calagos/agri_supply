<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class ProductSpecifications extends Model
{
    protected static $table = 'product_specification';
    public static function getProductSpecifications($productId)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("
            SELECT ps.*, s.name FROM ". self::$table ." ps
            JOIN specification s ON ps.specification_id = s.id
            JOIN products p ON ps.product_id = p.id
            WHERE ps.product_id = :product_id
        ");
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns an array of specifications
    }

}
