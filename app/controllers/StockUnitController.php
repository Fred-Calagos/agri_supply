<?php

namespace App\controllers;

use App\Core\BaseController;
use App\Core\Database;
use App\models\StockUnit;

class StockUnitController extends BaseController
{
  public function index()
  {
    $stock_unit = StockUnit::all();
    $data = [
      'title' => 'Stock Units',
      'content' => $this->renderView('products/stock-unit', [
        'stock_units' => $stock_unit
      ])
    ];

    $this->view('layout/main', $data);
  }

  public function store(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = Database::connect();
            $stock_unit_name = $_POST['stock_unit_name'];
            $category = $_POST['category'];
            $description = $_POST['description'];
            $data = [
                'name' => $stock_unit_name,
                'category' => $category,
                'description' => $description
            ];
        StockUnit::create($data);
        $newStockUnit = StockUnit::find($pdo->lastInsertId());
        echo json_encode(["status" => "success", "newStockUnit" => $newStockUnit]);
        exit;
    }
  }

  public function search()
  {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $query = trim($_POST['query']);
          $stockUnits = StockUnit::searchStockUnits($query);
  
          if (!empty($stockUnits)) {
              foreach ($stockUnits as $unit) {
                  echo '<a href="#" class="list-group-item list-group-item-action stock-unit-item">' . htmlspecialchars($unit['name']) . '</a>';
              }
          } else {
              echo '<div class="list-group-item">No stock unit found</div>';
          }
      }
  }
  
  public function update($id){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = Database::connect();
        $stock_unit_name = $_POST['stock_unit_name'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $id = $_POST['id'];
        $data = [
            'name' => $stock_unit_name,
            'category' => $category,
            'description' => $description
        ];
        StockUnit::update($id, $data);
        $updatedStockUnit = StockUnit::find($id);
        echo json_encode(["status" => "success", "updatedStockUnit" => $updatedStockUnit]);
        exit;
    }
  }
}
