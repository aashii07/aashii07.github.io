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
            /*position: fixed;*/
            
          
           
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
        


       
        .call-button {
            align-items: center;
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
            width: 260px;
            height: 50px;
        }

        .call-button:hover {
            background-image: linear-gradient(45deg, teal, red);
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

    <!--<img src="../../gallery/logo.png" alt="logo" width="250" style="position:fixed">
    <br><br><br><br><br><br>-->

    <img src="../../gallery/logo.png" alt="logo" width="250">
    <br>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <hr>
        <a href="../html/Uhome.php">Home</a>
        <hr>
        <a href="../php/Uscheduling.php" class="active">Staff Scheduling</a>
        <hr>
        <a href="../php/UselectS.php">Remove Staff</a>
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

<?php
// Start the session
//session_start();
$_SESSION['schedule'] = "1";

// DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
    die('Connection Failed : ' . $db->connect_error);
} else {
    date_default_timezone_set("Indian/Mauritius");

    
    $staff = $_SESSION['email'];
    $user = "SELECT *
                FROM samu_staff
                WHERE email='$staff'";
    $result = mysqli_query($db, $user);
    $row = mysqli_fetch_assoc($result);
    $hos = $row['hospital_id'];

    // Retrieve the roles from the database
    $rolesQuery = "SELECT DISTINCT role FROM samu_staff";
    $rolesResult = mysqli_query($db, $rolesQuery);

    if (mysqli_num_rows($rolesResult) > 0) {
        echo "<form method='post' action='Ushift.php'>"; // Add the form element here


        while ($roleRow = mysqli_fetch_assoc($rolesResult)) {
            $role = $roleRow['role'];

            // Retrieve the persons for the specific role
            $sql = "SELECT id, firstname, lastname FROM samu_staff WHERE role = '$role' AND hospital_id='$hos'";
            $result = mysqli_query($db, $sql);

            if (mysqli_num_rows($result) > 0) {

                if ($role == "e") {
                    $rl = "Emergency Physician";
                } else if ($role == "u") {
                    $rl = "Unit Manager";
                } else if ($role == "f") {
                    $rl = "Fleet Manager";
                } else if ($role == "n") {
                    $rl = "Nurse";
                } else if ($role == "h") {
                    $rl = "Helper";
                } else {
                    $rl = "Driver";
                }
                

                echo "<h2 style='text-align: center; margin-top: 50px; font-size: 30px;
                background: linear-gradient(to right, red, red, red, teal, teal, teal);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;'>$rl</h2>";
            

                echo "<table style='margin: 0 auto;' id='grid-table'>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>";

                // Get the current date
                $currentDate = strtotime('today');

                // Get the day of the week (1 for Monday, 2 for Tuesday, etc.)
                $dayOfWeek = date('N', $currentDate);

                // Calculate the start date of the week
                if ($dayOfWeek === '1') {
                    // Current day is Monday, use the current date as the week start
                    $weekStart = $currentDate;
                } else {
                    // Find the previous Monday
                    $weekStart = strtotime('last Monday', $currentDate);
                }

                // Calculate the end date of the week
                $weekEnd = strtotime('+6 days', $weekStart);

                $start=$weekStart;
                $wk=$weekStart;

                for ($day = 0; $day < 7; $day++) {
                    $dayName = date('D', $weekStart);
                    $date = date('Y-m-d', $weekStart);
                    echo "<th>$dayName<br><span style='font-size: 13px; font-weight: normal;'>($date)</span></th>";

                    $weekStart = strtotime('+1 day', $weekStart);
                    // $weekEnd can also be updated if needed
                }




                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    $personId = $row['id'];
                    $firstName = $row['firstname'];
                    $lastName = $row['lastname'];

                    echo "<tr class='grid-row'>
                            <td>$personId</td>
                            <td>$firstName $lastName</td>";

                    

                    $start=$wk;
                    for ($day = 0; $day < 7; $day++) {
                        $dayName = date('D', $start);
                        $date = date('Y-m-d', $start);
                        
                        
                        

                        $q="SELECT shift FROM staff_schedule WHERE date='$date' AND staff_id='$personId'";
                        $r=mysqli_query($db, $q);
                        if (mysqli_num_rows($r) == 0){
                            
                            $q1="INSERT INTO staff_schedule (date, staff_id)
                                VALUES('$date', '$personId')";
                            $r1=mysqli_query($db, $q1);
                            
                            $q="SELECT shift FROM staff_schedule WHERE date='$date' AND staff_id='$personId'";
                            $r=mysqli_query($db, $q);

                        }
                        
                        $rw=mysqli_fetch_assoc($r);
                        $s=$rw['shift'];
                        if($s=="d"){
                            $S="Day";
                        }else if($s=="dn"){
                            $S="Day + Night";
                        }else if($s=="n"){
                            $S="Night";
                        }else if($s=="o"){
                            $S="Off Duty";
                        }else{
                            $S="Select shift";
                        }

                        echo "<td data-row='$personId' data-col='$day' class='grid-cell'>
                        <input type='hidden' name='shift[$personId][$day][date]' value='$date'>
                        
                        <input type='hidden' name='shift[$personId][$day][staff_id]' value='$personId'>";
                        
                        

                        if($date >= date('Y-m-d')){
                        

                            echo "<select name='shift[$personId][$day][shift]'>
                            <option value='$s'>$S</option>
                            " . ($S !== 'Day + Night' ? "<option value='dn'>Day + Night</option>" : "") . "
                            " . ($S !== 'Day' ? "<option value='d'>Day</option>" : "") . "
                            " . ($S !== 'Night' ? "<option value='n'>Night</option>" : "") . "
                            " . ($S !== 'Off Duty' ? "<option value='o'>Off Duty</option>" : "") . "                                
                            </select>
                            </td>";
                        }else{
                            echo "<select name='shift[$personId][$day][shift]'>
                            <option value='$s'>$S</option>                        
                            </select>
                            </td>";
                        }

                        
                        $start = strtotime('+1 day', $start);
                    }

                    echo "</tr>";
                }

                echo "</table>";


            } else {

                //echo "<p>No persons found for role '$role'.</p>";
            }
        }

        echo "<div style='display: flex; justify-content: center; align-items: center; margin-top:70px'>";
        
        echo '<button class="call-button" role="button"><span class="text">Save Shift</span></button></div>';

        echo "</form>"; // Close the form element here


               

    } else {
        echo "<p>No roles found in the database.</p>";
    }

}

?>

<script>
    // Add event listeners to highlight row on hover
    var gridRows = document.querySelectorAll('.grid-row');

    if (gridRows) {
        for (var i = 0; i < gridRows.length; i++) {
            gridRows[i].addEventListener('mouseover', highlightRow);
            gridRows[i].addEventListener('mouseout', removeHighlight);
        }
    }

    function highlightRow(event) {
        var row = event.target.parentNode;
        row.classList.add('highlight-row');
    }

    function removeHighlight(event) {
        var row = event.target.parentNode;
        row.classList.remove('highlight-row');
    }
</script>


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





