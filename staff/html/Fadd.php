<?php
    // Start the session
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <style>
        body {
            background-image: url(../../gallery/bg.jpg);
            background-repeat: repeat;
            font-family: Arial, Helvetica, sans-serif;
        }
        .active {
            background-color: rgb(150, 200, 200); /* Replace with your desired color */
            color: teal !important; /* Replace with your desired text color */
        }
        hr{
            background-image: linear-gradient(to left, red, teal); /* Replace "red" and "blue" with your desired colors */
            height: 2px; /* Adjust the height of the hr element as needed */
            border: none;
        }

        .menu-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgb(150, 200, 200, 0.3);
            height: 43px;
            width: 100%;
            background-color: rgb(150, 200, 200, 0.2);
            
        }

        .menu-icon {
            font-size: 30px;
            cursor: pointer;
            color: rgb(150, 200, 200);
            margin-left: 20px;
        }

        .firstname {
            text-align: right;
            padding-right: 30px;
            color: rgb(100, 200, 200);
        }

        .call-button {
            align-items: center !important;
            background-image: linear-gradient(45deg, red, teal);
            border: 0;
            border-radius: 8px;
            box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
            box-sizing: border-box;
            color: #ffffff;
            display: flex;
            font-family: Phantomsans, sans-serif;
            font-size: 16px;
            justify-content: center;
            line-height: 1em;
            padding: 10px 20px;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            cursor: pointer;
            width: 300px;
            margin-top: 0px;
            margin-left: 10px;
            margin-bottom: 5px;
        }

        .call-button:hover {
            background-image: linear-gradient(45deg, teal, red);
        }

        .sidenav{
            background-color: black !important;
            border-right: 2px solid red; 
            
        }
        .sidenav .active:hover{
            color: teal !important;
        }
        
       
        .sidenav a:hover{
            color: rgb(150, 200, 200) !important;
        }
        


        .button-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Create two equal-width columns */
            gap: 5px; /* Adjust the gap between buttons */
            justify-content: center; /* Center align buttons horizontally */
            margin-top: 0px; /* Add margin for spacing */
            margin-bottom: 5px;
            margin-left: 40%;
            margin-right: 40%;
        }
        
        
        
        form {
            margin: 0 5px;
            
        }

        table {
            border-collapse: collapse;
            background-color: rgb(150, 200, 200, 0.7);
        }

        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid teal;
        }

        th {
            background-color: rgb(130, 200, 200);
        }

        select {
            padding: 4px;
        }

        .center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        

        .box{
            background-color: rgb(150, 200, 200);
            width: 50%;
            margin-left: 25%;
            border-radius: 10px;
            
        }
      
    </style>

<head>
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <script type="text/JavaScript" src="../js/home.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <img src="../../gallery/logo.png" alt="logo" width="250">
    <br>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <hr>
        <a href="Fhome.php" >Home</a>
        <hr>
        <a href="../php/FavaiV.php">Vehicle Availability</a>
        <hr>
        <a href="../html/Fadd.php" class="active">Add Vehicle</a>
        <hr>
        <a href="../php/FselectV.php">Remove Vehicle</a>
        <hr>
        <a href="../php/logout.php">Log Out</a>
        <hr>
    </div>

    




</body>

</html>
<?php

   
    



    // Start the session
    //session_start();
    $_SESSION['schedule']="0";
    require_once('../php/Ushift.php');
    

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        
        $staff=$_SESSION['email'];
        $user = "SELECT *
                    FROM samu_staff
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);
        $id = $staff['id'];
        $status = $staff['status'];
        $n = $staff['firstname'];

        echo '<br>
            <div class="menu-box">
                <span class="menu-icon" onclick="openNav()">&#9776; Menu </span>
                <span class="firstname">Hello '.$n.' &#x1F600;</span>
            </div> <br>';


  
       
        
    }
?>





<!DOCTYPE html>
<html>
    <style>
        
        input[type=text], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
        }

        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .choice {
            display: inline-flex;
            position: relative;
            padding-left: 37px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 15px;
        }

        /* Hide the browser's default radio button */
        .choice input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark {
            position: absolute;
            top: -2px;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: rgb(180, 220, 230);
            border-radius: 50%;
            margin-left: 15px;
        }

        /* On mouse-over, add a grey background color */
        .choice:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .choice input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .choice input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .choice .checkmark:after {
            top: 6.18px;
            left: 6.4px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgb(255, 255, 255);
        }


    </style>

<head>
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <script type="text/JavaScript" src="../js/home.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="Fhome.html">Home</a>
        <a href="../php/FavaiV.php">Vehicle Availability</a>
        <a href="Fadd.html" class="active">Add Vehicle</a>
        <a href="../php/FselectV.php">Remove Vehicle</a>
        <a href="../php/logout.php">Log Out</a>
    </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <br>

    <div class="box">
    <form onsubmit="return validateLicensePlate()" action="../php/Fadd.php" method="POST">
        <br><label for="license"><b>License Plate Number</b></label><br>
        <input type="text" placeholder="Enter the license plate number" id="license" name="license" required><br><br>

        <label><b>Vehicle Type</b></label>
        <br><br>
        <label class="choice">SAMU Vehicle
            <input type="radio" checked="checked" name="type" value="s">
            <span class="checkmark"></span>
        </label>
        <label class="choice">Ambulance
            <input type="radio" name="type" value="a">
            <span class="checkmark"></span>
        </label>
        <br><br>
        </div><br>
        

        

        <div style='text-align: center; margin-top: 20px;'>
            <button class='call-button' onclick='submitForm()' style='display: inline-block; color: white; padding: 15px 30px; border: none; border-radius: 4px; font-size: 20px; text-decoration: none;'>Add Vehicle</button>
        </div>
    </form>
    

    <script type="text/javascript">
        function validateLicensePlate() {
            var licensePlate = document.getElementById("license").value;
            var regex = /^\d+\sRM\s\d{2}$/; // License plate format: digits followed by a space, followed by RM, followed by a space, followed by two digits
    
            if (!regex.test(licensePlate)) {
                alert("License plate number should be in the format: digits RM ##");
                return false;
            }
            return true;
        }
    </script>
    
    

</body>
</html>

<title>MedRush</title>
<style>
    /* CSS for the footer */
    .footer {
      position: relative;
      left: 0;
      bottom: 0;
      top: 0;;
      width: 100%;
      height: 150px;
      background-color: rgb(150, 200, 200, 0);
      text-align: center;
      overflow: hidden;
    }

    .footer1 {
      position: relative;
      left: 0;
      bottom: 0;
      top: 0;
      width: 100%;
      height: 120px;
      border: 1px solid rgb(150, 200, 200, 0.3);
      background: linear-gradient(to left, rgba(255, 0, 0, 0.5), rgba(0, 128, 128, 0.5)); /* Add a linear gradient background */
      text-align: center;
      overflow: hidden;
    }

    /* CSS for the GIF animation */
    .gif-animation {
      position: relative;
      animation: moveGif 4s linear infinite;
      margin-left: 1px;
    }
   

    /* Keyframes for the GIF animation */
    @keyframes moveGif {
      0% { right: 100%; }
      100% { right: -100%; }
    }

    /* CSS for the icon links */
    .footer-icons {
        display: flex; /* Display the icons in a row */
        justify-content: center; /* Center the icons horizontally */
        align-items: center; /* Center the icons vertically */
        padding: 10px; /* Add some space around the icons */
    }

    .footer-icons a {
        color: rgb(150, 200, 200, 0.5);
        margin: 10px; /* Increase or decrease the margin as needed */
        font-size: 30px; /* Adjust the font size */
        margin-left: 20px;
        margin-right: 20px;
        margin-top: 20px;
        
        transition: color 0.3s ease; /* Add a smooth transition effect on hover */
    }

    .footer-icons a:hover {
        color: rgb(150, 250, 250); /* Change the color on hover */
    }

    .footer1 .copyright {
        color: rgb(150, 200, 200, 0.5);
        font-size: 14px;
        margin-top: 10px; /* Add some space between the icons and the copyright notice */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  
<div class="footer">
    <div class="gif-animation">
        <img src="./a.gif" alt="Moving GIF">
        <span style="margin-right: 1000px;"></span>
        <img src="./a.gif" alt="Moving GIF">
      
    </div>
</div>




<div class="footer1">
  
    <div class="footer-icons">
        <!-- Phone icon with number -->
        <a href="tel:57647416" target="_blank"><i class="fas fa-phone"></i></a>
        
        <!-- Email icon with email address -->
        <a href="mailto:assist@medrush.com" target="_blank"><i class="fas fa-envelope"></i></a>
        
        <!-- Facebook icon with link to Facebook page -->
        <a href="https://www.facebook.com/medrush" target="_blank"><i class="fab fa-facebook"></i></a>
        
        <!-- Instagram icon with link to Instagram profile -->
        <a href="https://www.instagram.com/medrush" target="_blank"><i class="fab fa-instagram"></i></a>
        
        <!-- YouTube icon with link to YouTube channel -->
        <a href="https://www.youtube.com/medrush" target="_blank"><i class="fab fa-youtube"></i></a>
    </div>

    <p class="copyright">
        &copy;2023 MedRush | All Rights Reserved
    </p>

</div>




