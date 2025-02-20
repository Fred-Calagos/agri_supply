<?php

namespace App\Core;

class BaseController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
    }

    protected function renderView($view, $data = []) {
        extract($data);
        ob_start();
        require __DIR__ . "/../Views/$view.php";
        return ob_get_clean();
    }
}
