<?php

namespace App\controllers;

use App\Core\Database;
use App\Core\BaseController;
use App\models\Cart;


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
    
    

}

