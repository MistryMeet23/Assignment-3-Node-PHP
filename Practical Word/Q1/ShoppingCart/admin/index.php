<?php
session_start();
include('../db/db.php'); // Ensure the db.php path is correct

// Check the page parameter
$page = isset($_GET['page']) ? $_GET['page'] : '';

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy(); // End the session
    header("Location: ../index.php"); // Redirect to the main index file
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .nav-links {
            text-align: center;
            margin: 20px 0;
        }
        .nav-links a {
            margin: 0 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 18px;
        }
        .nav-links a:hover {
            color: #0056b3;
        }
        
    </style>
</head>
<body>

<div class="container">
    <h1>Admin Dashboard</h1>

    <div class="nav-links">
        <a href="manage_category.php">Manage Categories</a>
        <a href="manage_product.php">Manage Products</a>
        <a href="?action=logout">Logout</a> <!-- Logout link -->
    </div>
</div>
</body>
</html>
