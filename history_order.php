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

// Lấy userID từ phiên đăng nhập
$userID = $_SESSION['user_id'];

// Lấy lịch sử đặt hàng của người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM Orders WHERE UserID = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$userID]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
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
    <h1>Order History</h1>
    <a href="index.php?" class="btn-back">Quay lại danh sách</a>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Total Amount</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?php echo $order['OrderID']; ?></td>
                <td><?php echo $order['total_amount']; ?></td>
                <td><?php echo $order['OrderDate']; ?></td>
                <td>
                    <form action="order_items.php" method="get">
                        <input type="hidden" name="order_id" value="<?php echo $order['OrderID']; ?>">
                        <button type="submit">View Order Items</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php include 'footer.php'; ?>
</body>

</html>
