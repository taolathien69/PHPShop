<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .auth-links {
            display: none;
        }
        .auth-links a {
            display: inline-block;
            padding: 10px;
            margin-right: 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .auth-links .btn-primary {
            background-color: #007bff;
        }
        .auth-links .btn-success {
            background-color: #28a745;
        }
        .auth-links .btn-danger {
            background-color: #dc3545;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .products {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .products li {
            width: calc(22.22% - 20px); /* 3 sản phẩm trên mỗi dòng */
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .products li img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .products li .btn-group {
            margin-top: 10px;
        }
        .products li .btn {
            margin-right: 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: bold;
            padding: 8px 16px;
            cursor: pointer;
        }
        .products li .btn-edit {
            background-color: #007bff;
        }
        .products li .btn-edit:hover {
            background-color: #0056b3;
        }
        .products li .btn-delete {
            background-color: #dc3545;
        }
        .products li .btn-delete:hover {
            background-color: #c82333;
        }
        .products li h3 {
            margin: 0 0 10px;
        }
        .add-product-btn {
            display: block;
            margin: 20px auto;
        }
        .add-product-btn a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
        }
        .add-product-btn a:hover {
            background-color: #218838;
        }
        /* Navbar Styles */
        .navbar {
            background-color: #333;
            overflow: hidden;
            display: flex;
            justify-content: flex-start; /* Adjusted alignment */
            align-items: center;
            padding-left: 20px; /* Adjusted padding */
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 14px; /* Adjusted padding */
            text-align: center;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .navbar a.active {
            background-color: #333;
            color: white;
        }
        /* Combobox styles */
        .auth-dropdown {
            margin-right: 10px;
            position: relative;
        }
        .auth-dropdown select {
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #333;
            color: white;
            border: 1px solid #333;
            cursor: pointer;
        }
        .auth-dropdown select:focus {
            outline: none;
        }
        .auth-dropdown select::-ms-expand {
            display: none;
        }
        .auth-dropdown::after {
            content: '\25BC';
            color: #fff;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
        }
        /* Footer Styles */
        footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .footer-links a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        .footer-links a:hover {
            text-decoration: underline;
        }
        /*AddToCart btn Styles*/
        .add-to-cart-btn {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background-color: #0056b3;
        }
        /*Search Styles */
        .search-form {
            display: flex;
            align-items: center;
            max-width: 400px; /* Đặt chiều rộng tối đa cho form */
            margin: 0 auto; /* Canh giữa form */
        }
        .search-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <!-- Navbar -->
        <div class="navbar">
            <a href="index.php?" class="active">Home</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            <a href="cart.php" class="btn btn-primary">Cart</a>
            <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') : ?>
                <a href="index.php?action=account" class="btn btn-success">Accout</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['user'])) : ?>
                <?php if ($_SESSION['user']['role'] === 'admin') : ?>
                    <a href="order_list.php" class="btn btn-primary">List Order</a>
                <?php elseif ($_SESSION['user']['role'] === 'user') : ?>
                    <a href="history_order.php" class="btn btn-primary">Order History</a>
                <?php endif; ?>
            <?php endif; ?>
            <!-- Combobox -->
            <div class="auth-dropdown">
                <select id="authDropdown" onchange="handleAuthChange(this)">
                    <option value="" selected disabled>welcome</option>
                    <option value="login">Login</option>
                    <option value="register">Register</option>
                    <?php if(isset($_SESSION['user'])) : ?>
                        <option value="logout">Logout</option>
                    <?php endif; ?>
                </select>
            </div>
            <!-- Auth links -->
            <div class="auth-links">
                <a href="index.php?action=login" class="btn btn-primary">Login</a>
                <a href="index.php?action=register" class="btn btn-success">Register</a>
                <?php if(isset($_SESSION['user'])) : ?>
                    <a href="index.php?action=logout" class="btn btn-danger">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <!-- JavaScript to handle combobox change -->
    <script>
        function handleAuthChange(select) {
            var selectedOption = select.value;
            var authLinks = document.querySelector('.auth-links');
            switch (selectedOption) {
                case 'login':
                    authLinks.querySelector('.btn.btn-primary').click();
                    break;
                case 'register':
                    authLinks.querySelector('.btn.btn-success').click();
                    break;
                case 'logout':
                    authLinks.querySelector('.btn.btn-danger').click();
                    break;
                default:
                    break;
            }
        }
    </script>
</body>
</html>