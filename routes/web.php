<?php

use App\Controllers\AuthController;
use App\controllers\UserController;
use App\Controllers\AdminController;
use App\controllers\BrandController;
use App\controllers\ProductController;
use App\controllers\SettingController;
use App\Controllers\CustomerController;
use App\Controllers\DashboardController;
use App\controllers\OrderStatusController;
use App\controllers\ProductCategoryController;
use App\controllers\CartController;

// LOGIN ROUTE
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);


// Admin Routes (Protected)
$router->get('/admin', [AdminController::class, 'index']);


// SETTINGS ROUTES
$router->get('/settings', [SettingController::class, 'index']);

// BRAND ROUTES
$router->get('/brand', [BrandController::class, 'index']);
$router->post('/brand/store', [BrandController::class, 'store']);

// ORDER STATUS ROUTES
$router->get('/order_status', [OrderStatusController::class, 'index']);
$router->post('/order_status/store', [OrderStatusController::class,'store']);
$router->post('/order_status/update/{id}', [OrderStatusController::class,'update']);

// PRODUCT ROUTES
$router->get('/products', [ProductController::class, 'index']);
$router->get('/products/create', [ProductController::class, 'create']);
$router->post('/products/store', [ProductController::class, 'store']);
$router->get('/products/edit/{id}', [ProductController::class, 'edit']);
$router->post('/products/update/{id}', [ProductController::class, 'update']);

// PRODUCT CATEGORY ROUTES
$router->get('/product_category', [ProductCategoryController::class, 'index']);
$router->get('/product_category/create', [ProductCategoryController::class, 'create']);
$router->post('/product_category/store', [ProductCategoryController::class, 'store']);
$router->post('/product_category/update/{id}', [ProductCategoryController::class, 'update']);

// USER 
$router->get('/user', [UserController::class, 'index']);

// CUSTOMER DASHBOARD ROUTES (Protected)
$router->get('/customer/dashboard', [CustomerController::class, 'index']);
$router->get('/customer/profile', [CustomerController::class, 'profile']);
$router->get('/customer/orders', [CustomerController::class, 'orders']);
$router->get('/customer/cart', [CustomerController::class, 'cart']);
$router->get('/customer/product_detail', [CustomerController::class, 'viewProduct']);


// CART ROUTES
$router->post('/customer/cart/store',[CartController::class, 'store']);