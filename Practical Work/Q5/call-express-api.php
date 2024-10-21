<?php
$url = 'http://localhost:3000/api/data';
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    echo 'Response from Express: ' . $data['message'];
}

curl_close($ch);
?>
