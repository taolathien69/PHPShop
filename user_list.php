<?php
// Include the header
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
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

        .users {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .users li {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .users li .btn-group {
            margin-top: 10px;
        }

        .users li .btn {
            margin-right: 10px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: bold;
            padding: 8px 16px;
            cursor: pointer;
        }

        .users li .btn-edit {
            background-color: #007bff;
        }

        .users li .btn-edit:hover {
            background-color: #0056b3;
        }

        .users li .btn-delete {
            background-color: #dc3545;
        }

        .users li .btn-delete:hover {
            background-color: #c82333;
        }

        .users li h3 {
            margin: 0 0 10px;
        }
    </style>
</head>

<body>
    <!-- <div class="auth-links">
        <?php if (isset($_SESSION['user'])) : ?>
            <a href="index.php?action=logout" class="btn btn-danger">Logout</a>
        <?php else : ?>
            <a href="index.php?action=login" class="btn btn-primary">Login</a>
        <?php endif; ?>
        <a href="index.php?action=register" class="btn btn-success">Register</a>
        <a href="cart.php" class="btn btn-primary">Cart</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
            <a href="index.php?action=add" class="btn btn-success">Add Product</a>
            <a href="index.php?action=add" class="btn btn-success">Add Account</a>
        <?php endif; ?>
    </div> -->

    <h1>User List</h1>
    <a href="index.php?" class="btn btn-back">Quay lại danh sách</a>

    <?php if (isset($users) && !empty($users)) : ?>
        <ul class="users">
            <?php foreach ($users as $user) : ?>
                <li>
                    <h3><?php echo $user['username']; ?></h3>
                    <p>Fullname: <?php echo $user['fullname']; ?></p>
                    <p>Email: <?php echo $user['email']; ?></p>
                    <!-- Thêm thông tin khác nếu cần -->

                  
                     <p>Role: <?php  echo $user['role']; 
                                ?></p>

                    <!-- Bổ sung thêm các nút chỉnh sửa hoặc xóa nếu cần -->

                    <!-- <div class="btn-group">
                        <a href="edit_user.php?id=<?php // echo $user['id']; 
                                                    ?>" class="btn btn-edit">Edit</a>
                        <a href="delete_user.php?id=<?php // echo $user['id']; 
                                                        ?>" class="btn btn-delete">Delete</a>
                    </div> -->
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No users found.</p>
    <?php endif; ?>
</body>

</html>
<?php
// Include the header
include 'footer.php';
?>