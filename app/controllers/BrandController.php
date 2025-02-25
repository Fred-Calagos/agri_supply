<?php

namespace App\controllers;

use App\models\Brand;
use App\Core\BaseController;

class BrandController extends BaseController
{
    public function index()
    {

        $brands = Brand::all();
        $data = [
            'title' => 'Brand Setting',
            'brands' => $brands,
            'content' => $this->renderView('settings/brand', ['brands' => $brands])
        ];

        $this->view('layout/main', $data);
    }

    
    public function create() {
        $brand = Brand::all();
        $data = [
            'title' => 'Add Brand',
            'categories' => $brand,
            'content' => $this->renderView('/settings/brand_create', [
                'brand' => $brand
                ])
        ];

        $this->view('layout/main', $data);
    }
    

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $brand_name = $_POST['brand_name'] ?? '';
            $tagline = $_POST['tagline'] ?? '';
            $about = $_POST['about'] ?? '';
            $contact = $_POST['contact'] ?? '';
            $email = $_POST['email'] ?? '';
            $facebook = $_POST['facebook'] ?? '';
            $instagram = $_POST['instagram'] ?? '';
    
            // File upload handling for brand logo
            // File upload handling
            $image_path = null;
            if (!empty($_FILES['logo']['name'])) {
                $image_name = time() . '_' . $_FILES['logo']['name'];
                $upload_dir = __DIR__ . '/../../public/uploads/';
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $upload_dir . $image_name)) {
                    $image_path = '/uploads/' . $image_name; // Save the relative path
                }
            }
    
            // Save to database (assuming you have a Brand model)
            $brandModel = new Brand();
            $brandData = [
                'brand_name' => $brand_name,
                'tagline' => $tagline,
                'about' => $about,
                'contact' => $contact,
                'email' => $email,
                'facebook' => $facebook,
                'instagram' => $instagram,
                'brand_logo' => $image_path
            ];
    
            if ($brandModel->create($brandData)) {
                // Redirect to brand list or success page
                header('Location: /brand');
                exit;
            } else {
                die('Error saving brand.');
            }
        }
    }
    
}
