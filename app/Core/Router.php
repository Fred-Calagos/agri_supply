<?php

namespace App\Core;

class Router {
    private $routes = [];

    // Add GET route
    public function get($path, $action) {
        $this->addRoute('GET', $path, $action);
    }

    // Add POST route
    public function post($path, $action) {
        $this->addRoute('POST', $path, $action);
    }

    // Add route for any HTTP method
    public function addRoute($method, $path, $action) {
        $this->routes[$method][$path] = $action;
    }

    // Dispatch the request
    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'] ?? '/';

        // Remove query parameters
        $path = strtok($path, '?');

        // Default Route to Login
        if ($path == '/' || $path == '/index.php') {
            $path = '/login';
        }

        // Match the route
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $action) {
                // Convert route to regex
                $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $route);
                $routePattern = '#^' . $routePattern . '$#';

                // Check if the route matches the current path
                if (preg_match($routePattern, $path, $matches)) {
                    // Extract controller and method from the action
                    [$controller, $methodName] = $action;

                    // Prepend the namespace to the controller
                    $controllerName = $controller;

                    // Instantiate the controller
                    if (class_exists($controllerName)) {
                        $controllerObj = new $controllerName();

                        // Call the controller method
                        if (method_exists($controllerObj, $methodName)) {
                            // Pass matched parameters to the controller method
                            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                            echo call_user_func_array([$controllerObj, $methodName], $params);
                            return;
                        } else {
                            http_response_code(500);
                            echo "Error: Method '$methodName' not found in '$controllerName'.";
                            return;
                        }
                    } else {
                        http_response_code(500);
                        echo "Error: Controller '$controllerName' not found.";
                        return;
                    }
                }
            }
        }

        // If no route matches, show a 404 error
        http_response_code(404);
        echo "404 Not Found - Route '$path' not found.";
    }
}
