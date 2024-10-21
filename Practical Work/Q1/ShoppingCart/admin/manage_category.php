<?php
include('../db/db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add' && isset($_POST['category_name'])) {
        $category = $_POST['category_name'];
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        echo "Category added!";
    }

    elseif ($action === 'delete' && isset($_POST['category_id'])) {
        $categoryId = $_POST['category_id'];
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        echo "Category deleted!";
    }

    elseif ($action === 'edit' && isset($_POST['category_name']) && isset($_POST['category_id'])) {
        $category = $_POST['category_name'];
        $categoryId = $_POST['category_id'];
        $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $category, $categoryId);
        $stmt->execute();
        echo "Category updated!";
    }
}

$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
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
        input[type="text"] {
            padding: 8px;
            width: 200px;
            margin: 5px 0;
        }
        input[type="submit"], .edit-btn, .delete-btn {
            padding: 8px 12px;
            margin: 5px;
            border: none;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #f39c12;
            color: white;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }
        input[type="submit"] {
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
        .button-group {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>

<h2>Manage Categories</h2>

<form method="POST">
    <label>Category Name: </label>
    <input type="text" name="category_name" required />
    <input type="hidden" name="action" value="add" />
    <input type="submit" value="Add Category" />
    <a href="index.php">Back</a>
</form>

<h3>Category List</h3>
<ul>
    <?php while ($cat = $categories->fetch_assoc()) : ?>
        <li>
            <?php echo $cat['name']; ?>
            <div class="button-group">
                <form method="POST" style="display:inline;">
                    <input type="text" name="category_name" value="<?php echo $cat['name']; ?>" required />
                    <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>" />
                    <input type="hidden" name="action" value="edit" />
                    <input class="edit-btn" type="submit" value="Edit" />
                </form>

                <form method="POST" style="display:inline;">
                    <input type="hidden" name="category_id" value="<?php echo $cat['id']; ?>" />
                    <input type="hidden" name="action" value="delete" />
                    <input class="delete-btn" type="submit" value="Delete" />
                </form>
            </div>
        </li>
    <?php endwhile; ?>
</ul>

</body>
</html>
