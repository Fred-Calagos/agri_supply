<?php

namespace App\Controllers;

use App\Core\BaseController;

class CustomerController extends BaseController
{
    public function __construct()
    {
        $this->checkAuth();  // Ensure user is logged in
        $this->checkUser();  // Ensure user is a customer
    }

    public function index()
    {
        $data = [
            'title' => 'Customer Dashboard',
            'content' => $this->renderView('/customer/dashboard/index')
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
