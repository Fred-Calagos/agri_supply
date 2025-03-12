<?php

namespace App\models;

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
    public static function getUserAccount($user)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT u.*, CONCAT(u.firstname,' ', u.lastname) as name, CONCAT(rr.regDesc,', ', rp.provDesc,', ', rc.citymunDesc,', ', rb.brgyDesc) AS address FROM 
        " . self::$table . " u
        JOIN refregion rr ON u.reg = rr.regCode
        JOIN refprovince rp ON u.prov = rp.provCode
        JOIN refcitymun rc ON u.citymun = rc.citymunCode
        JOIN refbrgy rb  ON u.brgy = rb.brgyCode
        WHERE u.id = ?");
        $stmt->execute([$user]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch only one record
    }
    
}
