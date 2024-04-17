<?php
session_start();
// Include the header
include 'header.php';
// Kiểm tra nếu giỏ hàng chưa được tạo thì tạo mới
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kết nối cơ sở dữ liệu
require_once 'db_config.php';

// Hàm lấy thông tin chi tiết của một sản phẩm từ cơ sở dữ liệu
function getProductDetails($productId, $db)
{
    $sql = "SELECT * FROM Products WHERE ProductID = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $productId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
// Tính tổng số tiền trong giỏ hàng
$totalPrice = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $product = getProductDetails($productId, $db);
        $subtotal = $product['Price'] * $quantity;
        $totalPrice += $subtotal;
    }
}

// Xử lý khi người dùng nhấn vào nút "x" để xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_product'])) {
    $removeProductId = $_POST['remove_product_id'];
    // Xóa sản phẩm khỏi giỏ hàng
    unset($_SESSION['cart'][$removeProductId]);
    // Chuyển hướng trang
    echo "<script>window.location.href = 'cart.php';</script>";
    exit;
}

// Xử lý khi người dùng cập nhật số lượng sản phẩm
if (isset($_POST['update_quantity_submit'])) {
    $updateProductId = $_POST['update_product_id'];
    $newQuantity = $_POST['update_quantity'];
    if ($newQuantity > 0) {
        // Cập nhật số lượng mới cho sản phẩm
        $_SESSION['cart'][$updateProductId] = $newQuantity;
        // Chuyển hướng trang
        echo "<script>window.location.href = 'cart.php';</script>";
        exit;
    }
}

// Xử lý khi người dùng nhấn vào nút "Đặt hàng"
if (isset($_POST['place_order'])) {
    // Lưu thông tin đặt hàng và thông tin người đặt vào cơ sở dữ liệu
    // Lấy thông tin người dùng từ phiên đăng nhập hoặc yêu cầu người dùng nhập thông tin
    // Đây là nơi để thêm code xử lý lưu thông tin đặt hàng và người đặt
    // Thêm thông tin đặt hàng vào bảng "Orders"
    $userID = $_SESSION['user_id']; // Đây là ID của người dùng, bạn cần thay đổi hoặc lấy từ phiên đăng nhập
    $totalAmount = $totalPrice; // Tổng số tiền của đơn hàng
    $orderDate = date('Y-m-d H:i:s'); // Ngày đặt hàng

    $insertOrderQuery = "INSERT INTO Orders (UserID, total_amount, OrderDate) VALUES (?, ?, ?)";
    $stmt = $db->prepare($insertOrderQuery);
    $stmt->execute([$userID, $totalAmount, $orderDate]);

    // Lấy ID của đơn hàng vừa tạo
    $orderID = $db->lastInsertId();

    // Thêm thông tin chi tiết đơn hàng vào bảng "Order_Items"
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $product = getProductDetails($productId, $db);
        $price = $product['Price'];

        $insertOrderItemQuery = "INSERT INTO Order_Items (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($insertOrderItemQuery);
        $stmt->execute([$orderID, $productId, $quantity, $price]);
    }

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // Hiển thị thông báo đặt hàng thành công và có thể chuyển hướng người dùng đến trang cảm ơn hoặc trang xác nhận đặt hàng.
    $successMessage = "Đặt hàng thành công! Cảm ơn bạn đã mua hàng!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .auth-links {
            margin-bottom: 20px;
        }

        .auth-links a {
            display: inline-block;
            padding: 10px 20px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        form {
            display: inline;
        }

        input[type=submit] {
            background-color: #04AA6D;
            border: none;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-back {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: #0056b3;
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            text-align: center;
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Giao diện giỏ hàng -->
    <h1>Shopping Cart</h1>
    <table>
        <tr>
            <th>Product</th>
            <th>Image</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
        <?php if (!empty($_SESSION['cart'])) : ?>
            <?php foreach ($_SESSION['cart'] as $productId => $quantity) : ?>
                <?php
                // Lấy thông tin chi tiết của sản phẩm
                $product = getProductDetails($productId, $db);
                // Tính tổng số tiền cho từng sản phẩm
                $subtotal = $product['Price'] * $quantity;
                $totalPrice += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['Name']); ?></td>
                    <td> <img src="assets/images/<?php echo htmlspecialchars($product['Image']); ?>" alt="<?php echo htmlspecialchars($product['Name']); ?>" style="max-width: 300px; max-height: 300px;"></td>
                    <td><?php echo nl2br(htmlspecialchars($product['Description'])); ?></td>
                    <td>$<?php echo number_format($product['Price'], 2); ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="update_product_id" value="<?php echo $productId; ?>">
                            <input type="number" name="update_quantity" value="<?php echo $quantity; ?>" min="1" max="100" style="width: 60px;">
                            <button type="submit" name="update_quantity_submit">Update</button>
                        </form>
                    </td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <form method="post" onsubmit="return confirm('Are you sure you want to remove this item?');">
                            <input type="hidden" name="remove_product_id" value="<?php echo $productId; ?>">
<button type="submit" name="remove_product" style="color: red; font-weight: bold;">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7" style="text-align: center;">No items in cart</td>
            </tr>
        <?php endif; ?>
    </table>
    <!-- Hiển thị tổng số tiền và nút đặt hàng -->
    <h3>Total Price: <?php echo number_format($totalPrice, 2); ?> VND</h3>
    <form method="post">
        <input type="submit" name="place_order" value="Đặt Hàng">
    </form>
    <a href="index.php?" class="btn-back">Quay lại danh sách</a>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <p><?php echo isset($successMessage) ? $successMessage : ''; ?></p>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        <?php echo isset($successMessage) ? "modal.style.display = 'block';" : ""; ?>

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>
<?php
// Include the header
include 'footer.php';
?>