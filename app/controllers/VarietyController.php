<?php

namespace App\controllers;

use App\Core\BaseController;
use App\Core\Database;
use App\models\Products;
use App\models\Variety;

class VarietyController extends BaseController
{ 
    public function index()
    {
        $varieties = Variety::all();
        $data = [
            'title' => 'Varieties',
            'content' => $this->renderView('products/variety', [
                'varieties' => $varieties
            ])
        ];

        $this->view('layout/main', $data);
    }
    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = trim($_POST['query']);
            $products = Products::searchProducts($query);

            if (!empty($products)) {
                foreach ($products as $product) {
                    echo '<a href="#" class="list-group-item list-group-item-action product-item" data-id="' . $product['id'] . '">' . htmlspecialchars($product['product_name']) . '</a>';
                }
            } else {
                echo '<div class="list-group-item">No product found</div>';
            }
        }
    }
    public function store(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::connect();
            $variety = $_POST['variety_name'];
            $product_id = $_POST['product_id'];
            $data = [
                'variety_name' => $variety,
                'product_id' => $product_id
            ];
            Variety::create($data);
            $newVariety = Variety::find($pdo->lastInsertId());
            echo json_encode(["status" => "success", "newVariety" => $newVariety]);
            exit;
        }
    }

    public function suggest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = trim($_POST['query']);
            $varieties = Variety::searchVarieties($query);

            if (!empty($varieties)) {
                foreach ($varieties as $variety) {
                    echo '<a href="#" class="list-group-item list-group-item-action variety-item">' . htmlspecialchars($variety['variety_name']) . '</a>';
                }
            } else {
                echo '<div class="list-group-item">No variety found</div>';
            }
        }
    }

}