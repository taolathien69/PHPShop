<?php
require_once 'db_config.php';
require_once 'models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct() {
        global $db;
        $this->productModel = new ProductModel($db);
    }

    public function index() {
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $products = $this->productModel->searchProducts($keyword);
        } else {
            $products = $this->productModel->getAllProducts();
        }
        include 'product_list.php'; 
    }
    
    public function detailProduct($productId) {
        $product = $this->productModel->getProductById($productId);
        if ($product) {
            include 'product_detail.php';
        } else {
            echo "Product not found";
        }
    }
}

?>