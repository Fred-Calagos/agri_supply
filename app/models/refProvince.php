<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class refProvince extends Model
{
    protected static $table = "refprovince";

    public static function getProvincesByRegion($regionId){
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM " . self::$table . " WHERE regCode = ?");
        $stmt->execute([$regionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
