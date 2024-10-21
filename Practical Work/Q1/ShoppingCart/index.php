<?php
session_start();
require_once 'db/db.php'; // Ensure this path is correct for your database connection

// Fetch categories from the database
$query = "SELECT id, name FROM categories WHERE 1";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MG Shopping Mart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #007bff;
            padding: 15px;
            color: white;
            text-align: center;
        }
        .navbar a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Space between cards */
            justify-content: center; /* Center align the cards */
        }
        .category-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s; /* Add a transition effect */
            width: 200px; /* Set card width */
        }
        .category-card:hover {
            transform: scale(1.05); /* Scale effect on hover */
        }
        .category-card a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
        }
        .category-card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>MG Shopping Mart</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <a href="logout.php">Logout</a>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    <?php endif; ?>
</div>

<div class="container">
    <h2>Welcome to MG Shopping Mart</h2>
    <p>Select a category to view products:</p>

    <?php if ($result->num_rows > 0): ?>
        <div class="category-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="category-card">
                    <a href="user/product.php?category_id=<?php echo $row['id']; ?>">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No categories available.</p>
    <?php endif; ?>
</div>

</body>
</html>