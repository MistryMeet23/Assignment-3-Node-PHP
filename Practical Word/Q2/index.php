<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "shopping_cart";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$xml = simplexml_load_file('students.xml') or die("Error: Cannot create object");


foreach($xml->student as $student) {
    $id = $student->id;
    $name = $student->name;
    $age = $student->age;
    $course = $student->course;

    $sql = "INSERT INTO students (id, name, age, course) VALUES ('$id', '$name', '$age', '$course')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>