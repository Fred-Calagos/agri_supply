<?php

namespace App\controllers;

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
            // Get the form data
            $product_id = $_POST['product_id'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $price = $_POST['price'] ?? '';
            $total = $_POST['total'] ?? '';
            $status = $_POST['status'] ?? '';

            // Save to database (assuming you have a Cart model)
            $cartModel = new Cart();
            $cartData = [
                'product_id' => $product_id,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $total,
                'status' => $status
            ];

            if ($cartModel->create($cartData)) {
                // Redirect to cart list or success page
                header('Location: /cart');
            }
        }
    }
}
