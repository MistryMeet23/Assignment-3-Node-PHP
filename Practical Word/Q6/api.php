<?php
header("Content-Type: application/json");

$data = [
    ["id" => 1, "name" => "Meet", "email" => "meet@example.com"],
    ["id" => 2, "name" => "Gunjan", "email" => "gunjan@example.com"]
];

echo json_encode($data);
?>