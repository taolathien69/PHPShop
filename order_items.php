<?php
session_start();
include 'header.php';
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    // Nếu không, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit;
}

// Kết nối cơ sở dữ liệu
require_once 'db_config.php';

// Lấy order_id từ phương thức GET
if (!isset($_GET['order_id'])) {
    // Nếu không có order_id được cung cấp, chuyển hướng người dùng đến trang trước
    header("Location: order_list.php"); // Thay đổi previous_page.php bằng trang trước đó của bạn
    exit;
}
$orderID = $_GET['order_id'];

// Lấy thông tin về các mặt hàng trong đơn đặt hàng từ cơ sở dữ liệu
$sql = "SELECT Order_Items.*, Products.Name AS ProductName, Products.Price AS ProductPrice
        FROM Order_Items
        INNER JOIN Products ON Order_Items.ProductID = Products.ProductID
        WHERE Order_Items.OrderID = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$orderID]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Items</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
    </style>
</head>

<body>
    <h1>Order Items</h1>
    <a href="order_list.php" class="btn-back">Quay lại danh sách</a>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach ($orderItems as $item) : ?>
            <tr>
                <td><?php echo $item['ProductID']; ?></td>
                <td><?php echo $item['ProductName']; ?></td>
                <td><?php echo $item['ProductPrice']; ?></td>
                <td><?php echo $item['Quantity']; ?></td>
                <td><?php echo $item['Price']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php include 'footer.php'; ?>
</body>

</html>
