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
        <a href="Shome.php" class="active">Home</a>
        <a href="../html/Sstatus.html">Status Update</a>
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

            

            

           
        }else{
            echo "Only SAMU Staff can access this page.";
        }

        
       
        
    }
?>