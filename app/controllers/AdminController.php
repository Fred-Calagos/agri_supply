<?php

namespace App\controllers;

use App\Models\User;
use App\models\Order;
use App\models\Products;
use App\Core\BaseController;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->checkAuth();  // Ensure user is logged in
        $this->checkAdmin(); // Ensure user is an admin
    }

    public function index()
    {
        $year = date('Y');
        $products = Products::totalProducts();
        $pendingOrders = Order::pendingOrders();
        $orders = Order::totalOrders();
        $salesByMonth = Order::totalSalesByMonth();
        $monthSales = Order::totalSalesThisMonth();
        $todaySales = Order::totalSalesToday();
        $yearlySales = Order::totalSalesYearly();
        $user = User::totalUser();
        $data = [
            'title' => 'Admin Dashboard',
            'products' => $products,
            'content' => $this->renderView('dashboard/index', [
                'products' => $products,
                'orders' => $orders,
                'todaySales' => $todaySales,
                'yearlySales' => $yearlySales,
                'monthSales' => $monthSales,
                'pendingOrders' => $pendingOrders,
                'salesByMonth' => $salesByMonth,
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

    private function checkAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
            header("Location: /customer/dashboard"); // Redirect non-admin users
            exit;
        }
    }
}
