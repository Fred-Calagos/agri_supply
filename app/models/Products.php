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
            SELECT p.*, pc.product_category, ps.product_status
            FROM products p
            JOIN product_category pc ON p.product_category_id = pc.id
            JOIN product_status ps ON p.product_status_id = ps.id
            ORDER BY p.product_name ASC
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
    public static function getByProductStatus($productStatus) {
        $stmt = Database::connect()->prepare("
            SELECT p.*, ps.product_status 
            FROM products p
            JOIN product_status ps ON p.product_status_id = ps.id
            WHERE ps.product_status = :product_status
            ORDER BY p.product_name ASC
        ");
        $stmt->execute(['product_status' => $productStatus]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function search($keyword)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_name LIKE ?");
        $stmt->execute(["%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function searchProducts($query)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT id, product_name FROM products WHERE product_name LIKE :query LIMIT 10");
        $stmt->execute(['query' => "%$query%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function searchByCategory($category, $keyword)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE product_category_id = ? AND product_name LIKE ?");
        $stmt->execute([$category, "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getProductCategory($category){
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE product_category_id = ?");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function totalProducts()
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM products");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0; // Return 0 if no result found
    }
    public static function getLastInsertId() {
        $pdo = Database::connect();
        return $pdo->lastInsertId();
    }
    
    public static function getProductSpecification($productId) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT p.*, ps.value, s.name FROM ". self::$table ." p 
        JOIN product_specification ps ON p.id = ps.product_id
        JOIN specification s ON ps.specification_id = s.id
        WHERE ps.product_id = ?");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
