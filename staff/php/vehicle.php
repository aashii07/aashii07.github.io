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
        $user = "SELECT role, hospital_id
                    FROM samu_staff
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);
        $role = $staff['role'];
        $hID = $staff['hospital_id'];
       

        if($role == "d"){

            // Disable ONLY_FULL_GROUP_BY mode for the current session
            mysqli_query($db, "SET SESSION sql_mode = ''");

            $query = "SELECT id, license, status
                        FROM vehicle
                        WHERE (status = 'maintenance' OR status = 'available') AND hospital_id = '$hID'";
            $result = mysqli_query($db, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $li = $row['license'];
                $status = $row['status'];
                echo $li . "<br>";


                if($status=="available"){

                    echo '<form method="POST" action="../php/maintenance.php">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    echo '<button type="submit">MAINTENANCE</button>';
                    echo '</form>';
                }
                else{
                    echo '<form method="POST" action="../php/vehavailable.php">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    echo '<button type="submit">AVAILABLE</button>';
                    echo '</form>';
    
                }
    
            }

            

            

           
        }else{
            echo "Only SAMU Drivers can access this page.";
        }

        
       
        
    }
?>