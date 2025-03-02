<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class ProductCategory extends Model
{
    protected static $table = 'product_category';
    public static function getCategoryName($id) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT product_category FROM " . self::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        return $category ? $category['product_category'] : null;
    }
}
