<?php

namespace App\controllers;

use App\Core\Database;
use App\models\Products;
use App\Core\BaseController;
use App\models\ProductStatus;
use App\models\ProductCategory;
use App\models\ProductSpecifications;

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
            $pdo = Database::connect();
            // Get the form data
            $product_name = $_POST['product_name'] ?? '';
            $product_category_id = $_POST['product_category_id'] ?? '';
            $product_status = $_POST['product_status_id'] ?? '';
            $product_description = $_POST['product_description'] ?? '';
            $specifications = $_POST['specifications'] ?? [];

    
            // File upload handling
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $image_name = time() . '_' . $_FILES['image']['name'];
                $upload_dir = __DIR__ . '/../../public/uploads/';
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
                    $image = '/uploads/' . $image_name;
                }
            }
    
            // Save to database (assuming you have a Product model)
            $productData = [
                'product_name' => $product_name,
                'product_category_id' => $product_category_id,
                'product_status_id' => $product_status,
                'product_description' => $product_description,
                'image_path' => $image
            ];
    
            if (Products::create($productData)) {

                // Get the last inserted product ID
                $product_id = (int) Products::getLastInsertId(); // Ensure this returns an integer
            
                // Debugging check (remove later)
                // var_dump($product_id); // Debugging check (remove later)
            
                // Save specifications
                $productSpecificationsModel = new ProductSpecifications();
                foreach ($specifications as $specification_id => $value) {
                    $productSpecificationsModel->create([
                        'product_id' => $product_id, // Ensure this is an integer
                        'specification_id' => $specification_id,
                        'value' => $value
                    ]);
                }
            
                // Redirect to products page
                header('Location: /products');
                exit;
            } else {
                die('Error saving product.');
            }
            
        }
    }
    
    public function edit($id) {
        $product = Products::find($id);
        $productSpecifications = ProductSpecifications::getProductSpecifications( $id);
        $categories = ProductCategory::all();
        $productStatus = ProductStatus::all();

        $data = [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'productStatus'=> $productStatus,
            'productSpecifications' => $productSpecifications,
            'content' => $this->renderView('/products/edit', ['product' => $product, 'categories' => $categories, 'productStatus'=> $productStatus,
            'productSpecifications' => $productSpecifications
            ])
        ];

        $this->view('layout/main', $data);
    }

    public function update($id) { 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the form data
            $product_name = $_POST['product_name'] ?? '';
            $product_category_id = $_POST['product_category_id'] ?? '';
            $product_status_id = $_POST['product_status_id'] ?? '';
            $product_description = $_POST['product_description'] ?? '';
            $specifications = $_POST['specifications'] ?? [];
            
            // Fetch existing product details
            $existingProduct = Products::find($id);
    
            // File upload handling
            $image = $existingProduct['image_path']; // Keep existing image if no new one is uploaded
            if (!empty($_FILES['image']['name'])) {
                $image_name = time() . '_' . $_FILES['image']['name'];
                $upload_dir = __DIR__ . '/../../public/uploads/';
                $image_path = '/uploads/' . $image_name;
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
                    // Delete old image if a new one is uploaded
                    if (!empty($existingProduct['image_path']) && file_exists(__DIR__ . '/../../public' . $existingProduct['image_path'])) {
                        unlink(__DIR__ . '/../../public' . $existingProduct['image_path']);
                    }
                    $image = $image_path;
                }
            }
    
            // Update product details
            $productData = [
                'product_name' => $product_name,
                'product_category_id' => $product_category_id,
                'product_status_id' => $product_status_id,
                'product_description' => $product_description,
                'image_path' => $image, // Save new image path
            ];
    
            $updateProduct = Products::update($id, $productData);
    
            // Update specifications
            foreach ($specifications as $spec_id => $spec_value) {
                ProductSpecifications::update($spec_id, ['value' => $spec_value]);
            }
    
            if ($updateProduct) {
                header('Location: /products');
                exit;
            } else {
                die('Error updating product.');
            }
        }
    }
    


}
