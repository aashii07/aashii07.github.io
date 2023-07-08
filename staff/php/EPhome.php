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
            width: 120px;
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
        .button-64 {
            align-items: center;
            background-image: linear-gradient(45deg,red, teal);
            border: 0;
            border-radius: 8px;
            box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
            box-sizing: border-box;
            color: #FFFFFF;
            display: flex;
            font-family: Phantomsans, sans-serif;
            font-size: 16px; /* Updated font size */
            justify-content: center;
            line-height: 1em;
            width: 120px; /* Updated width */
            padding: 2.5px; /* Updated padding */
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            cursor: pointer;
        }

        .button-64:active,
        .button-64:hover {
            outline: 0;
        }

        .button-64 span {
            background-color: rgb(5, 6, 45);
            padding: 12px; /* Updated padding */
            border-radius: 6px;
            width: 100px;
            height: 20px;
            transition: 300ms;
        }

        .button-64:hover span {
            background: none;
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
            background-color: rgb(150, 200, 200, 0.5);
            width: 50%;
            margin-left: 25%;
            border-radius: 10px;
            
           
            
        }
        textarea{
            background-color: rgb(170, 200, 200);
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
        <a href="EPhome.php" class="active">Home</a>
        <hr>
        <a href="logout.php">Log Out</a>
        <hr>
    </div>


   

    



    
   





</body>

</html>
<?php

   
    



    // Start the session
    //session_start();
    $_SESSION['schedule']="0";
    require_once('Ushift.php');
    

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
        $idS = $staff['id'];
        $status = $staff['status'];
        $n = $staff['firstname'];

        echo '<br>
            <div class="menu-box">
                <span class="menu-icon" onclick="openNav()">&#9776; Menu </span>
                <span class="firstname">Hello '.$n.' &#x1F600;</span>
            </div> <br>';











      

        

       

            
                
       
        

        

        // Disable ONLY_FULL_GROUP_BY mode for the current session
        mysqli_query($db, "SET SESSION sql_mode = ''");

        if($status=="break"){

            echo '<form method="POST" action="../php/stavailable.php">';
            echo '<input type="hidden" name="id" value="' . $idS . '">';
            echo '<div style="display: flex; justify-content: flex-end; margin-right:1%">';
            echo '<button class="call-button">I am on break</button>';
            echo '</div>';
            echo '</form><br>';
        }
        else if($status=="available"){

            echo '<form method="POST" action="../php/break.php">';
            echo '<input type="hidden" name="id" value="' . $idS . '">';
            echo '<div style="display: flex; justify-content: flex-end; margin-right:1%">';
            echo '<button class="call-button">I am on duty</button>';
            echo '</div>';
            echo '</form><br>';

        }
        
        

        $u = "SELECT *
                    FROM incident_staff s
                    JOIN incident i ON i.id = s.incident_id
                    WHERE (i.status = 'dispatched' OR i.status = 'resolving') AND s.staff_id='$idS'
                    ORDER BY s.id DESC
                    LIMIT 1";

            $r = mysqli_query($db, $u);
            $r1 = mysqli_fetch_assoc($r);
            if($r1){
                $Iid = $r1['id'];

                echo '<div class="box">';

                echo '<h2 class="center"><br>Managing Incident '.$Iid.'</h2><hr>';
                echo '<h4 style="text-align: center;" >Request other emergency services</h4>
                        <div class="button-container">
                            <form action="mfrs.php" method="get">
                                <input type="hidden" name="id" value="' . $Iid . '">
                                
                                <button class="button-64" role="button"><span class="text">MFRS</span></button>
                            </form>
                            <form action="mpf.php" method="get">
                                <input type="hidden" name="id" value="' . $Iid . '">
                                
                                <button class="button-64" role="button"><span class="text">MPF</span></button>
                            </form>
                        </div>
                        <br>';


                    

                // Disable ONLY_FULL_GROUP_BY mode for the current session
                mysqli_query($db, "SET SESSION sql_mode = ''");

                $query = "SELECT *
                            FROM incident
                            WHERE id= '$Iid' ";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_assoc($result);
                

                if($row){

                    
                    $id = $row['id'];
                    $status = $row['status'];
                    $desc = $row['description'];
                    

                    if($status=="dispatched"){

                        echo '<form class="center" method="POST" action="../php/resolving.php">';
                        echo '<h4 style="text-align: center;" >Update status to </h4>';
                        echo '<input type="hidden" name="incident_id" value="' . $id . '">';
                        echo '<button class="call-button">RESOLVING</button>';
                        echo '</form>';
                    }
                    else if ($status=="resolving"){


                        echo '<form  method="POST" action="../php/closed.php">';
                        echo '<div style="text-align: center;" >';
                        echo '<input type="hidden" name="incident_id" value="' . $id . '">';
                        echo '<label for="treatment"><b>Prehospital Treatment</b></label><br>';
                        echo '<textarea name="treatment" id="treatment" required></textarea><br><br>';
                        echo '<label for="condition"><b>Post-Treatment Conditions</b></label><br>';
                        echo '<textarea name="condition" id="condition" required></textarea>';
                        echo '</div >';
                        echo '<div class="center"><br><h4 style="text-align: center;" >Update status to </h4>';

                        echo '<button class="call-button">CLOSED</button></div>';
                        echo '</form>';

                    }
                    echo '<br></div><br><br><hr><br><br>';

                }
                else{
                    //echo "No incident has been assigned yet.";
                }
        
                        
            }
            

           
       
        

        $currentDate = date('Y-m-d');  // Get the current date in 'YYYY-MM-DD' format
        $weekStartDate = date('Y-m-d', strtotime("last Monday", strtotime($currentDate))); // Get the week start date

        // Generate the week
        $week = array();
        for ($i = 0; $i < 7; $i++) {
            $day = date('Y-m-d', strtotime("+$i days", strtotime($weekStartDate)));
            $dayName = date('D', strtotime($day)); // Get the day name
    
            $week[$day] = $dayName;
        }

        // Print the week
        echo "<table style='margin: 0 auto;' id='grid-table'>";

        foreach ($week as $day => $dayName) {
            $q = "SELECT * FROM staff_schedule
                WHERE staff_id='$idS' AND date='$day'";
            $r = mysqli_query($db, $q);
            $row = mysqli_fetch_assoc($r);
            if($row){

                echo "<th>$dayName<br><span style='font-size: 13px; font-weight: normal;'>($day)</span></th>";
            
            }
            
        }
        echo '<tr>';
        
        
      

        foreach ($week as $day => $dayName) {
            $q = "SELECT * FROM staff_schedule
                WHERE staff_id='$idS' AND date='$day'";
            $r = mysqli_query($db, $q);
            $row = mysqli_fetch_assoc($r);
            if($row){

               

                $shift = $row['shift'];
                $S = "";
                if ($shift == "d") {
                    $S = "Day";
                } else if ($shift == "dn") {
                    $S = "Day + Night";
                } else if ($shift == "n") {
                    $S = "Night";
                } else if ($shift == "o") {
                    $S = "Off Duty";
                }
                
            
                
                echo '<td>' . $S . '</td>';
            }
            

            
            
        }

        echo '</tr>';
        echo '</table>';
        echo '<br>';

        echo "<div style='text-align: center; color:rgb(190, 200, 200)'>";
        echo "For any request or issue concerning your working shift, please ";
        $q = "SELECT * FROM samu_staff
        WHERE role='u'";
        $r = mysqli_query($db, $q);
        $row = mysqli_fetch_assoc($r);
        $email = $row['email'];
        $message = "mail us";
        $link = "<a href='mailto:$email'>$message</a>";
        echo $link;
        echo "</div><br>";

            
            

            

            

       

            

            

        

        
       
        
    }
?>

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



