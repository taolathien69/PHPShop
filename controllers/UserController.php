<?php
require_once 'db_config.php';
require_once 'models/UserModel.php';
require_once 'models/ProductModel.php';
class UserController {
    private $userModel;
    private $productModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
        $this->productModel = new ProductModel($db);
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        if (!empty($products)) {
            include 'home.php';
            exit;
        } else {
            echo "No products found."; // Để kiểm tra xem có sản phẩm nào được lấy không
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];

            // Kiểm tra xem tên người dùng đã tồn tại chưa
            if ($this->userModel->getUserByUsername($username)) {
                echo "Tên người dùng đã tồn tại. Vui lòng chọn tên người dùng khác.";
                return;
            }

            // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Tạo người dùng mới
            $user = [
                'username' => $username,
                'password' => $hashedPassword,
                'fullname' => $fullname,
                'email' => $email,
                'role' => 'user'
            ];

            // Lưu người dùng vào cơ sở dữ liệu
            if ($this->userModel->registerUser($user)) {
                // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
                header('Location: index.php?action=login');
                exit;
            } else {
                echo "Đăng ký thất bại. Vui lòng thử lại sau.";
            }
        }

        include 'register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            // Kiểm tra xem người dùng có tồn tại không
            $user = $this->userModel->getUserByUsername($username);
            if (!$user) {
                echo "Tên người dùng không tồn tại.";
                return;
            }
    
            // Kiểm tra mật khẩu
            if (password_verify($password, $user['password'])) {
                // Đăng nhập thành công, lưu thông tin người dùng vào session
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $user['Id'];
                // Lấy danh sách sản phẩm
                $products = $this->productModel->getAllProducts();
    
                // Chuyển hướng đến trang home.php sau khi đăng nhập thành công
                include 'home.php';
                exit;
            } else {
                echo "Mật khẩu không chính xác.";
            }
        }
    
        include 'login.php';
    }

    public function logout() {
        // Xóa thông tin người dùng khỏi session để đăng xuất
        unset($_SESSION['user']);
        unset($_SESSION['cart']);
        // Chuyển hướng đến trang đăng nhập sau khi đăng xuất
        header('Location: index.php?action=login');
        exit;
    }
    public function userList() {
        // Lấy thông tin của tất cả người dùng từ cơ sở dữ liệu
        $users = $this->userModel->getAllUsers();
    
        // Kiểm tra xem có người dùng nào hay không
        if (!empty($users)) {
            // Nếu có người dùng, hiển thị trang user_list.php và truyền dữ liệu người dùng vào
            include 'user_list.php';
        } else {
            echo "No users found.";
        }
    }
}