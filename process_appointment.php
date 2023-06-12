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

    $query = "SELECT workHrStart, workHrEnd, slot FROM service where name = '$service'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $workStartHour = (int)$row['workHrStart'];
        $workEndHour = (int)$row['workHrEnd'];
        $slotDuration = (int)$row['slot'];
    } else {
        echo "Error: Service information not found";
        exit;
    }

   
  
$appointmentDateTime = new DateTime($date . ' ' . $time);


$currentDateTime = new DateTime();

if ($appointmentDateTime < $currentDateTime) {
    echo "
    <div><h2>Cannot schedule appointments for past dates.</h2>
    <a type='button' href='appoint.html'>Try Again</a>
    </div>
    
    ";
    exit;
}


$appointmentHour = (int) $appointmentDateTime->format('H');

if ($appointmentHour < $workStartHour || $appointmentHour >= $workEndHour) {
    echo "
    <div><h2>Appointments can only be scheduled between $workStartHour:00 and " . ($workEndHour - 1) . ":59</h2>
    <a type='button' href='appoint.html'>Try Again</a>

    </div>  
    ";
    exit;
}
  

$query = "SELECT * FROM appointment WHERE service = '$service' AND  date = ? AND time >= ? AND time < ?";
$stmt = $conn->prepare($query);
$endTime = date('H:i:s', strtotime($time . '+' . $slotDuration . ' hour'));
$stmt->bind_param("sss", $date, $time, $endTime);
$stmt->execute();
$result = $stmt->get_result();
$existingAppointments = $result->fetch_all(MYSQLI_ASSOC);


$conflictFound = false;

foreach ($existingAppointments as $appointment) {
    $existingAppointmentDateTime = new DateTime($appointment['date'] . ' ' . $appointment['time']);
    $timeDiff = $appointmentDateTime->diff($existingAppointmentDateTime);

   
    $slotDiff = $timeDiff->h + ($timeDiff->i / 60); 

    if ($slotDiff >= 0 && $slotDiff < $slotDuration) {
        $conflictFound = true;
        break;
    }
}


if ($conflictFound) {
    echo "
    <div> <h2>Conflicting appointment(s) found</h2>
    <a type='button' href='appoint.html'>Try Again</a></div>
    ";
} else {
    
    $stmt = $conn->prepare("INSERT INTO appointment (name, email, phone, date, time, service, comments, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $email, $phone, $date, $time, $service, $comments, $currentTimestamp);

    if ($stmt->execute()) {
        echo "
        <div>
        <h2>Your appointment has been scheduled successfully on $date at $time!</h2>
        <h2>Timestamp: $currentTimestamp</h2>
        <a type='button' href='view-appointments.php'>Track Your Appointment</a>
        <a type='button' href='cancel-appointments.php'>Cancel Your Appointment</a>
        <a type='button' href='change-appointments.php'>Change Your Appointment</a>
        </div>
        ";
    } else {
        echo "
        <div>
         <h2>Error occurred</h2>
         <a type='button' href='appoint.html'>Try Again</a>
        </div>      
        ";
    }
}

$stmt->close();
$conn->close();
}
?>
