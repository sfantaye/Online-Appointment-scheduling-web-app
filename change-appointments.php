<?php

session_start();


if (!isset($_SESSION['username'])) {
    
    header('Location: login.html');
    exit();
}


$username = $_SESSION['username'];


$hostname = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$database = 'addisappointer';

$conn = new mysqli($hostname, $dbUsername, $dbPassword, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = sanitizeInput($_POST['appointmentId']);
    $newDate = sanitizeInput($_POST['newDate']);
    $newTime = sanitizeInput($_POST['newTime']);

    $stmt = $conn->prepare('SELECT * FROM appointment a, users u WHERE a.email = u.email AND a.id = ? AND u.username = ?');
    $stmt->bind_param('is', $appointmentId, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo '<h2>Invalid Appointment ID</h2>';
        exit();
    }

    $stmt = $conn->prepare('SELECT date, time FROM appointment WHERE id = ?');
    $stmt->bind_param('i', $appointmentId);
    $stmt->execute();
    $stmt->bind_result($currentDate, $currentTime);
    $stmt->fetch();
    $stmt->close();

   
    $currentDateTime = $currentDate . ' ' . $currentTime;
    $newDateTime = $newDate . ' ' . $newTime;
    if (strtotime($newDateTime) < strtotime($currentDateTime)) {
        echo 'Cannot update appointment to a past date or time.';
        exit();
    }

   
    $stmt = $conn->prepare('UPDATE appointment SET date = ?, time = ? WHERE id = ?');
    $stmt->bind_param('ssi', $newDate, $newTime, $appointmentId);

    if ($stmt->execute()) {
        echo '<p>Appointment Updated Successfully!!</p>';
    } else {
        echo 'Error updating appointment: ' . $stmt->error;
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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Appointment</title>
    <link rel="stylesheet" href="style-for-change.css">
</head>
<body>
    <h2>Change Appointment</h2>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="appointmentId">Appointment ID:</label>
        <input type="number" id="appointmentId" name="appointmentId" required>
        <br>
        <label for="newDate">New Date:</label>
        <input type="date" id="newDate" name="newDate" required>
        <br>
        <label for="newTime">New Time:</label>
        <input type="time" id="newTime" name="newTime" required>
        <br>
        <button type="submit">Update Appointment</button>
    </form>
    
</body>
</html>

