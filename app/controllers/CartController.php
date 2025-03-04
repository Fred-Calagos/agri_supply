<?php

namespace App\controllers;

use App\models\Cart;
use App\models\Order;
use App\Core\Database;
use App\models\Products;
use App\models\OrderStatus;
use App\Core\BaseController;


class CartController extends BaseController
{
    public function index()
    {
        $cart = Cart::all();
        $data = [
            'title' => 'Cart',
            'content' => $this->renderView('cart/index')
        ];

        $this->view('layout/main', $data);
    }
    public function create()
    {
        $data = [
            'title' => 'Add to Cart',
            'content' => $this->renderView('cart/create')
        ];

        $this->view('layout/main', $data);
    }

    public function store()
    {
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::connect();
            $productId = $_POST['product_id'] ?? null;
            $userId = $_POST['user_id'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
    
            if ($productId && $userId && $quantity) {
                Cart::create([
                    'product_id' => $productId,
                    'user_id' => $userId,
                    'quantity' => $quantity
                ]);
    
                // Return JSON success message
                echo json_encode(["status" => "success", "message" => "Product added to cart!"]);
            } else {
                // Return JSON error message
                echo json_encode(["status" => "error", "message" => "Failed to add product to cart."]);
            }
            exit; // Stop execution after sending JSON
        }
    }
    
    public function updateQuantity($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    
            if ($id && $quantity > 0) {
                // Update the quantity in the cart table
                $data = ['quantity' => $quantity];
                Cart::update($id, $data);
    
                echo json_encode(['status' => 'success', 'message' => 'Cart quantity updated successfully.']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid cart ID or quantity.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
            exit;
        }
    }  

    public function OrderSelected()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemIds = $_POST['cartIds'] ?? [];
    
            if (empty($cartItemIds)) {
                echo json_encode(['status' => 'error', 'message' => 'No items selected.']);
                exit;
            }
    
            $cartModel = new Cart();
            $cartItemsData = $cartModel->getItemsByIds($cartItemIds);
    
            if (empty($cartItemsData)) {
                echo json_encode(['status' => 'error', 'message' => 'Cart items not found.']);
                exit;
            }
    
            function generateOrderTrack() {
                return 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
            }
    
            $orderTrack = generateOrderTrack();
            $orderStatusId = OrderStatus::getPendingId() ?? 0;
    
            $orderModel = new Order();
            $productModel = new Products();
    
            foreach ($cartItemsData as $item) {
                $productId = $item['product_id'];
                $orderedQty = $item['quantity']; // ✅ Correct field
    
                // Fetch current product stock
                $product = $productModel->find($productId);
                if ($product) {
                    $currentStock = $product['stocks'];
    
                    if ($currentStock >= $orderedQty) {
                        $newStock = $currentStock - $orderedQty;
                        $productModel->update($productId, ['stocks' => $newStock]);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => "Insufficient stock for {$product['product_name']}"]);
                        exit;
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Product not found.']);
                    exit;
                }
    
                // Create the order
                $orderModel->create([
                    'user_id' => $item['user_id'],
                    'product_id' => $productId,
                    'product_quantity' => $orderedQty,
                    'order_status' => $orderStatusId,
                    'order_track' => $orderTrack
                ]);
            }
    
            // Remove ordered items from the cart
            $cartModel->deleteItemsByIds($cartItemIds);
    
            echo json_encode(['status' => 'success', 'message' => 'Checkout successful!']);
            exit;
        }
    
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }
    

    public function OrderSelected1()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST Data: " . print_r($_POST, true)); // Debugging
        
            $cartItemIds = isset($_POST['cartIds']) ? $_POST['cartIds'] : [];
            
            if (!is_array($cartItemIds) || empty($cartItemIds)) {
                error_log("Error: No items selected.");
                echo json_encode(['status' => 'error', 'message' => 'No items selected.']);
                exit;
            }
        
            $cartModel = new Cart();
            $cartItemsData = $cartModel->getItemsByIds($cartItemIds);
        
            if (!$cartItemsData || count($cartItemsData) === 0) {
                error_log("Error: Cart items not found.");
                echo json_encode(['status' => 'error', 'message' => 'Cart items not found.']);
                exit;
            }
            
            function generateOrderTrack() {
                return 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
            }
        
            // Generate tracking number once per submission
            $orderTrack = generateOrderTrack(); 
            $orderStatusId = OrderStatus::getPendingId() ?? 0;

            
            $orderModel = new Order();
            
            foreach ($cartItemsData as $item) {
                
                $orderModel->create([
                    'user_id' => $item['user_id'], 
                    'product_id' => $item['product_id'], 
                    'product_quantity' => $item['quantity'],
                    'order_status' => $orderStatusId,
                    'order_track' => $orderTrack
                ]);
            }
        
            $cartModel->deleteItemsByIds($cartItemIds);
        
            error_log("Checkout successful!");
            echo json_encode(['status' => 'success', 'message' => 'Checkout successful!']);
            exit;
        }
        
        error_log("Error: Invalid request method.");
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
        
    }

    // Method to delete an academic year
    public function deleteCart($id) {
        if (!$id) {
            echo json_encode(["status" => "error", "message" => "Invalid ID."]);
            exit;
        }
    
        // Debugging: Log the ID before deletion
        error_log("Attempting to delete Academic Year with ID: " . $id);
    
        $deleted = Cart::delete($id);
    
        if ($deleted) {
            echo json_encode(["status" => "success", "message" => "Academic Year deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete record."]);
        }
        exit;
    }

}
