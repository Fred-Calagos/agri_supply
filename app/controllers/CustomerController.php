<?php

namespace App\Controllers;

use PDO;
use App\models\Cart;
use App\models\User;
use App\models\Batch;
use App\models\Order;
use App\Core\Database;
use App\models\Products;
use App\models\OrderStatus;
use App\Core\BaseController;
use App\models\PaymentMethod;
use App\models\ProductCategory;

class CustomerController extends BaseController
{
    public function __construct()
    {
        $this->checkAuth();  // Ensure user is logged in
        $this->checkUser();  // Ensure user is a customer
    }

    public function index()
    {
        $productBatch = Batch::getProductFirstBatch();
    
        // Debug to check if data is returned
        if (empty($productBatch)) {
            die("No product batches found.");
        }
    
        $category = ProductCategory::all();
    
        $data = [
            'title' => 'Customer Dashboard',
            'productBatch' => $productBatch,
            'category'=> $category,
            'content' => $this->renderView('/customer/dashboard/index', [
                'productBatch' => $productBatch,
                'categories' => $category
            ])
        ];
    
        $this->view('layout/main', $data);
    }
    

    public function profile()
{
    if (!isset($_SESSION['user'])) {
        die('User session not set.');
    }
    $user = $_SESSION['user'];
    if (!isset($user['id'])) {
        die('User ID is missing.');
    }

    $userAccount = User::getUserAccount($user['id']);

    if (!$userAccount) {
        die('User account not found.');
    }

    $data = [
        'title' => 'My Profile',
        'content' => $this->renderView('/customer/account/index', [
            'userAccount' => $userAccount
        ])
    ];

    $this->view('layout/main', $data);
}

    

    public function orders()
    {
       
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $customerOrder = Order::customerOrder($user['id']);
        $orderStatus = OrderStatus::all();
        $data = [
            'title' => 'My Orders',
            'customerOrder' => $customerOrder,
            'orderStatus' => $orderStatus,
            'content' => $this->renderView('/customer/orders/index', ['customerOrder' => $customerOrder, 'orderStatus' => $orderStatus])
        ];

        $this->view('layout/main', $data);
    }
    public function cart()
    {
       
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $cartItems = Cart::totalItems($user['id']);
        $data = [
            'title' => 'My Cart',
            'cartItems' => $cartItems,
            'user' => $user,
            'content' => $this->renderView('/customer/cart/index', [
                'cartItems' => $cartItems,
                'user' => $user
            ])
        ];

        $this->view('layout/main', $data);
    }

    public function viewProduct($id) {
        // Validate and sanitize product I
    
        if ($id <= 0) {
            die("Invalid Product ID.");
        }
    
        // Fetch product details
        $product = Batch::getBatch($id);
        $productSpecification = Batch::getProductSpecification($id);
        $soldProduct = Order::soldProducts($id);
        if (!$product) {
            die("Batch not found.");
        }
    
        // Fetch user data from session
        $user = $_SESSION['user'] ?? null;
        $cartCount = ($user) ? Cart::countItems($user['id']) : 0;
    
        // Prepare data for the view
        $data = [
            'title' => 'Product Detail',
            'product' => $product,
            'user' => $user,
            'cartCount' => $cartCount,
            'soldProduct' => $soldProduct,
            'productSpecification' => $productSpecification,
            'content' => $this->renderView('/customer/product_detail/index', [
                'product' => $product,
                'user' => $user,
                'productSpecification' => $productSpecification,
                'cartCount' => $cartCount,
                'soldProduct' => $soldProduct
            ])
        ];
    
        // Load the main layout with data
        $this->view('layout/main', $data);
    }
    
    
    public function viewCategory($id) {
    
        // Fetch product details
        $category = Products::getProductCategory($id);
    
        // Fetch user data (assuming you store user data in session)
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $data = [
            'title' => 'Product Detail',
            'productCategory' => $category,
            'user' => $user, // Pass user data to the view
            'content' => $this->renderView('/customer/category/index', [
                'productCategory' => $category,
                'user' => $user
            ])
        ];
    
        $this->view('layout/main', $data);
    }
    
    public function openCategory() {
    
            $category = ProductCategory::all();
    
        $data = [
            'title' => 'Product Category',
            'categories'=> $category,
            'content' => $this->renderView('/customer/category/view_category', [
                'categories' => $category
            ])
        ];
    
        $this->view('layout/main', $data);
    }
    
    public function checkout()
    {
        $user = $_SESSION['user'] ?? null;
    
        if (!$user) {
            header('Location: /login');
            exit;
        }
    
        $selectedCartIds = $_GET['cartIds'] ?? [];
    
        if (empty($selectedCartIds)) {
            header('Location: /customer/cart?error=Please select items to checkout.');
            exit;
        }
    
        // Fetch only the selected cart items belonging to the user
        $cartItems = Cart::getSelectedItems($user['id'], $selectedCartIds);
        $user = User::getUserAccount($user['id']);
        $payment = PaymentMethod::all();
        if (empty($cartItems)) {
            header('Location: /customer/cart?error=No valid cart items found.');
            exit;
        }
    
        $data = [
            'title' => 'Checkout',
            'cartItems' => $cartItems,
            'user' => $user,
            'content' => $this->renderView('/customer/checkout/index', [
                'cartItems' => $cartItems,
                'user' => $user,
                'payment' => $payment
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
