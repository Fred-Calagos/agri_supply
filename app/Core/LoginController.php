<?php

namespace App\Core;

class LoginController
{
    protected function renderView($view, $data = []) {
        extract($data);
        ob_start();
        include __DIR__ . "/../Views/$view.php";
        return ob_get_clean();
    }
    
    protected function view($layout, $data = []) {
        extract($data);
        include __DIR__ . "/../Views/$layout.php";
    }
    
}
