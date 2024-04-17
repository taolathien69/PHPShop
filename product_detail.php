<?php
session_start();
// Include the header
include 'header.php';
// Kết nối cơ sở dữ liệu
require_once 'db_config.php';

// Lấy ProductID từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM Products WHERE ProductID = ?";
$stmt = $db->prepare($sql);
$stmt->bindParam(1, $product_id, PDO::PARAM_INT);
$stmt->execute();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; // Số lượng mặc định là 1

        // Thêm sản phẩm vào giỏ hàng với số lượng chọn
        $_SESSION['cart'][$productId] = $quantity;

        // Không cần chuyển hướng tại đây
        exit;
    }
}
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['Name']); ?></title>
    <style>
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
    </style>
    <script>
        function addToCart(productId, quantity) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "product_detail.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Sản phẩm đã được thêm vào giỏ hàng, bạn có thể thực hiện các hành động khác ở đây nếu cần
                    console.log("Product added to cart successfully.");
                }
            };
            xhr.send("product_id=" + productId + "&quantity=" + quantity); // Gửi cả ID và số lượng
        }
    </script>
</head>

<body>

    <h1>Details</h1>
    <strong><?php echo htmlspecialchars($product['Name']); ?></strong><br>
    <p><strong>Descripton: </strong><?php echo nl2br(htmlspecialchars($product['Description'])); ?><br></p>
    <p><strong>Price: </strong> <?php echo number_format($product['Price'], 2); ?> VND</p>
    <img src="assets/images/<?php echo htmlspecialchars($product['Image']); ?>" width="300px" height="300px" alt="<?php echo htmlspecialchars($product['Name']); ?>">

    <p></p>
    <form onsubmit="addToCart(<?php echo $product['ProductID']; ?>, this.quantity.value); return false;">
        <label for="quantity"><strong>Quantity:</strong></label>
        <input type="number" id="quantity" name="quantity" value="1" min="1" max="10"> <!-- Đặt giá trị min và max theo ý muốn -->
        <input type="submit" value="Add to Cart">
    </form>
    <p></p>
    <a href="index.php?" class="btn-back">Quay lại danh sách</a>

    <p></p>
    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>

</html>
