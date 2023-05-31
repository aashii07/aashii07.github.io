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
    </style>

<head>
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <script type="text/JavaScript" src="../js/home.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="Shome.php" class="active">Home</a>
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
        
       

        if($staff){

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

            

            
            

            

            
            

            

           
        }else{
            echo "Only SAMU Staff can access this page.";
        }

        
       
        
    }
?>