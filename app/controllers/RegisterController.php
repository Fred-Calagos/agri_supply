<?php

namespace App\controllers;

use App\Core\Database;
use App\Core\LoginController;
use App\models\refProvince;
use App\models\refRegion;
use App\Models\User;

class RegisterController extends LoginController
{   
    public function showRegister() 
    {
        $refProvince = refProvince::all();
        $refRegion = refRegion::all();
        $data = [
            'title' => 'Login',
            'refProvince' => $refProvince,
            'refRegion' => $refRegion,
            'content' => $this->renderView('register/index', [
                'refProvince' => $refProvince,
                'refRegion' => $refRegion
                ])
        ];

        $this->view('layout/login-main', $data);

    }
    
    public function store(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // Retrieve the database connection
            $pdo = Database::connect();
    
            // Create the new product status using the database connection
            $data = [
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'email' => $_POST['email'],
                'password' => $_POST['password'], // Hashing for security
                'contact' => $_POST['contact'],
                'reg' => $_POST['reg'],
                'prov' => $_POST['prov'],
                'citymun' => $_POST['citymun'],
                'brgy' => $_POST['brgy'],   
                'zipcode' => $_POST['zipcode'],
                'place_desc' => $_POST['place_desc'],
                'role' => 'User'
            ];
            
            // Create a new user
            User::create($data);
            
    
            // Get the latest product status data using the last inserted ID
            $newProductStatus = User::find($pdo->lastInsertId());
    
            // Return the new product status data as JSON
            echo json_encode(["status" => "success", "newProductStatus" => $newProductStatus]);
            header("/register/index");
            exit;
        }
    }
}
