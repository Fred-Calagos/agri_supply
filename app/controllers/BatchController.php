<?php

namespace App\controllers;

use App\models\Batch;
use App\Core\Database;
use App\models\Products;
use App\Core\BaseController;
use App\models\ProductStatus;

class BatchController extends BaseController
{
    public function index($id){
        $batch = Batch::find($id);
        $productBatches = Batch::getProductBatches($id);
        $product = Products::find($id);
        $productStatus = ProductStatus::all();
        $data=[
            'title'=>'Batch',
            'content'=>$this->renderView('products/batch', [
                'batch'=>$batch,
                'product'=>$product,
                'productBatches'=>$productBatches,
                'productStatus'=>$productStatus
                
            ])
        ];
        $this->view('layout/main',$data);
    }

    
    public function store(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::connect();
            // Get the form data
            $product_id = $_POST['product_id'] ?? '';
            $batch_number = "Batch-" . $_POST['batch_number'] ?? '';
            $status = $_POST['product_status_id'] ?? '';
            $cost_price = $_POST['cost_price'] ?? 0;
            $profit_margin = $_POST['profit_margin'] ?? 0;
            $selling_price = $_POST['selling_price'] ?? 0;
            $stocks = $_POST['stocks'] ?? 0;
            $stock_unit = $_POST['stock_unit'] ?? '';
            $expiry_date = $_POST['best_before_date'] ?? '';

            $data =[
                'product_id'=>$product_id,
                'batch_number'=>$batch_number,
                'best_before_date'=>$expiry_date,
                'cost_price'=>$cost_price,
                'profit_margin'=>$profit_margin,
                'selling_price'=>$selling_price,
                'stock_category'=>$status,
                'stocks'=>$stocks,
                'stock_unit'=>$stock_unit
            ];

            Batch::create($data);

            header('Location: /products/batch/'.$product_id);

        }
    }
}
