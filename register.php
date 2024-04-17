<?php
// Include the header
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
        a {
            color: #007bff;
        }
        a:hover {
            color: #0056b3;
        }
        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333333f2;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        .footer-links {
            margin-bottom: 10px;
        }
        .footer-links a {
            margin-right: 10px;
            color: #fff;
            text-decoration: none;
        }
        .footer-links a:hover {
            color: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST" action="index.php?action=register">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
            <input type="submit" value="Register">
        </form>
        <p>You have an account? <a href="index.php?action=login">Login</a></p>
    </div>
    <footer>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">About Us</a>
            <a href="#">Contact Us</a>
        </div>
        <p>&copy; 2024 Nhom06 Company. All rights reserved.</p>
    </footer>
</body>
</html>
