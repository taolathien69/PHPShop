<?php
session_start();

require_once 'db_config.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ProductController.php';

$homeController = new HomeController($db);
$userController = new UserController($db);
$proController = new ProductController($db);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $productId = isset($_GET['id']) ? $_GET['id'] : null;

    switch ($action) {
        case 'add':
            $homeController->addProduct();
            break;
        case 'edit':
            $homeController->editProduct($productId);
            break;
        case 'delete':
            $homeController->deleteProduct($productId);
            break;
        case 'detail':
            $proController->detailProduct($productId);
            break;            
        case 'account':
            $userController->userList();
            break;            
        case 'register':
            $userController->register();
            break;
        case 'login':
            $userController->login();
            break;
        case 'logout':
            $userController->logout();
            break;    
        default:
            $homeController->index();
            $userController->index();
            break;
    }
} else {
    $homeController->index();
}