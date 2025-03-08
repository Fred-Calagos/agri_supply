<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class CategorySpecification extends Model
{
    protected static $table = "category_specification";

    public static function getSpecifications($categoryId)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT cs.*, s.name FROM " . self::$table . " cs
        JOIN specification s ON cs.specification_id = s.id
        WHERE cs.category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
