<?php

namespace App\Controllers;

use App\Models\User;

class AuthController 
{
    public function showLogin() 
    {
        include_once __DIR__ . '/../Views/auth/login.php';
    }

    public function login() 
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Please fill in all fields.";
            header("Location: /login");
            exit;
        }

        $userModel = new User();
        $user = $userModel->getUserByEmail($email);

        if (!$user & !$user['password']) { // Use password hashing
            $_SESSION['error'] = "Invalid email or password";
            header("Location: /login");
            exit;
        }

        // Store user details in session
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'email' => $user['email'],
            'role'  => $user['role'], 
        ];

        // Redirect based on role
        if ($user['role'] === 'Admin') {
            header("Location: /admin");
        } else {
            header("Location: /customer/dashboard");
        }
        exit;
    }

    public function logout() 
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
