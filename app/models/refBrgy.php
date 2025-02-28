<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class refBrgy extends Model
{
 protected static $table = "refbrgy";
 public static function getBrgyByCityMun($citymunId){
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE citymunCode = ?");
    $stmt->execute([$citymunId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
