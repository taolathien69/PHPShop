<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
        }

        p {
            margin-bottom: 16px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-back {
            background-color: #6c757d;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-back:hover {
            background-color: #495057;
        }

        form {
            margin-top: 16px;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Confirm Delete</h2>
        <p>Are you sure you want to delete this product?</p>
        <p>
            <strong>Name:</strong> <?php echo $product['Name']; ?><br>
            <img src="assets/images/<?php echo htmlspecialchars($product['Image']); ?>" width="300px" height="300px" alt="<?php echo htmlspecialchars($product['Name']); ?>"><br>
            <strong>Description:</strong> <?php echo $product['Description']; ?><br>
            <strong>Price:</strong> <?php echo $product['Price']; ?><br>
        </p>
        <form method="POST" action="index.php?action=delete&id=<?php echo $productId; ?>" onsubmit="return confirmDelete();">
            <input type="submit" name="confirm_delete" value="Yes">
            <a href="index.php" class="btn btn-back">No</a>
        </form>
    </div>

    <script>
        // JavaScript để hiển thị cửa sổ xác nhận khi nhấn vào nút "Delete"
        function confirmDelete() {
            var result = confirm("Are you sure you want to delete this product?");
            if (result) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>
</html>
