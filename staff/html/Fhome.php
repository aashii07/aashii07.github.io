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
        <a href="Fhome.php" class="active">Home</a>
        <hr>
        <a href="../php/FavaiV.php">Vehicle Availability</a>
        <hr>
        <a href="../html/Fadd.php">Add Vehicle</a>
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











      

        

       

            
                
       
        

        

        // Disable ONLY_FULL_GROUP_BY mode for the current session
        mysqli_query($db, "SET SESSION sql_mode = ''");

        if($status=="break"){

            echo '<form method="POST" action="../php/stavailable.php">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<div style="display: flex; justify-content: flex-end; margin-right:1%">';
            echo '<button class="call-button">I am on break</button>';
            echo '</div>';
            echo '</form><br>';
        }
        else if($status=="available"){

            echo '<form method="POST" action="../php/break.php">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<div style="display: flex; justify-content: flex-end; margin-right:1%">';
            echo '<button class="call-button">I am on duty</button>';
            echo '</div>';
            echo '</form><br>';

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
        echo "<br><br><table style='margin: 0 auto;' id='grid-table'>";

        foreach ($week as $day => $dayName) {
            echo "<th>$dayName<br><span style='font-size: 13px; font-weight: normal;'>($day)</span></th>";
            
        }
        echo '<tr>';
        
        

        foreach ($week as $day => $dayName) {
            $q = "SELECT * FROM staff_schedule
                WHERE staff_id='$id' AND date='$day'";
            $r = mysqli_query($db, $q);
            $row = mysqli_fetch_assoc($r);
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
        echo "</div><br><br>";

            
            

            

            

       

            

            

        

        
       
        
    }
?>





