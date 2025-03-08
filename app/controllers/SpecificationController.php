<?php

namespace App\controllers;

use App\Core\BaseController;
use App\Core\Database;
use App\models\CategorySpecification;
use App\models\ProductCategory;
use App\models\Specification;

class SpecificationController extends BaseController
{
 public function index()
 {
    $specification = Specification::all();
    $data = [
        'title' => 'Specifications',
        'specifications' => $specification,
        'content' => $this->renderView('products/specification', [
            'specifications' => $specification
        ])
    ];

  $this->view('layout/main', $data);
 }
 public function categorySpecification()
 {
    $categoryId = $_GET['category'] ?? '';
    $categorySpecification = CategorySpecification::getSpecifications($categoryId);
    $categoryName = $categoryId ? ProductCategory::find($categoryId)['product_category'] : '';
    $data = [
        'title' => 'Specifications',
        'categorySpecification' => $categorySpecification,
        'categoryName' => $categoryName,
        'content' => $this->renderView('products/category_specification', [
            'categorySpecification' => $categorySpecification,
            'categoryName' => $categoryName,
            'categoryId' => $categoryId
        ])
    ];
  $this->view('layout/main', $data);
 }
 public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = Database::connect();

        // Example: Check for duplicates based on a specific field (e.g., 'name')
        $name = $_POST['name']; // Change this based on your actual field
        
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM specification WHERE name = ?");
        $stmt->execute([$name]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["status" => "error", "message" => "Duplicate entry detected."]);
            exit;
        }

        // If no duplicate, create the new record
        Specification::create($_POST);

        $newSpecification = Specification::find($pdo->lastInsertId());

        echo json_encode(["status" => "success", "newSpecification" => $newSpecification]);
        exit;
    }
}
 public function categorySpecificationStore() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = Database::connect();

        $catId = $_POST['category_id'];
        $specificationId = $_POST['specification_id'];
        
        $stmt = $pdo->prepare(query: "SELECT COUNT(*) FROM category_specification WHERE specification_id = ? AND category_id = ?");
        $stmt->execute([$specificationId, $catId]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode(["status" => "error", "message" => "Duplicate entry detected."]);
            exit;
        }

        // If no duplicate, create the new record
        CategorySpecification::create($_POST);

        $newSpecification = CategorySpecification::find($pdo->lastInsertId());

        echo json_encode(["status" => "success", "newSpecification" => $newSpecification]);
        header("Location: /product/category/specification?category=" . $catId);
        exit;
    }
}



public function update($id) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = Database::connect();

        $name = $_POST['name']; // Change to your actual field
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM specification WHERE name = ? AND id != ?");
        $stmt->execute([$name, $id]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo json_encode([
                "status" => "error",
                "message" => "Duplicate entry detected."
            ]);
            exit;
        }

        // Update logic here (assuming you have an update method)
        Specification::update($id, $_POST);

        $updatedSpecification = Specification::find($id);

        echo json_encode([
            "status" => "success",
            "message" => "Specification updated successfully.",
            "updatedSpecification" => $updatedSpecification
        ]);
        exit;
    }
}

public function suggest()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $query = trim($_POST['query']);
        $specification = Specification::searchSpecification($query);

        if (!empty($specification)) {
            foreach ($specification as $specific) {
                echo '<a href="#" class="list-group-item list-group-item-action specification-item" data-id="' . htmlspecialchars($specific['id']) . '">' . htmlspecialchars($specific['name']) . '</a>';
            }
        } else {
            echo '<div class="list-group-item">No Specification found, Add new Specification</div>';
        }
    }
}

public function get_by_category($id) {
    $db = Database::connect();
    $query = "SELECT cs.specification_id, s.name AS specification_name
              FROM category_specification cs
              JOIN specification s ON cs.specification_id = s.id
              WHERE cs.category_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $specifications = $stmt->fetchAll();

    echo json_encode($specifications);
    exit;
}





 
}
