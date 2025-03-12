<?php

namespace App\controllers;

use App\Core\Database;
use App\Core\BaseController;
use App\models\PaymentMethod;

class PaymentController extends BaseController
{
    public function index(){
        $paymentMethods = PaymentMethod::all();
        $data = [
            "title"=> "Payment Method",
            'content'=>$this->renderView('settings/payment', ['paymentMethods' => $paymentMethods])
        ];
        $this->view('layout/main',$data);

    }

    public function store (){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the database connection
            $pdo = Database::connect();
            PaymentMethod::create($_POST);

            // Get the latest academic year data using the last inserted ID
            $newOrderStatus = PaymentMethod::find($pdo->lastInsertId());

            // Return the new academic year data as JSON
            echo json_encode(["status" => "success", "newOrderStatus" => $newOrderStatus]);
            exit;
        }
    }
    public function update($id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = $_POST['payment_method'];
            // Make sure all fields are valid
            if ($id && $paymentMethod) {
                // Update the academic year
                $data = [
                    'payment_method' => $paymentMethod,
                ];
                PaymentMethod::update($id, $data);

                // Return success response (or redirect)
                echo json_encode(['status' => 'success', 'message' => 'Payment Method updated successfully.']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
                exit;
            }
        }
    }
}
