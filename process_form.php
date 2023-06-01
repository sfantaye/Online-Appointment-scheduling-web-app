<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "addisappointer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $service = $_POST["service"];
    $comments = $_POST["comments"];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO appointment (name, email, phone, date, time, service,comments) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $date, $time, $comments);

    if ($stmt->execute()) {
        echo "Form data inserted successfully.";
    } else {
        echo "Error inserting form data: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
