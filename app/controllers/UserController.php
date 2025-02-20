<?php

namespace App\controllers;

use App\Models\User;
use App\Core\BaseController;

class UserController extends BaseController
{
    public function __construct()
    {
        checkAdmin(); // Ensure only admins can access this controller
    }
    public function index()
    {
        $users = User::all();
        $data = [
            'title' => 'Users',
            'users' => $users,
            'content' => $this->renderView('user/index', ['users' => $users])
        ];

        $this->view('layout/main', $data);
    }
}
