<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Cart extends Model
{
    protected static $table = "product_cart";

    public static function countItems($user_id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT COUNT(id) as total FROM product_cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(mode: PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public static function totalItems($user_id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT pc.*, p.product_name, p.image_path, p.shipping_fee, p.stocks, p.product_description, p.selling_price FROM " 
            . self::$table . " pc
            JOIN products p ON pc.product_id = p.id
            WHERE user_id = ? ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
    }

    public static function whereIn($column, $values)
    {
        if (empty($values)) return []; // Avoid empty queries

        $pdo = Database::connect();
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE $column IN ($placeholders)");
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteWhereIn($column, $values)
    {
        if (empty($values)) return false; // Avoid empty delete

        $pdo = Database::connect();
        $placeholders = implode(',', array_fill(0, count($values), '?'));
        $stmt = $pdo->prepare("DELETE FROM " . self::$table . " WHERE $column IN ($placeholders)");
        return $stmt->execute($values);
    }

    //  Updated these methods to match the static method pattern
    public static function getItemsByIds($ids)
    {
        if (empty($ids)) return []; // Avoid empty queries

        $pdo = Database::connect();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteItemsByIds($ids)
    {
        if (empty($ids)) return false; // Avoid empty delete

        $pdo = Database::connect();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("DELETE FROM " . self::$table . " WHERE id IN ($placeholders)");
        return $stmt->execute($ids);
    }
}
