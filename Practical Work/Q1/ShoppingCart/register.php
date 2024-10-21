<?php
session_start();
require_once 'db/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $email = $_POST['email'];
    $captcha = $_POST['captcha'];
    $role = 'user'; 

    if ($captcha === $_SESSION['captcha_code']) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $password, $email, $role);
            $stmt->execute();
            $success = "User registered successfully!";
            header('Location: login.php'); 
            exit();
        }
    } else {
        $error = "CAPTCHA validation failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MG Shopping Mart</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .navbar { background-color: #007bff; padding: 15px; color: white; text-align: center; }
        .container { width: 80%; max-width: 400px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        input[type="text"], input[type="password"], input[type="email"] { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        input[type="submit"] { background-color: #007bff; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: red; text-align: center; }
        .success { color: green; text-align: center; }
    </style>
</head>
<body>
<div class="navbar"><h1>MG Shopping Mart</h1></div>
<div class="container">
    <h2>Register</h2>
    <?php if (isset($error)): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
    <?php if (isset($success)): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
    <form method="POST" action="">
        <label>Username:</label><input type="text" name="username" required><br/>
        <label>Password:</label><input type="password" name="password" required><br/>
        <label>Email:</label><input type="email" name="email" required><br/>
        <label>CAPTCHA:</label>
        <input type="text" name="captcha" required>
        <img src="captcha_image.php" alt="CAPTCHA" style="vertical-align: middle;"><br/>
        <input type="submit" value="Register">
    </form>
</div>
</body>
</html>
