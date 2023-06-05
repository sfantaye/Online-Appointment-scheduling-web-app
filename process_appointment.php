<?php
// Retrieve form data
$name = sanitizeInput($_POST['name']);
$email = sanitizeInput($_POST['email']);
$phone = sanitizeInput($_POST['phone']);
$service = sanitizeInput($_POST['service']);
$date = sanitizeInput($_POST['date']);
$time = sanitizeInput($_POST['time']);
$comments = sanitizeInput($_POST['comments']);

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate form data
$errors = array();

if (empty($name)) {
    $errors[] = "Name is required";
}

if (empty($email)) {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

if (empty($phone)) {
    $errors[] = "Phone number is required";
}

if (empty($service)) {
    $errors[] = "Please choose a service";
}

if (empty($date)) {
    $errors[] = "Preferred date is required";
}

if (empty($time)) {
    $errors[] = "Preferred time is required";
}

// If there are validation errors, display them
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "addisappointer";

    // Create a new MySQLi instance
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO appointment (name, email, phone, date, time,service, comments) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $date, $time, $service, $comments);

    // Execute the insert statement
    if ($stmt->execute()) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
