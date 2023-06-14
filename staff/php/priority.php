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
        <a href="../html/home.php" >Home</a>
        <hr>
        <a href="../php/priority.php" class="active">Resource Management</a>
        <hr>
        <a href="../html/form.php">Incident Reporting</a>
        <hr>
        <a href="../html/dash.php">Dashboard</a>
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
                    FROM control_officer
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);

        $id = $staff['id'];
        $n = $staff['firstname'];

        echo '<br>
            <div class="menu-box">
                <span class="menu-icon" onclick="openNav()">&#9776; Menu </span>
                <span class="firstname">Hello '.$n.' &#x1F600;</span>
            </div> ';

        
    }
?>





<!DOCTYPE html>
<html>
    <style>
        
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .button-container1 {
            text-align: center;
            display: flex;
            justify-content: center;
        }
        
        
        form {
            margin: 0 5px;
        }
        
    </style>



</html>
<?php
    // Start the session
   

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        
        $staff=$_SESSION['email'];
        $user = "SELECT *
                    FROM control_officer
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $co = mysqli_fetch_assoc($result);
       

     

            // Disable ONLY_FULL_GROUP_BY mode for the current session
            mysqli_query($db, "SET SESSION sql_mode = ''");

            $query = "SELECT id, severity, description FROM incident 
            WHERE status = 'pending'
            ORDER BY severity";

            $result = mysqli_query($db, $query);

            if ($result === false) {
                echo "Query error: " . mysqli_error($db);
                // You can also consider logging the error for debugging purposes
            } else {
                if (mysqli_num_rows($result) > 0) {

                    
                    
                    $currentSeverity=0;
                    echo "<style>
                            .message-box {
                                border: none;
                                padding: 0;
                                margin-bottom: 10px;
                                text-align: center;
                                color:white;
                            }
                            .severity-1 {
                                background-color: rgb(255, 80, 80);
                                width: 50%;
                                margin-left: auto; 
                                margin-right: auto;
                                
                            }
                            .severity-2 {
                                background-color: rgb(255, 255, 90);
                                width: 50%;
                                margin-left: auto; 
                                margin-right: auto;

                               
                            }
                            .severity-3 {
                                background-color: lightgreen;
                                width: 50%;
                                margin-left: auto; 
                                margin-right: auto;
                            }
                            .message-box a {
                                display: block;
                                padding: 10px;
                                text-decoration: none;
                                color: black;
                                font-size: 120%;
                                text-align: center;
                                transition: background-color 0.3s;
                            }
                            .message-box a:hover {
                                background-color: rgba(255, 255, 255, 0.5);
                            }
                          </style>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $severity = $row['severity'];
                        $description = $row['description'];
                    
                        // Check if the severity has changed
                    
                        if ($severity !== $currentSeverity) {
                            echo"<div class='message-box'><br><br><hr><h2>Severity $severity</h2></div>";
                            $currentSeverity = $severity;
                        }
                        
                        
                        echo "<div class='message-box severity-$severity' >
                                <a href='../php/assign.php?id=" . urlencode($id) . "'>ID $id - $description</a>
                              </div>";
                        
                        // Add additional formatting if desired
                        
                        
                    }
                    echo "<br><br><br>";
                } else {
                    include 'message.php';
                    //echo "No rows found.";
                    $msg = '<h2>No Incident<hr></h2>';
                    $msg .= '<p>There is no incident to be assigned yet. Please come back later.</p>';
                    $msg .= '<div class="button-container">';
                    $msg .= '<button onclick="window.location.href=\'../html/home.html\'">Close</button>';
                    $msg .= '</div>';
                    generateMessageBox($msg);
                }
            }
       

        
       
        
    }
?>
