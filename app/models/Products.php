<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Products extends Model {
    protected static $table = 'products';

    // Function to get all products with category name
    public static function all() {
        $stmt = Database::connect()->query("
            SELECT p.*, pc.product_category 
            FROM products p
            JOIN product_category pc ON p.product_category_id = pc.id
            ORDER BY pc.product_category ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($id) {
        $stmt = Database::connect()->prepare("
            SELECT p.*, pc.id as category_id, pc.product_category 
            FROM products p
            JOIN product_category pc ON p.product_category_id = pc.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Function to get products by category
    public static function getByCategory($category) {
        $stmt = Database::connect()->prepare("
            SELECT p.*, pc.product_category 
            FROM products p
            JOIN product_category pc ON p.product_category_id = pc.id
            WHERE pc.product_category = :category
            ORDER BY p.product_name ASC
        ");
        $stmt->execute(['category' => $category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function search($keyword)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_name LIKE ?");
        $stmt->execute(["%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function searchByCategory($category, $keyword)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_category_id = ? AND product_name LIKE ?");
        $stmt->execute([$category, "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
