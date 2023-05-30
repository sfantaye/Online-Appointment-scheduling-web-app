<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "appointments";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data and sanitize input
$name = sanitizeInput($_POST["name"]);
$email = sanitizeInput($_POST["email"]);
$phone = sanitizeInput($_POST["phone"]);
$date = sanitizeInput($_POST["date"]);
$time = sanitizeInput($_POST["time"]);
$service = sanitizeInput($_POST["service"]);
$comments = sanitizeInput($_POST["comments"]);

// Prepare and execute the SQL query
$stmt = $conn->prepare("INSERT INTO appointment (name, email, phone, date, time, comments) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $email, $phone, $date, $time, $comments);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Appointment scheduled successfully.";
} else {
    echo "Error occurred while scheduling the appointment.";
}

$stmt->close();
$conn->close();

// Function to sanitize user input
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>
