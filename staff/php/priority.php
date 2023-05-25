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
    <link rel="stylesheet" type="text/css" href="../css/resource.css" />
    <script type="text/JavaScript" src="../js/resource.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="../html/home.html">Home</a>
        <a href="priority.php" class="active">Resource Management</a>
        <a href="../html/form.html">Incident Reporting</a>
        <a href="../html/dash.html">Dashboard</a>
        <a href="logout.php">Log Out</a>
    </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <br>

    

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
        $user = "SELECT *
                    FROM control_officer
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $co = mysqli_fetch_assoc($result);
       

        if($co){

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

                    echo '<h4 style="text-align: center;" >Request other emergency services for last assigned incident:</h4>
                    <div class="button-container1">
                        <form action="mfrs.php" method="post">
                            <button class="button">MFRS</button>
                        </form>
                        <form action="mpf.php" method="post">
                            <button class="button">MPF</button>
                        </form>
                    </div>
                    <br><hr>';
                    
                    $currentSeverity=0;
                    echo "<style>
                            .message-box {
                                border: none;
                                padding: 0;
                                margin-bottom: 10px;
                                text-align: center;
                            }
                            .severity-1 {
                                background-color: rgb(255, 80, 80);
                            }
                            .severity-2 {
                                background-color: rgb(255, 255, 90);
                            }
                            .severity-3 {
                                background-color: lightgreen;
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
                            echo"<div class='message-box'><h2>Severity: $severity</h2></div>";
                            $currentSeverity = $severity;
                        }
                        
                        
                        echo "<div class='message-box severity-$severity'>
                                <a href='../php/assign.php?id=" . urlencode($id) . "'>$description</a>
                              </div>";
                        
                        // Add additional formatting if desired
                        
                        
                    }
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
        }else{
            //echo "Only Control Officers can access this page.";
        }

        
       
        
    }
?>
