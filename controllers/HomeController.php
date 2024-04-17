<?php
require_once 'models/ProductModel.php';

class HomeController {
    public $productModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db);
    }

    public function index() {
        if (isset($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            $products = $this->productModel->searchProducts($keyword);
        } else {
            $products = $this->productModel->getAllProducts();
        }
        include 'home.php'; 
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_FILES['image']['name'];
    
            // Đường dẫn tới thư mục lưu trữ ảnh
            $targetDirectory = 'assets/images/';
            $targetFilePath = $targetDirectory . $image;
    
            // Di chuyển ảnh tải lên vào thư mục lưu trữ
            move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath);
    
            $result = $this->productModel->addProduct($name, $description, $price, $image);
            if ($result) {
                // Lấy danh sách sản phẩm
                $products = $this->productModel->getAllProducts();
                        
                // Chuyển hướng đến trang home.php sau khi đăng nhập thành công
                include 'home.php';
                exit;
            } else {
                echo "Failed to add product";
            }
        }
    
        include 'add_product.php';
    }    
    
    public function editProduct($productId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_POST['image'];
    
            $result = $this->productModel->updateProduct($productId, $name, $description, $price, $image);
            if ($result) {
                    // Lấy danh sách sản phẩm
                    $products = $this->productModel->getAllProducts();
    
                    // Chuyển hướng đến trang home.php sau khi đăng nhập thành công
                    include 'home.php';
                    exit;;
            } else {
                echo "Failed to update product";
            }
        }
    
        $product = $this->productModel->getProductById($productId);
        include 'edit_product.php';
    }
    
    public function deleteProduct($productId) {
        // Xác nhận nếu phương thức là POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->productModel->deleteProduct($productId);
            if ($result) {
                // Chuyển hướng đến trang home.php sau khi xóa thành công
                header("Location: index.php");
                exit;
            } else {
                echo "Failed to delete product";
            }
        }
    
        // Nếu không phải là POST, hiển thị form xác nhận
        $product = $this->productModel->getProductById($productId);
        include 'delete_product.php';
    }
    
}