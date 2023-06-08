<?php

session_start();


$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'addisappointer';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

  
    $stmt = $conn->prepare('SELECT username, password, name FROM users WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->bind_result($storedUsername, $storedPassword, $name);
    $stmt->fetch();

    if ($storedUsername === $username && password_verify($password, $storedPassword)) {
        
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $name;

        
        header('Location: mypage.php');
        exit();
    } else {
       
        echo 'Invalid username or password.';
    }

    $stmt->close();
}

$conn->close();

function sanitizeInput($input) {
   
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>
