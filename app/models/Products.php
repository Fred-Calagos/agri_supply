<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Products extends Model
{
    protected static $table = 'products';

    // public static function all() {
    //     $stmt = Database::connect()->query("
    //         SELECT p.*, pc.product_category
    //         FROM products p
    //         JOIN product_category a ON p.product_category_id = pc.id
    //         ORDER BY pc.product_category ASC
    //     ");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}
