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
            $image = null;
            if (!empty($_FILES['image']['name'])) {
                $image_name = time() . '_' . $_FILES['image']['name'];
                $upload_dir = __DIR__ . '/../../public/uploads/';
                
                // Ensure upload directory exists
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $image_name)) {
                    $image = '/uploads/' . $image_name; // Save the relative path
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
                'image_path' => $image
            ];
    
            if ($brandModel->create($brandData)) {
                // Redirect to brand list or success page
                header('Location: /brands');
                exit;
            } else {
                die('Error saving brand.');
            }
        }
    }
    
}
