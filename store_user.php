<?php
// Step 2: Establish database connection
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'addisappointer';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Step 3: Retrieve form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirmPassword = sanitizeInput($_POST['confirmPassword']);

    // Step 4: Validate form data
    // Perform any necessary validation here

    if ($password !== $confirmPassword) {
        echo 'Error: Passwords do not match.';
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username or email already exists in the database
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<h2>Already Registered User</h2>
         <a type="button" href="Login.html">Log In</a>
        ';
        exit;
    }

    // Step 5: Store data in the database
    $stmt = $conn->prepare('INSERT INTO users (name, username, email, password) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('ssss',$name, $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo '<h2>Registered Successfully!!</h2>
          <a type="button" href = "LogIn.html">Log In</a>
        ';
    } else {
        echo 'Error: ' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

function sanitizeInput($input) {
    // Sanitize the input to prevent SQL injection
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>
