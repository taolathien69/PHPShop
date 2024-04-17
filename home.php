<?php
// Include the header
include 'header.php';
?>
<script>
    function addToCart(productId) {
        var quantity = document.getElementById("quantity-" + productId).value;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "product_detail.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Sản phẩm đã được thêm vào giỏ hàng, bạn có thể thực hiện các hành động khác ở đây nếu cần
                console.log("Product added to cart successfully.");
            }
        };
        xhr.send("product_id=" + productId + "&quantity=" + quantity);
    }
</script>
<header>
    <h1>Products</h1>
    <form method="GET" action="index.php" class="search-form">
        <input type="text" name="keyword" placeholder="Enter keyword..." class="search-input">
        <button type="submit" class="search-button">Search</button>
    </form>
    <br>
    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') : ?>
        <div class="add-product-btn">
            <a href="index.php?action=add">Add Product</a>
        </div>
    <?php endif; ?>
</header>

<!-- Products -->
<?php if(isset($products) && !empty($products)): ?>
    <ul class="products">
        <?php foreach ($products as $product) : ?>
            <li>
                <!-- Thêm liên kết cho mỗi sản phẩm -->
                <a href="product_detail.php?id=<?php echo $product['ProductID']; ?>">
                    <h3><?php echo $product['Name']; ?></h3>
                </a>
                <p><?php echo $product['Description']; ?></p>
                <p>Price: <?php echo $product['Price']; ?></p>
                <img src="assets/images/<?php echo $product['Image']; ?>" width="300px" height="300px" alt="<?php echo $product['Name']; ?>">
                <div class="btn-group">
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') : ?>
                        <!-- Edit Product Button -->
                        <a href="index.php?action=edit&id=<?php echo $product['ProductID']; ?>" class="btn btn-edit">Edit</a>
                        <!-- Delete Product Button -->
                        <a href="index.php?action=delete&id=<?php echo $product['ProductID']; ?>" class="btn btn-delete">Delete</a>
                    <?php endif; ?>

                    <!-- Form để chọn số lượng -->
                    <p></p>
                    <form onsubmit="addToCart(<?php echo $product['ProductID']; ?>); return false;">
                        <label for="quantity-<?php echo $product['ProductID']; ?>">Quantity:</label>
                        <input type="number" id="quantity-<?php echo $product['ProductID']; ?>" name="quantity" value="1" min="1" max="10"> <!-- Đặt giá trị min và max theo ý muốn -->
                        <input type="submit" value="Add to Cart" class="add-to-cart-btn">
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

<?php
// Include the footer
include 'footer.php';
?>