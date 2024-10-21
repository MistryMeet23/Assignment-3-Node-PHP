<?php
session_start();
include('../db/db.php');

$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

if ($category_id) {
    $query = "SELECT `id`, `name`, `price`, `category_id`, `image` FROM `products` WHERE category_id = $category_id";
    $result = $conn->query($query);
} else {
    echo "No category selected.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - MG Shopping Mart</title>
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
            max-width: 1200px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s; 
            width: 250px; 
        }
        .product-card:hover {
            transform: scale(1.05); 
        }
        .product-card a {
            text-decoration: none;
            color: #007bff;
            font-size: 18px;
        }
        .product-card a:hover {
            text-decoration: underline;
        }
        .product-name {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        .product-price {
            color: #007bff;
            font-weight: bold;
            margin: 10px 0;
        }
        .product-card img {
            width: 100%;
            height: auto; 
            border-radius: 8px;
            margin-bottom: 10px;
            max-height: 200px;
            object-fit: cover; 
        }
        .product-description {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
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
    <h2>Products in Selected Category</h2>
    <?php if ($result->num_rows > 0): ?>
        <div class="product-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <a href="product-details.php?product_id=<?php echo $row['id']; ?>">
                        <img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" />
                        <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
                    </a>
                    <div class="product-price">₹<?php echo number_format($row['price'], 2); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>No products available in this category.</p>
    <?php endif; ?>
</div>

</body>
</html>
