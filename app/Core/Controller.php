<?php

namespace App\Core;

class Controller {
    protected function view($view, $data = []) {
        extract($data); // Convert array keys to variables
        $viewPath = __DIR__ . "/../Views/$view.php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View '$view' not found.");
        }
    }
}
