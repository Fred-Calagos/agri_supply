<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class refCityMun extends Model
{
 protected static $table = "refcitymun";

 public static function getCitymunByProvince($province){
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE provCode = ?");
    $stmt->execute([$province]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
}
