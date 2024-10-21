<?php
session_start();

// Generate a random 4-digit number
$captcha_code = strval(rand(1000, 9999));

// Store the CAPTCHA code in the session
$_SESSION['captcha_code'] = $captcha_code;

header('Content-type: image/png');

// Create a blank image
$image = imagecreatetruecolor(100, 40);

// Colors
$bg_color = imagecolorallocate($image, 255, 255, 255); // White background
$text_color = imagecolorallocate($image, 0, 0, 0); // Black text

// Fill the background
imagefilledrectangle($image, 0, 0, 100, 40, $bg_color);

// Add the CAPTCHA code to the image
imagestring($image, 5, 25, 10, $captcha_code, $text_color);

// Output the image as PNG
imagepng($image);

// Free up resources
imagedestroy($image);
?>
