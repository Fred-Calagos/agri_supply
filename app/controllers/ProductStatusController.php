<?php

namespace App\controllers;

use App\Core\Database;
use App\Core\BaseController;
use App\models\ProductStatus;

class ProductStatusController extends BaseController
{
    public function index(){
        $productStatus = ProductStatus::all();
        $data = [
            'title'=> 'Product Status',
            'productStatus' => $productStatus,
            'content' => $this->renderView('/settings/product_status', ['productStatus' => $productStatus])
        ];

        $this->view('layout/main', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the database connection
            $pdo = Database::connect();
    
            // Create the new product status using the database connection
            ProductStatus::create($_POST); // Assuming the create method in ProductStatus accepts the PDO object
    
            // Get the latest product status data using the last inserted ID
            $newProductStatus = ProductStatus::find($pdo->lastInsertId());
    
            // Return the new product status data as JSON
            echo json_encode(["status" => "success", "newProductStatus" => $newProductStatus]);
            exit;
        }
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productStat = $_POST['product_status'];
    
            // Make sure all fields are valid
            if ($id && $productStat) {
                // Update the product status
                $data = [
                    'product_status' => $productStat,
                ];
                ProductStatus::update($id, $data);
    
                // Return success response (or redirect)
                echo json_encode(['status' => 'success', 'message' => 'Product Status updated successfully.']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    }
    
    // Method to delete a product status
    public function delete($id) {
        if (!$id) {
            echo json_encode(["status" => "error", "message" => "Invalid ID."]);
            exit;
        }
    
        // Debugging: Log the ID before deletion
        error_log("Attempting to delete Product Status with ID: " . $id);
    
        $deleted = ProductStatus::delete($id);
    
        if ($deleted) {
            echo json_encode(["status" => "success", "message" => "Product Status deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete record."]);
        }
        exit;
    }
    
}
