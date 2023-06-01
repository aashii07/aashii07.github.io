<!DOCTYPE html>
<html>
    <style>
        .active {
            background-color: #03d9ffbc;
            /* Replace with your desired color */
            color: #000000 !important;
            /* Replace with your desired text color */
        }

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
            border: none;
        }
        .button-container1 {
            text-align: center;
            display: flex;
            justify-content: center;
        }
        
        
        form {
            margin: 0 5px;
        }

        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        select {
            padding: 4px;
        }

        .center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
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
        <a href="EPhome.php" class="active">Home</a>
        <a href="../html/Sdash.html">Dashboard</a>
        <a href="logout.php">Log Out</a>
    </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <br>



    
    <p>Hello SAMU</p>





</body>

</html>
<?php

   
    



    // Start the session
    session_start();
    $_SESSION['schedule']="0";
    require_once('Ushift.php');
    

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        
        $staff=$_SESSION['email'];
        $user = "SELECT id, status
                    FROM samu_staff
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);
        $id = $staff['id'];
        $status = $staff['status'];











      

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

        echo "<div style='text-align: center;'>";
        echo "For any request or issue concerning your working shift, please ";

        $q = "SELECT * FROM samu_staff
                WHERE role='u'";
        $r = mysqli_query($db, $q);
        $row = mysqli_fetch_assoc($r);
        $email = $row['email'];
        $message = "mail us";
        $link = "<a href='mailto:$email'>$message</a>";
        echo $link;
        echo "</div>";

            
                
       

        

        // Disable ONLY_FULL_GROUP_BY mode for the current session
        mysqli_query($db, "SET SESSION sql_mode = ''");

        if($status=="break"){

            echo '<form method="POST" action="../php/stavailable.php">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<button type="submit">I am on break</button>';
            echo '</form>';
        }
        else if($status=="available"){

            echo '<form method="POST" action="../php/break.php">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<button type="submit">I am on duty</button>';
            echo '</form>';

        }

        $u = "SELECT *
                    FROM incident_staff s
                    JOIN incident i ON i.id = s.incident_id
                    WHERE (i.status = 'dispatched' OR i.status = 'resolving') AND s.staff_id='$id'";

            $r = mysqli_query($db, $u);
            $r1 = mysqli_fetch_assoc($r);
            if($r1){
                $Iid = $r1['id'];

                echo '<h4 style="text-align: center;" >Request other emergency services for incident '.$Iid.':</h4>
                        <div class="button-container1">
                            <form action="mfrs.php" method="get">
                                <input type="hidden" name="id" value="' . $Iid . '">
                                <button class="button">MFRS</button>
                            </form>
                            <form action="mpf.php" method="get">
                                <input type="hidden" name="id" value="' . $Iid . '">
                                <button class="button">MPF</button>
                            </form>
                        </div>
                        <br><hr>';
            }
            

           
       

            

        // Disable ONLY_FULL_GROUP_BY mode for the current session
        mysqli_query($db, "SET SESSION sql_mode = ''");

        $query = "SELECT s.incident_id, i.status, i.description
                    FROM incident_staff s
                    JOIN incident i ON i.id = s.incident_id
                    WHERE (i.status = 'dispatched' OR i.status = 'resolving')";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_assoc($result);
        

        if($row){

            
            $id = $row['incident_id'];
            $status = $row['status'];
            $desc = $row['description'];
            

            if($status=="dispatched"){

                echo '<form method="POST" action="../php/resolving.php">';
                echo 'Update status of incident '.$id.' to ';
                echo '<input type="hidden" name="incident_id" value="' . $id . '">';
                echo '<button type="submit">RESOLVING</button>';
                echo '</form>';
            }
            else if ($status=="resolving"){


                echo '<form method="POST" action="../php/closed.php">';
                echo '<input type="hidden" name="incident_id" value="' . $id . '">';
                echo '<label for="treatment">Prehospital Treatment</label><br>';
                echo '<textarea name="treatment" id="treatment" required></textarea><br><br>';
                echo '<label for="condition">Post-Treatment Conditions</label><br>';
                echo '<textarea name="condition" id="condition" required></textarea><br><br>';
                echo 'Update status of incident '.$id.' to ';
                echo '<button type="submit">CLOSED</button>';
                echo '</form>';

            }

        }
        else{
            //echo "No incident has been assigned yet.";
        }

            
            

            

            

       

            

            

        

        
       
        
    }
?>