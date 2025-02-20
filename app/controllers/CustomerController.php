<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\models\ProductCategory;
use App\Models\Products;

class CustomerController extends BaseController
{
    public function __construct()
    {
        $this->checkAuth();  // Ensure user is logged in
        $this->checkUser();  // Ensure user is a customer
    }

    public function index()
    {
        // Fetch all products
        $products = Products::all();

        // Fetch products by category
        $fruitProducts = Products::getByCategory('Fruit');
        $vegetableProducts = Products::getByCategory('Vegetable');

        $data = [
            'title' => 'Customer Dashboard',
            'products' => $products,
            'fruitProducts' => $fruitProducts,
            'vegetableProducts' => $vegetableProducts,
            'content' => $this->renderView('/customer/dashboard/index', [
                'products' => $products,
                'fruitProducts' => $fruitProducts,
                'vegetableProducts' => $vegetableProducts
            ])
        ];

        $this->view('layout/main', $data);
    }

    public function profile()
    {
        $data = [
            'title' => 'My Profile',
            'content' => $this->renderView('customer/profile')
        ];

        $this->view('layout/main', $data);
    }

    public function orders()
    {
        $data = [
            'title' => 'My Orders',
            'content' => $this->renderView('customer/orders')
        ];

        $this->view('layout/main', $data);
    }
    public function cart()
    {
        $data = [
            'title' => 'My Cart',
            'content' => $this->renderView('customer/cart')
        ];

        $this->view('layout/main', $data);
    }

    public function viewProduct() {
    
        // Check if the product ID is set in the URL
        if (!isset($_GET['id'])) {
            die("Invalid Product ID.");
        }
    
        // Fetch product details
        $product = Products::find($_GET['id']);
    
        if (!$product) {
            die("Product not found.");
        }
    
        // Fetch user data (assuming you store user data in session)
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
    
        $data = [
            'title' => 'Product Detail',
            'product' => $product,
            'user' => $user, // Pass user data to the view
            'content' => $this->renderView('/customer/product_detail/index', [
                'product' => $product,
                'user' => $user
            ])
        ];
    
        $this->view('layout/main', $data);
    }
    

    private function checkAuth()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }

    private function checkUser()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'User') {
            header("Location: /dashboard"); // Redirect admins to admin dashboard
            exit;
        }
    }
}
