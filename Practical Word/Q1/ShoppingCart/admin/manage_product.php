<?php
include('../db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $category = $_POST['product_category'];

        $image = $_FILES['product_image']['name'];
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_folder = "../images/$image"; 

        if (move_uploaded_file($image_tmp, $image_folder)) {
            $stmt = $conn->prepare("INSERT INTO products (name, price, category_id, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $name, $price, $category, $image);
            $stmt->execute();
            echo "Product added!";
        } else {
            echo "Failed to upload image.";
        }
    } elseif ($action === 'delete') {
        $productId = $_POST['product_id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        echo "Product deleted!";
    } elseif ($action === 'edit') {
        $productId = $_POST['product_id'];
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
    } elseif ($action === 'update') {
        $productId = $_POST['product_id'];
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $category = $_POST['product_category'];

        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, category_id = ? WHERE id = ?");
        $stmt->bind_param("sdii", $name, $price, $category, $productId);
        $stmt->execute();
        echo "Product updated!";
    }
}

$products = $conn->query("SELECT * FROM products");
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 20px;
        }
        h2, h3 {
            text-align: center;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"], select {
            padding: 8px;
            width: 200px;
            margin: 5px 0;
        }
        input[type="submit"] {
            padding: 8px 12px;
            margin: 5px;
            border: none;
            cursor: pointer;
            background-color: #3498db;
            color: white;
        }
        ul {
            list-style-type: none;
            padding: 0;
            width: 50%;
            margin: 0 auto;
        }
        li {
            background-color: #fff;
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        img {
            max-width: 50px;
            max-height: 50px;
        }
    </style>
</head>
<body>

<h2>Manage Products</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Product Name: </label>
    <input type="text" name="product_name" required /><br/>
    <label>Price: </label>
    <input type="number" step="0.01" name="product_price" required /><br/>
    <label>Category: </label>
    <select name="product_category">
        <?php while ($cat = $categories->fetch_assoc()) : ?>
            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
        <?php endwhile; ?>
    </select><br/>
    <label>Product Image: </label>
    <input type="file" name="product_image" required /><br/>
    <input type="hidden" name="action" value="add" />
    <input type="submit" value="Add Product" />
    
    <a href="index.php">Back</a>
</form>

<h3>Product List</h3>

<ul>
    <?php while ($prod = $products->fetch_assoc()) : ?>
        <li>
            <span><?php echo $prod['name']; ?> - $<?php echo number_format($prod['price'], 2); ?></span>
            <img src="../images/<?php echo $prod['image']; ?>" alt="<?php echo $prod['name']; ?>" />
            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>" />
                <input type="hidden" name="action" value="edit" />
                <input type="submit" value="Edit" />
            </form>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="product_id" value="<?php echo $prod['id']; ?>" />
                <input type="hidden" name="action" value="delete" />
                <input type="submit" value="Delete" />
            </form>
        </li>
    <?php endwhile; ?>
</ul>

<?php if (isset($product)): ?>
    <h3>Edit Product</h3>
    <form method="POST" enctype="multipart/form-data">
        <label>Product Name: </label>
        <input type="text" name="product_name" value="<?php echo $product['name']; ?>" required /><br/>
        <label>Price: </label>
        <input type="number" step="0.01" name="product_price" value="<?php echo $product['price']; ?>" required /><br/>
        <label>Category: </label>
        <select name="product_category">
            <?php 
            $categories->data_seek(0); 
            while ($cat = $categories->fetch_assoc()) : ?>
                <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $product['category_id']) echo 'selected'; ?>>
                    <?php echo $cat['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br/>
        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>" />
        <input type="hidden" name="action" value="update" />
        <input type="submit" value="Update Product" />
    </form>
<?php endif; ?>

</body>
</html>
