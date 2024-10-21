<?php
$directory = 'C:\\xampp\\htdocs\\ShoppingCart';

if (is_dir($directory)) {
    $files = scandir($directory);
    
    $files = array_diff($files, array('.', '..'));

    echo "<h2>Files in the directory:</h2>";
    echo "<ul>";
    foreach ($files as $file) {
        echo "<li>" . htmlspecialchars($file) . "</li>"; 
    }
    echo "</ul>";
} else {
    echo "<h2>Directory does not exist.</h2>";
}
?>
