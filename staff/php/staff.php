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
        echo $id;
       

        if($staff){

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

            

            

           
        }else{
            echo "Only SAMU Staff can access this page.";
        }

        
       
        
    }
?>