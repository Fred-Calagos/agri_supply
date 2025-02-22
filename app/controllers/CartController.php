<?php

namespace App\controllers;

use App\Core\Database;
use App\Core\BaseController;
use App\models\Cart;
use App\models\Order;


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
    public function checkoutSelected()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve and sanitize input
            $cartItemIds = isset($_POST['cartIds']) ? $_POST['cartIds'] : [];
    
            if (!is_array($cartItemIds) || empty($cartItemIds)) {
                echo json_encode(['status' => 'error', 'message' => 'No items selected.']);
                exit;
            }
    
            // Fetch cart items using a model function
            $cartModel = new Cart();
            $cartItemsData = $cartModel->getItemsByIds($cartItemIds); // Ensure this method exists
    
            if (!$cartItemsData || count($cartItemsData) === 0) { // Check if array is empty
                echo json_encode(['status' => 'error', 'message' => 'Cart items not found.']);
                exit;
            }
    
            // Insert into the orders table
            $orderModel = new Order();
            foreach ($cartItemsData as $item) {
                $orderModel->create([
                    'user_id' => $item['user_id'], 
                    'product_id' => $item['product_id'], 
                    'product_quantity' => $item['quantity']
                ]);
            }
    
            // Remove checked items from cart
            $cartModel->deleteItemsByIds($cartItemIds); // Ensure this method exists
    
            echo json_encode(['status' => 'success', 'message' => 'Checkout successful!']);
            exit;
        }
    
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
        exit;
    }
    

}
