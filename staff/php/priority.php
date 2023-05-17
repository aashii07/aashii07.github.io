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
                    echo "No rows found.";
                }
            }
        }else{
            echo "Only Control Officers can access this page.";
        }

        
       
        
    }
?>