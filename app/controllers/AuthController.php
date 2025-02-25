<?php

namespace App\controllers;

use App\Models\User;
use App\models\Brand;

class AuthController
{
    public function showLogin() 
    {
        $brands = Brand::all();
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

        if (!$user && $password !== $user['password']) { // Use password hashing
            $_SESSION['error'] = "Invalid email or password";
            header("Location: /login");
        }else{
                        // Store user details in session
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'email' => $user['email'],
                'role'  => $user['role'], 
            ];

            // Redirect based on role
            if ($user['role'] === 'Admin' && $user && $password == $user['password'] ) {
                header("Location: /admin");
            } elseif($user['role'] === 'User' && $user && $password == $user['password']) {
                header("Location: /customer/dashboard");
            }else{
                $_SESSION['error'] = "Invalid email or password";
                header("Location: /login");
            }

        }

    }

    public function logout() 
    {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
