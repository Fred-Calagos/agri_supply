<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Brand extends Model
{
    protected static $table = 'brands';

    public static function displayBrandReceipt() {
        $stmt = Database::connect()->query("SELECT brand_name, contact, email FROM " . static::$table . " LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch one row instead of all
    }
    
}
