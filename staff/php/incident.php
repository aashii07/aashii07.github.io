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
                    FROM samu_staff
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);
       

        if($staff){

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
                    echo '<button type="submit">CLOSED</button>';
                    echo '</form>';
    
                }
    
            }
            else{
                echo "No incident has been assigned yet.";
            }

            
            

            

            

           
        }else{
            echo "Only SAMU Staff can access this page.";
        }

        
       
        
    }
?>