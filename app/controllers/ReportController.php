<?php

namespace App\controllers;

use App\models\Order;
use App\Core\BaseController;
use App\models\ProductCategory;

class ReportController extends BaseController
{
    public function reportPage(){
        $data = [
            'title' => 'Report',
            'content' => $this->renderView('report/index')
        ];

        $this->view('layout/main', $data);
    }
    public function reportOrderPage(){
        $orderReport = Order::OrderReport();
        $data = [
            'title' => 'Generate Orders Report',
            'content' => $this->renderView('report/report_orders', [
                'orderReport' => $orderReport

            ])
        ];

        $this->view('layout/main', $data);
    }
    public function reportProductSales() {
        $year = isset($_GET['year']) ? $_GET['year'] : null;
        $category = isset($_GET['category']) ? $_GET['category'] : null;
    
        $productSales = Order::getProductSales($year, $category);
    
        $ProductCategory = ProductCategory::all();
    
        $data = [
            'title' => 'Generate Sales Report',
            'content' => $this->renderView('report/sales', [
                'productSales' => $productSales,
                'productCategory' => $ProductCategory,
                'year' => $year,
                'category' => $category
            ])
        ];
        $this->view('layout/main', $data);
    }
    
    
}
