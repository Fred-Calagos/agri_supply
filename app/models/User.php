<?php

namespace App\Models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class User extends Model {

    protected static $table = "users";
    private $db;

    public function __construct() {
        $this->db = new PDO("mysql:host=localhost;dbname=bsab_db", "root", "root");
    }
    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function totalUser()
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM " . self::$table . " WHERE role ='User'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0; // Return 0 if no result found
    }
}
