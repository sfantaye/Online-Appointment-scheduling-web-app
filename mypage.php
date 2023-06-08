
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles-v2.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<script src="https://kit.fontawesome.com/ce19d678d8.js" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
    <title>AddisAppointer | Home</title>
    <style>
      .appoint a{
       border: black solid;
       text-decoration:none;
       padding:5px;
       background-color:black;
       color:white;
       border-radius:8px;
       font-family:verdana;
      
    }
    .appoint a:hover{
        background-color:brown;
        border-color:brown;
        padding:12px;
       
    }
    </style>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: LogIn.html');
    exit();
}

$name = $_SESSION['name'];
?>
    <header>
       <a href="#"><img src="./images/logo.png" id="logo" alt=""></a> 
        <nav>
            <ul>
               <a href="index.html" class="active"><li>Home</li></a>
            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h1>Welcome Back, <?php echo $name; ?></h1>
            <div class ="appoint">
            <a href="view-appointments.php" type="button">View Appointments</a>
    <a  href="change-appointments.php" type="button">Change Appointments</a>
    <a  href="cancel-appointments.php"  type="button">Cancel Appointments</a>
</div>
          </section>
    </main>
    
<footer>
  <div class="contacts">
    <h2>Contacts</h2>
    <p>Address: St. George,Arada, Addis Ababa, Ethiopia</p>
    <p>Email: info@addisappointer.com</p>
    <p>Phone: 0956432145</p>
  </div>
  <div class="social">
  <ul>
    <a href="https://www.facebook.com"><li><i class="fa-brands fa-facebook fa-beat-fade fa-2xl" style="color: #fff;"></i></li></a>
    <a href="https://www.instagram.com"><li><i class="fa-brands fa-instagram fa-beat-fade fa-2xl" style="color:#fff;"></i></li></a>
    <a href="https://www.twitter.com"><li><i class="fa-brands fa-twitter fa-beat-fade fa-2xl" style="color:  #fff;"></i></li></a>
    <a href="https://www.linkedin.com"><li><i class="fa-brands fa-linkedin fa-beat-fade fa-2xl" style="color: #fff;"></i></li></a>
    <a href="https://www.telegram.org"><li><i class="fa-brands fa-telegram fa-beat-fade fa-2xl" style="color: #fff;"></i></li></a>
  </ul>
  <p>&copy; 2023 AddisAppointer. All rights reserved.</p>
  </div>

  <!--Embedded Scripts-->
<script src="https://kit.fontawesome.com/345468d33a.js" crossorigin="anonymous"></script> 
</footer>  
</body>
</html>
