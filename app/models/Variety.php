<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Variety extends Model
{
    protected static $table = 'variety';

    public static function searchVarieties($query)
{
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT variety_name FROM ". self::$table ." WHERE variety_name LIKE :query LIMIT 10");
    $stmt->execute(['query' => "%$query%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
