<!DOCTYPE html>
<html>
    <style>
        .active {
            background-color: #03d9ffbc;
            /* Replace with your desired color */
            color: #000000 !important;
            /* Replace with your desired text color */
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
        <a href="../html/Sstatus.html">Status Update</a>
        <a href="../html/Sdash.html">Dashboard</a>
        <a href="logout.php">Log Out</a>
    </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <br>



    
    <p>Hello EP</p>





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
       
        
       

        

            // Disable ONLY_FULL_GROUP_BY mode for the current session
        mysqli_query($db, "SET SESSION sql_mode = ''");

        if($status=="break"){

            echo '<form method="POST" action="../php/stavailable.php">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<button type="submit">AVAILABLE</button>';
            echo '</form>';
        }
        else if($status=="available"){

            echo '<form method="POST" action="../php/break.php">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<button type="submit">BREAK</button>';
            echo '</form>';

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
                echo $desc;

                if($status=="dispatched"){

                    echo '<form method="POST" action="../php/resolving.php">';
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
                    echo '<button type="submit">CLOSED</button>';
                    echo '</form>';
    
                }
    
            }
            else{
                echo "No incident has been assigned yet.";
            }

            
            

            

            

       

            

            

        

        
       
        
    }
?>