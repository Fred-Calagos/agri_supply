<?php

namespace App\controllers;

use App\models\Order;
use App\models\OrderStatus;
use App\Core\BaseController;

class OrderController extends BaseController
{
    public function index(){
        $orders = Order::getAllOrders();
        $data = [
            'title' => 'Ordered Product',
            'orders' => $orders,
            'content' => $this->renderView('/orders/index', ['orders' => $orders])
        ];

        $this->view('layout/main', $data);
    }

    public function edit(){
        $orderTrack = $_GET['track_order'] ?? null; // Fetch the order track from URL parameter

        $orderTracks = Order::getAllOrdersByTrack( $orderTrack );
        $orderStatus = OrderStatus::all();
        $data = [
            'title' => 'Update Orders',
            'orderTracks' => $orderTracks,
            'orderTrackNumber' => $orderTrack,
            'orderStatus' => $orderStatus,
            'content' => $this->renderView('/orders/order_details', [
                'orderTracks' => $orderTracks,
                'orderTrackNumber' => $orderTrack,
                'orderStatus' => $orderStatus

            ])
        ];

        $this->view('layout/main', $data);
    }
    public function updateOrderStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trackNumber = $_POST['order_track'];
            $orderStatus = $_POST['order_status'];
    
            // Update all rows with the same order_track
        // Save to database (assuming you have a Product model)
        $orderData = [
            'order_status' => $orderStatus
        ];
        
        Order::updatebyTrack($trackNumber, $orderData);
            // Redirect to products list or success page
            header('Location: /orders/order_details?track_order=' . $trackNumber);
            exit;

        
    }
    }    

}