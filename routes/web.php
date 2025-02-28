<?php

use App\Controllers\AuthController;
use App\controllers\UserController;
use App\Controllers\AdminController;
use App\controllers\BrandController;
use App\controllers\ProductController;
use App\controllers\SettingController;
use App\Controllers\CustomerController;
use App\controllers\OrderStatusController;
use App\controllers\ProductCategoryController;
use App\controllers\CartController;
use App\controllers\LocationController;
use App\controllers\OrderController;
use App\controllers\PdfController;
use App\controllers\ProductStatusController;
use App\controllers\RegisterController;



// REGISTER ROUTE
$router->get('/register', [RegisterController::class, 'showRegister']);
$router->post('/register/store', [RegisterController::class, 'store']);

// LOCATION ROUTE
$router->post('/get-provinces', [LocationController::class, 'getProvinces']);
$router->post('/get-citymun', [LocationController::class, 'getCityMun']);
$router->post('/get-brgy', [LocationController::class, 'getBrgy']);


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
$router->get('/brand/create', [BrandController::class, 'create']);
$router->post('/brand/store', [BrandController::class, 'store']);

// ORDER STATUS ROUTES
$router->get('/order_status', [OrderStatusController::class, 'index']);
$router->post('/order_status/store', [OrderStatusController::class,'store']);
$router->post('/order_status/update/{id}', [OrderStatusController::class,'update']);
$router->get('/order_status/delete/{id}', [OrderStatusController::class,'delete']);


// PRODUCT STATUS ROUTE 

$router->get('/product_status', [ProductStatusController::class, 'index']);
$router->post('/product_status/store', [ProductStatusController::class, 'store']);
$router->post('/product_status/update/{id}', [ProductStatusController::class, 'update']);
$router->get('/product_status/delete/{id}', [ProductStatusController::class, 'delete']);

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

// Product Search Route (AJAX)
$router->post('/customer/search', [CustomerController::class, 'search']);

// CART ROUTES
$router->post('/customer/cart/store',[CartController::class, 'store']);
$router->post('/customer/cart/updateQuantity/{id}',[CartController::class, 'updateQuantity']);
$router->post('/customer/cart/OrderSelected', [CartController::class, 'OrderSelected']);
$router->get('/customer/cart/delete/{id}', [CartController::class, 'deleteCart']);

$router->get('/customer/category', [CustomerController::class, 'viewCategory']);
$router->get('/customer/viewCategory', [CustomerController::class, 'OpenCategory']);


// ORDER ROUTE 

$router->get('/orders', [OrderController::class,'index']);
$router->get('/orders/order_details', [OrderController::class,'edit']);


$router->post('/orders/updateOrderStatus', [OrderController::class, 'updateOrderStatus']);


// REPORT PDF ROUTE
$router->get('/pdf/generateOrderPdf', [PdfController::class, 'generateOrderPdf']);
$router->get('/pdf/viewPdfReport', [PdfController::class, 'viewPdfReport']);