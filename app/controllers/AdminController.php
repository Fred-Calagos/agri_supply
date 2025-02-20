<?php

namespace App\Controllers;

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
        $data = [
            'title' => 'Admin Dashboard',
            'content' => $this->renderView('dashboard/index')
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
