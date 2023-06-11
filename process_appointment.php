<style>
    body{
     background-color: gray; 
        font-family:verdana;
    }
    div{
        margin:100px;
        padding:80px;
        border: solid;
        text-align:center;
        background-color:white;
        color:white;
        border-radius:20px;
        box-shadow:  20px 20px 42px #2b181d,
                 -20px -20px 42px #8d4d5f;
    }
    a{
       border: black solid;
       text-decoration:none;
       padding:5px;
       background-color:black;
       color:white;
       border-radius:8px;
      
    }
    a:hover{
        background-color:brown;
        border-color:brown;
        padding:12px;
       
    }
    h2{
        color:red;
        align: center;
    }
</style>
<?php
$name = sanitizeInput($_POST['name']);
$email = sanitizeInput($_POST['email']);
$phone = sanitizeInput($_POST['phone']);
$service = sanitizeInput($_POST['service']);
$date = sanitizeInput($_POST['date']);
$time = sanitizeInput($_POST['time']);
$comments = sanitizeInput($_POST['comments']);

$currentTimestamp = date('Y-m-d H:i:s');




function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


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


if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
} else {
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "addisappointer";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $stmt = $conn->prepare("INSERT INTO appointment (name, email, phone, date, time,service, comments, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $date, $time, $service, $comments, $currentTimestamp);

    
    if ($stmt->execute()) {
        echo "
        <div>
        <h2>Your appointment has been scheduled successfully on!!</h2>
        <h2>Timestamp: $currentTimestamp</h2>
        <a type ='button' href='view-appointments.php'>Track Your Appointment</a>
        <a type ='button' href='cancel-appointments.php'>Cancel Your Appointment</a>
        <a type ='button' href='change-appointments.php'>Change Your Appointment</a>
        </div>
        ";
    } else {
        echo "
        <div>
         <h2>Error occurred</h2>
         <a type ='button' href='appoint.html'>Try Again</a>
        </div>      
        ";
    }

    
    $stmt->close();
    $conn->close();
}
?>
