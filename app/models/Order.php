<?php

namespace App\models;

use PDO;
use App\Core\Model;
use App\Core\Database;

class Order extends Model
{
    protected static $table = "product_ordered";


    public static function getAllOrders() {
            $pdo = Database::connect();
            $stmt = $pdo->query("SELECT 
            po.order_track, 
            GROUP_CONCAT(DISTINCT p.product_name SEPARATOR ', ') AS ordered_products,
            GROUP_CONCAT(DISTINCT p.image_path SEPARATOR ', ') AS image_paths,
            GROUP_CONCAT(DISTINCT p.selling_price SEPARATOR ', ') AS selling_prices,
            GROUP_CONCAT(DISTINCT p.stocks SEPARATOR ', ') AS stocks,
            GROUP_CONCAT(DISTINCT p.product_description SEPARATOR ' | ') AS product_descriptions,
            GROUP_CONCAT(DISTINCT pc.product_category SEPARATOR ', ') AS product_categories,
            GROUP_CONCAT(DISTINCT os.order_status) AS order_statuses,
            MAX(CONCAT(u.firstname, ' ', u.lastname)) AS full_name, -- Using MAX() to avoid GROUP BY issues
            MAX(po.ordered_date) AS ordered_date -- Using MAX() to select the latest order date
        FROM " . self::$table . " po 
        JOIN products p ON po.product_id = p.id
        JOIN product_category pc ON p.product_category_id = pc.id
        JOIN order_status os ON po.order_status = os.id
        JOIN users u ON po.user_id = u.id
        WHERE u.role = 'User'
        GROUP BY po.order_track
        ORDER BY ordered_date ASC
    ");


        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch results as an associative array
    }
    
    public static function create($data) {
        $pdo = Database::connect();
        
        $sql = "INSERT INTO " . self::$table . " (user_id, product_id, product_quantity, order_status, order_track) 
                VALUES (:user_id, :product_id, :product_quantity, :order_status, :order_track)";
        
        $stmt = $pdo->prepare($sql);
        
        if (!$stmt->execute([
            ':user_id' => $data['user_id'],
            ':product_id' => $data['product_id'],
            ':product_quantity' => $data['product_quantity'],
            ':order_status' => $data['order_status'],
            ':order_track' => $data['order_track']
        ])) {
            error_log("Database Insert Error: " . implode(", ", $stmt->errorInfo())); // Log SQL error
            return false;
        }
    
        return true;
    }
    
    
    public static function customerOrder($user_id){
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT po.*, p.product_name, p.image_path, p.shipping_fee, p.stocks, p.product_description, p.selling_price, pc.product_category FROM " 
            . self::$table . " po
            JOIN products p ON po.product_id = p.id
            JOIN product_category pc ON p.product_category_id = pc.id
            WHERE po.user_id = ? ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
    }

    public static function getOrderByStatus($status){
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM " 
            . self::$table . "
            WHERE order_status = ? ");
        $stmt->execute([$status]);
        return $stmt->fetchAll(mode: PDO::FETCH_ASSOC);
    }

    public static function getAllOrdersByTrack($orderTrack = null) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT po.*, po.order_status as poStat,
            p.product_name, p.image_path, p.shipping_fee, p.stocks, p.product_description, p.selling_price, 
            pc.product_category,
            os.order_status as orderStatName,
            CONCAT(u.firstname, ' ', u.lastname) as fullName,
            u.prov, u.reg, u.citymun, u.brgy, u.contact, u.email  -- Add user address and email
            
            FROM " . self::$table . " po
            
            JOIN products p ON po.product_id = p.id
            JOIN product_category pc ON p.product_category_id = pc.id
            JOIN order_status os ON po.order_status = os.id
            JOIN users u ON po.user_id = u.id
    
            WHERE po.order_track = ?");
        
        $stmt->execute([$orderTrack]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function updateByTrack($orderTrack, $data) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("UPDATE product_ordered SET order_status = ? WHERE order_track = ?");
        $stmt->execute([$data['order_status'], $orderTrack]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function findTrack($trackNumber) {
        $stmt = Database::connect()->prepare("SELECT * FROM " . static::$table . " WHERE order_track = ?");
        $stmt->execute([$trackNumber]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function totalOrders()
        {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("
                SELECT COUNT(*) as total 
                FROM " . self::$table . " 
                WHERE order_status = (SELECT id FROM order_status WHERE order_status = 'Received')
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0; // Return 0 if no result found
        }
        
    public static function pendingOrders()
        {
            $pdo = Database::connect();
            $stmt = $pdo->prepare("
                SELECT COUNT(*) as total 
                FROM " . self::$table . " 
                WHERE order_status = (SELECT id FROM order_status WHERE id = 1)
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0; // Return 0 if no result found
        }
        
    public static function OrderReport(){
            $pdo = Database::connect();
            $stmt = $pdo->prepare("SELECT po.*, 
                p.product_name,p.shipping_fee, p.stocks, p.product_description, p.selling_price, p.cost_price, p.profit_margin,
                pc.product_category
                FROM " . self::$table . " po
                JOIN products p ON po.product_id = p.id
                JOIN product_category pc ON p.product_category_id = pc.id
                ORDER BY po.ordered_date ASC
            ");
            
            $stmt->execute(); // Execute the query before fetching results
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch results as an associative array
    }
    
    public static function getProductSales($year = null, $category = null) {
            $pdo = Database::connect();
        
            $sql = "SELECT po.product_id, p.product_name, 
                           SUM(po.product_quantity) as total_quantity, 
                           SUM(po.product_quantity * p.selling_price) as total_sales
                    FROM " . self::$table . " po
                    JOIN products p ON po.product_id = p.id";
        
            $conditions = ["po.order_status = 4"]; // ✅ Default condition
            $params = [];
        
            if ($year) {
                $conditions[] = "YEAR(po.ordered_date) = :year";
                $params['year'] = $year;
            }
            if ($category) {
                $conditions[] = "p.product_category_id = :category";
                $params['category'] = $category;
            }
        
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
            
            $sql .= " GROUP BY po.product_id
                      ORDER BY total_sales DESC";
        
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        
    public static function soldProducts($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("
            SELECT 
                po.product_id, 
                p.product_name, 
                SUM(po.product_quantity) AS total_sold
            FROM " . self::$table . " po
            JOIN products p ON po.product_id = p.id
            WHERE po.order_status = 4 AND po.product_id = :id
            GROUP BY po.product_id, p.product_name
            ORDER BY total_sold DESC
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sold'] ?? 0; // Return 0 if no result found
    }
 
    public static function totalSalesByMonth()
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("
            SELECT 
                DATE_FORMAT(po.ordered_date, '%Y-%m') AS month,
                pc.product_category,
                SUM(p.selling_price * po.product_quantity) AS total_sales
            FROM " . self::$table . " po
            JOIN products p ON po.product_id = p.id
            JOIN product_category pc ON p.product_category_id = pc.id
            WHERE po.order_status = 4
            GROUP BY month, pc.product_category
            ORDER BY month ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function totalSalesThisMonth()
    {
        $pdo = Database::connect();
        $query = "
            SELECT COALESCE(SUM(p.selling_price * po.product_quantity), 0) AS total_sales
            FROM " . self::$table . " po
            JOIN products p ON po.product_id = p.id
            WHERE po.order_status = 4
            AND DATE_FORMAT(po.ordered_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
        ";
    
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn(); // Returns a single number
    }
    
    

public static function totalSalesToday()
{
    $pdo = Database::connect();
    $query = "
        SELECT SUM(p.selling_price * po.product_quantity) AS total_sales
        FROM " . self::$table . " po
        JOIN products p ON po.product_id = p.id
        WHERE po.order_status = 4 
        AND DATE(po.ordered_date) = CURDATE()
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn() ?: 0; // Returns 0 if null
}

public static function totalSalesYearly()
{
    $pdo = Database::connect();
    $query = "
        SELECT SUM(p.selling_price * po.product_quantity) AS total_sales
        FROM " . self::$table . " po
        JOIN products p ON po.product_id = p.id
        WHERE po.order_status = 4 
        AND YEAR(po.ordered_date) = YEAR(CURDATE())
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn() ?: 0; // Returns 0 if null
}

}
