<?php

namespace App\controllers;

use App\Core\Database;
use App\Core\BaseController;
use App\models\ProductCategory;

class ProductCategoryController extends BaseController
{
    public function __construct()
    {
        checkAdmin(); // Ensure only admins can access this controller
    }
    public function index()
    {
        $productCategories = ProductCategory::all();
        $data = [
            'title' => 'Product Categories',
            'productCategories'=> $productCategories,
            'content' => $this->renderView('/products/product_category', ['productCategories' => $productCategories])
        ];
        $this->view('layout/main', $data);
    }

    public function create() {
        
        $data = [
            'title' => 'Add Product Category',
            'content' => $this->renderView('product_categories/create')
        ];

        $this->view('layout/main', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the database connection
            $pdo = Database::connect();

            // Create the new academic year using the database connection
            ProductCategory::create($_POST); // Assuming the create method in AcademicYear accepts the PDO object

            // Get the latest academic year data using the last inserted ID
            $newProductCategory = ProductCategory::find($pdo->lastInsertId());

            // Return the new academic year data as JSON
            echo json_encode(["status" => "success", "newProductCategory" => $newProductCategory]);
            exit;
        }
    }
    

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productCat = $_POST['product_category'];
    
            if ($id && $productCat) {
                // Update the product category
                $data = ['product_category' => $productCat];
                ProductCategory::update($id, $data);
    
                echo json_encode(['status' => 'success', 'message' => 'Product Cateogry updated successfully.']);
                exit;
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
                exit;
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
            exit;
        }
    }
    

}
