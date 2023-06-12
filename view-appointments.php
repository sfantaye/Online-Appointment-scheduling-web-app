<style>
    table {
        
        border-collapse: collapse;
        width: 100%;
    }
    .container, .container1{
        background-color:gray;
        margin:50px;
        padding:40px
      
       
    }
   
    h1{
        text-align:center;
        font-family: verdana;
        font-size:2em;

    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>


<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

$username = $_SESSION['username'];

$hostname = 'localhost';
$dbUsername = 'root';
$password = '';
$database = 'addisappointer';

$conn = new mysqli($hostname, $dbUsername, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$currentDateTime = date('Y-m-d H:i:s');

$stmt = $conn->prepare('SELECT a.id, a.name, a.email, a.phone, a.date, a.time, a.service, a.comments, a.timestamp FROM appointment a, users u WHERE a.email = u.email AND (u.username = ? AND (a.date > CURDATE() OR (a.date = CURDATE() AND a.time > CURTIME())))');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
echo '<h1>Your Appointments</h1>';
echo '<hr>';
echo"<div class='container'";
echo '<h1>Future Appointments</h1>';
echo '<table border>';
echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Time</th><th>Service</th><th>Comments</th><th>Timestamp</th></tr>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['phone'] . '</td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['time'] . '</td>';
    echo '<td>' . $row['service'] . '</td>';
    echo '<td>' . $row['comments'] . '</td>';
    echo '<td>' . $row['timestamp'] . '</td>';
    echo '</tr>';
}
echo '</table>';
echo "</div>";

$stmt->close();


$stmt = $conn->prepare('SELECT a.id, a.name, a.email, a.phone, a.date, a.time, a.service, a.comments, a.timestamp FROM appointment a, users u WHERE a.email = u.email AND u.username = ? AND (a.date < CURDATE() OR (a.date = CURDATE() AND a.time <= CURTIME()))');
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
echo "<div class='container1'";
echo '<h1>Past Appointments</h1>';
echo '<table border>';
echo '<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Time</th><th>Service</th><th>Comments</th><th>Timestamp</th></tr>';
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['phone'] . '</td>';
    echo '<td>' . $row['date'] . '</td>';
    echo '<td>' . $row['time'] . '</td>';
    echo '<td>' . $row['service'] . '</td>';
    echo '<td>' . $row['comments'] . '</td>';
    echo '<td>' . $row['timestamp'] . '</td>';
    echo '</tr>';
}
echo '</table>';
echo "</div>";

$stmt->close();

$conn->close();
?>

