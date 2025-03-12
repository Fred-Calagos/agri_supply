<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Batch extends Model
{
    protected static $table = 'product_batch';

    public static function getProductBatches($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT pb.*, p.product_name, ps.product_status FROM " . self::$table . " pb
        JOIN product_status ps ON pb.stock_category = ps.id
        JOIN products p ON pb.product_id = p.id
        WHERE pb.product_id = ?
        ORDER BY pb.created_at ASC
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public static function getBatch($id) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("
            SELECT pb.*, 
                   p.product_name, p.image_path, p.product_description,
                   ps.product_status,
                   pc.product_category
            FROM " . self::$table . " pb
            JOIN products p ON pb.product_id = p.id
            JOIN product_status ps ON pb.stock_category = ps.id
            JOIN product_category pc ON p.product_category_id = pc.id
            WHERE pb.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns a single product batch
    }
    public static function getProductSpecification($id) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT pb.*, ps.value, s.name FROM ". self::$table ." pb
        JOIN products p ON pb.product_id = p.id
        JOIN product_specification ps ON p.id = ps.product_id
        JOIN specification s ON ps.specification_id = s.id
        WHERE pb.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    public static function getProductFirstBatch() {
        $stmt = Database::connect()->query("
            WITH ranked_batches AS (
                SELECT 
                    pb.*, p.image_path, p.product_name,
                    pc.product_category, ps.product_status,
                    ROW_NUMBER() OVER (PARTITION BY pb.product_id ORDER BY pb.id ASC) AS rn
                FROM product_batch pb
                JOIN products p ON pb.product_id = p.id
                JOIN product_status ps ON pb.stock_category = ps.id
                JOIN product_category pc ON p.product_category_id = pc.id
                WHERE pb.stocks > 0
            )
            SELECT * FROM ranked_batches WHERE rn = 1
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
