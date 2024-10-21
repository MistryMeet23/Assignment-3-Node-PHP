<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "shopping_cart";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $xml = new SimpleXMLElement('<students/>');

    while($row = $result->fetch_assoc()) {
        $student = $xml->addChild('student');
        $student->addChild('id', $row['id']);
        $student->addChild('name', $row['name']);
        $student->addChild('age', $row['age']);
        $student->addChild('course', $row['course']);
    }

    $xml->asXML('students.xml');
    echo "Data exported to students.xml file";
} else {
    echo "0 results";
}

$conn->close();
?>