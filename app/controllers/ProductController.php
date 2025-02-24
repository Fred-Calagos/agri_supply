<?php

namespace App\controllers;

use App\models\Products;
use App\Core\BaseController;
use App\models\ProductStatus;
use App\models\ProductCategory;

class ProductController extends BaseController
{
    public function __construct()
    {
        checkAdmin(); // Ensure only admins can access this controller
    }
    public function index()
    {
        $categories = ProductCategory::all();
        $products = Products::all();
        $productStatus = ProductStatus::all();
        $data = [
            'title' => 'Products',
            'products'=> $products,
            'categories'=> $categories,
            'productStatus'=> $productStatus,
            'content' => $this->renderView('products/index', [
                'products' => $products,
                'categories' => $categories,
                'productStatus'=> $productStatus
                ])
        ];

        $this->view('layout/main', $data);
    }


    public function create() {
        $categories = ProductCategory::all();
        $productStatus = ProductStatus::all();
        $data = [
            'title' => 'Add Product',
            'categories' => $categories,
            'productStatus'=> $productStatus,
            'content' => $this->renderView('/products/create', [
                'categories' => $categories,
                'productStatus'=> $productStatus
                
                ])
        ];

        $this->view('layout/main', $data);
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $product_name = $_POST['product_name'] ?? '';
            $product_category_id = $_POST['product_category_id'] ?? '';
            $product_status = $_POST['product_status_id'] ?? '';
            $product_description = $_POST['product_description'] ?? '';
            $cost_price = $_POST['cost_price'] ?? 0;
            $profit_margin = $_POST['profit_margin'] ?? 0;
            $selling_price = $_POST['selling_price'] ?? 0;
            $shipping_fee = $_POST['shipping_fee'] ?? 0;
            $stocks = $_POST['stocks'] ?? 0;
    
            // File upload handling
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $image_name = time() . '_' . $_FILES['image']['name'];
                $upload_dir = __DIR__ . '/../../public/uploads/';
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
                    $image = '/uploads/' . $image_name; // Save the relative path
                }
            }
    
            // Save to database (assuming you have a Product model)
            $productModel = new Products();
            $productData = [
                'product_name' => $product_name,
                'product_category_id' => $product_category_id,
                'product_status_id' => $product_status,
                'product_description' => $product_description,
                'cost_price' => $cost_price,
                'profit_margin' => $profit_margin,
                'selling_price' => $selling_price,
                'shipping_fee' => $shipping_fee,
                'stocks' => $stocks,
                'image_path' => $image
            ];
    
            if ($productModel->create($productData)) {
                // Redirect to products list or success page
                header('Location: /products');
                exit;
            } else {
                die('Error saving product.');
            }
        }
    }

    public function edit($id) {
        $product = Products::find($id);
        $categories = ProductCategory::all();
        $productStatus = ProductStatus::all();

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'productStatus'=> $productStatus,
            'content' => $this->renderView('/products/edit', ['product' => $product, 'categories' => $categories, 'productStatus'=> $productStatus])
        ];

        $this->view('layout/main', $data);
    }

    public function update($id) { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $product_name = $_POST['product_name'] ?? '';
            $product_category_id = $_POST['product_category_id'] ?? '';
            $product_status = $_POST['product_status'] ?? '';
            $product_description = $_POST['product_description'] ?? '';
            $cost_price = $_POST['cost_price'] ?? 0;
            $profit_margin = $_POST['profit_margin'] ?? 0;
            $selling_price = $_POST['selling_price'] ?? 0;
            $shipping_fee = $_POST['shipping_fee'] ?? 0;
            $stocks = $_POST['stocks'] ?? 0;
    
            // File upload handling
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $image_name = time() . '_' . $_FILES['image']['name'];
                $upload_dir = __DIR__ . '/../../public/uploads/';
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
                    $image = '/uploads/' . $image_name; // Save the relative path
                }
            }
    
            // Save to database (assuming you have a Product model)
            $productModel = new Products();
            $productData = [
                'product_name' => $product_name,
                'product_category_id' => $product_category_id,
                'product_status' => $product_status,
                'product_description' => $product_description,
                'cost_price' => $cost_price,
                'profit_margin' => $profit_margin,
                'selling_price' => $selling_price,
                'shipping_fee' => $shipping_fee,
                'stocks' => $stocks,
                'image_path' => $image
            ];
    
            if ($productModel->update($id, $productData)) {
                // Redirect to products list or success page
                header('Location: /products');
                exit;
            } else {
                die('Error saving product.');
            }
        }
    }
    
}
