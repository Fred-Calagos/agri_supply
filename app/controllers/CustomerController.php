<?php

namespace App\Controllers;

use PDO;
use App\models\Cart;
use App\models\Order;
use App\Core\Database;
use App\models\Products;
use App\Core\BaseController;
use App\models\ProductCategory;
use App\models\OrderStatus;
use App\models\User;

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
            $category = ProductCategory::all();
    
        $data = [
            'title' => 'Customer Dashboard',
            'products' => $products,
            'category'=> $category,
            'content' => $this->renderView('/customer/dashboard/index', [
                'products' => $products,
                'categories' => $category
            ])
        ];
    
        $this->view('layout/main', $data);
    }
    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::connect();
            $searchQuery = trim($_POST['query']) ?? '';

            if (!empty($searchQuery)) {
                $stmt = $pdo->prepare(
                "SELECT p.*, pc.product_category FROM products p 
                        JOIN product_category pc ON p.product_category_id = pc.id
                        WHERE p.product_name LIKE :query OR pc.product_category LIKE :query");
                $stmt->execute(['query' => '%' . $searchQuery . '%']);
                $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                echo json_encode(["status" => "success", "products" => $products]);
                exit;
            } else {
                echo json_encode(["status" => "error", "message" => "No products found"]);
                exit;
            }
        }
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

    public function viewProduct() {
        // Validate and sanitize product ID
        $productId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    
        if ($productId <= 0) {
            die("Invalid Product ID.");
        }
    
        // Fetch product details
        $product = Products::find($productId);
        $soldProduct = Order::soldProducts($productId);
        if (!$product) {
            die("Product not found.");
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
            'content' => $this->renderView('/customer/product_detail/index', [
                'product' => $product,
                'user' => $user,
                'soldProduct' => $soldProduct,
                'cartCount' => $cartCount
            ])
        ];
    
        // Load the main layout with data
        $this->view('layout/main', $data);
    }
    
    
    public function viewCategory() {
    
        // Check if the product ID is set in the URL
        if (!isset($_GET['category'])) {
            die("Invalid Category.");
        }
    
        // Fetch product details
        $category = Products::getProductCategory($_GET['category']);
    
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
