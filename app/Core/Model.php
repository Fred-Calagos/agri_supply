<?php

namespace App\Core;
use PDO;
use App\Core\Database;

class Model {
    protected static $table;

    public static function all() {
        $stmt = Database::connect()->query("SELECT * FROM " . static::$table . " ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $stmt = Database::connect()->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $keys = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));
        $stmt = Database::connect()->prepare("INSERT INTO " . static::$table . " ($keys) VALUES ($values)");
        return $stmt->execute(array_values($data));
    }

    public static function update($id, $data) {
        // Build the SET clause of the SQL query dynamically
        $updates = implode('=?, ', array_keys($data)) . '=?';
        
        // Prepare the update query
        $stmt = Database::connect()->prepare("UPDATE " . static::$table . " SET $updates WHERE id = ?");
        
        // Execute the query with the data values and the ID
        return $stmt->execute([...array_values($data), $id]);
    }

    public static function delete($id) {
        $stmt = Database::connect()->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
