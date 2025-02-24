<?php

namespace App\controllers;

use App\Core\Database;
use App\models\OrderStatus;
use App\Core\BaseController;

class OrderStatusController extends BaseController
{
    public function __construct()
    {
        checkAdmin(); // Ensure only admins can access this controller
    }
    public function index() {
        $orderStatus = OrderStatus::all();  
        $data = [
            'title' => 'Order Status',
            'orderStatus'=> $orderStatus,
            'content' => $this->renderView('/settings/order_status', ['orderStatus' => $orderStatus])
        ];

        $this->view('layout/main', $data);
    }
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the database connection
            $pdo = Database::connect();

            // Create the new academic year using the database connection
            OrderStatus::create($_POST); // Assuming the create method in AcademicYear accepts the PDO object

            // Get the latest academic year data using the last inserted ID
            $newOrderStatus = OrderStatus::find($pdo->lastInsertId());

            // Return the new academic year data as JSON
            echo json_encode(["status" => "success", "newOrderStatus" => $newOrderStatus]);
            exit;
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderStat = $_POST['order_status'];
    
            // Make sure all fields are valid
            if ($id && $orderStat) {
                // Update the academic year
                $data = [
                    'order_status' => $orderStat,
                ];
                OrderStatus::update($id, $data);
    
                // Return success response (or redirect)
                echo json_encode(['status' => 'success', 'message' => 'Order Status updated successfully.']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        }
    }

        // Method to delete an academic year
        public function delete($id) {
            if (!$id) {
                echo json_encode(["status" => "error", "message" => "Invalid ID."]);
                exit;
            }
        
            // Debugging: Log the ID before deletion
            error_log("Attempting to delete Academic Year with ID: " . $id);
        
            $deleted = OrderStatus::delete($id);
        
            if ($deleted) {
                echo json_encode(["status" => "success", "message" => "Academic Year deleted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete record."]);
            }
            exit;
        }
}
