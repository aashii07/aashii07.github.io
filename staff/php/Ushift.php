<?php
// Start the session
session_start();

// DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
    die('Connection Failed : ' . $db->connect_error);
} else {
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the shift data from the form
        $shiftData = $_POST['shift'];
        
       

        

        if (isset($_POST['shift'])) {
            $shiftData = $_POST['shift'];

            foreach ($shiftData as $personId => $shifts) {
                foreach ($shifts as $day => $shift) {
                    $date = $shift['date'];
                    $selectedShift = $shift['shift'];
                    $staffId = $shift['staff_id'];
                    

                    


                    $query = "SELECT * FROM staff_schedule WHERE date='$date' AND staff_id='$staffId'";
                    $row = mysqli_query($db, $query);

                    if ($row) {
                        if (mysqli_num_rows($row) > 0 && $selectedShift!="") {
                            
                            $updateQuery = "UPDATE staff_schedule 
                                        SET shift='$selectedShift' 
                                        WHERE date='$date' AND staff_id='$staffId'";
                            $result = mysqli_query($db, $updateQuery);

                        
                        } else if (mysqli_num_rows($row) == 0 && $selectedShift!="") {
                            $insertQuery = "INSERT INTO staff_schedule (date, shift, staff_id) VALUES ('$date', '$selectedShift', '$staffId')";
                            $result = mysqli_query($db, $insertQuery);

                            //if (!$result) {
                            //    echo "Insert Error: " . mysqli_error($db);
                            //}
                        }
                    } else {
                        echo "Query Error: " . mysqli_error($db);
                    }
                }
            }
        } else {
            echo "No shift data submitted.";
        }




       
    } else {
        echo "Invalid request.";
    }

    date_default_timezone_set("Indian/Mauritius");
    $current = date("Y-m-d H:i:s");
    $currentD = date("Y-m-d");
    $last = date('Y-m-d', strtotime('-1 day'));

    $shiftStart1 = date('Y-m-d H:i:s', strtotime($currentD . ' 08:00:00'));
    $shiftEnd1 = date('Y-m-d H:i:s', strtotime($currentD . ' 17:00:00'));
    

    $shiftStart2 = date('Y-m-d H:i:s', strtotime($currentD . ' 17:00:00'));
    $next2 = date('Y-m-d', strtotime($current . ' +1 day'));
    $shiftEnd2 = date('Y-m-d H:i:s', strtotime($next2 . ' 08:00:00'));

   
    
    


    $query = "SELECT * FROM staff_schedule WHERE date='$currentD'";
    $r = mysqli_query($db, $query);
    

    if (mysqli_num_rows($r) > 0) {
            
            
        while ($row = mysqli_fetch_assoc($r)) {
                
                        

            $Sid = $row['staff_id'];
            $shift = $row['shift'];

            if($shift==='d'){
                $query = "SELECT * FROM staff_schedule WHERE date='$last' AND staff_id='$Sid' AND (shift='n' OR shift='dn')";
                $r1 = mysqli_query($db, $query);
                $n = mysqli_fetch_assoc($r1);
                if($n){
                    
                        
                    if($current>$shiftEnd2){
                        if($current>$shiftStart1 && $current<$shiftEnd1){
                        
                            $updateQuery = "UPDATE samu_staff
                                            SET status='available' 
                                            WHERE id='$Sid' AND status='offduty'";
                            $result = mysqli_query($db, $updateQuery);
                        }else{
                            
                            $updateQuery = "UPDATE samu_staff
                                            SET status='offduty' 
                                            WHERE id='$Sid'";
                            $result = mysqli_query($db, $updateQuery);
                        }

                    }
                    else{
                            
                        $updateQuery = "UPDATE samu_staff
                                        SET status='available' 
                                        WHERE id='$Sid' AND status='offduty'";
                        $result = mysqli_query($db, $updateQuery);
                    }
                }else{
                    if($current>$shiftStart1 && $current<$shiftEnd1){
                        
                        $updateQuery = "UPDATE samu_staff
                                        SET status='available' 
                                        WHERE id='$Sid' AND status='offduty'";
                        $result = mysqli_query($db, $updateQuery);
                    }else{
                        
                        $updateQuery = "UPDATE samu_staff
                                        SET status='offduty' 
                                        WHERE id='$Sid'";
                        $result = mysqli_query($db, $updateQuery);
                    }
                }
                
                
            }
            else if($shift==='n'){
                $query = "SELECT * FROM staff_schedule WHERE date='$last' AND staff_id='$Sid' AND (shift='n' OR shift='dn')";
                $r1 = mysqli_query($db, $query);
                $n = mysqli_fetch_assoc($r1);
                if($n){
                    
                        
                    if($current>$shiftEnd2){
                  
                        if($current>$shiftStart2 && $current<$shiftEnd2){
                        
                            $updateQuery = "UPDATE samu_staff
                                            SET status='available' 
                                            WHERE id='$Sid' AND status='offduty'";
                            $result = mysqli_query($db, $updateQuery);
                        }else{
                            
                            $updateQuery = "UPDATE samu_staff
                                            SET status='offduty' 
                                            WHERE id='$Sid'";
                            $result = mysqli_query($db, $updateQuery);
                        }

                    }
                    else{
                            
                        $updateQuery = "UPDATE samu_staff
                                        SET status='available' 
                                        WHERE id='$Sid' AND status='offduty'";
                        $result = mysqli_query($db, $updateQuery);
                    }
                }else{
                    if($current>$shiftStart2 && $current<$shiftEnd2){
                        
                        $updateQuery = "UPDATE samu_staff
                                        SET status='available' 
                                        WHERE id='$Sid' AND status='offduty'";
                        $result = mysqli_query($db, $updateQuery);
                    }else{
                        
                        $updateQuery = "UPDATE samu_staff
                                        SET status='offduty' 
                                        WHERE id='$Sid'";
                        $result = mysqli_query($db, $updateQuery);
                    }
                }




                    
            }
            else if($shift==='dn'){

                $query = "SELECT * FROM staff_schedule WHERE date='$last' AND staff_id='$Sid' AND (shift='n' OR shift='dn')";
                $r1 = mysqli_query($db, $query);
                $n = mysqli_fetch_assoc($r1);
                if($n){
                    
                        
                    if($current>$shiftEnd2){
                        if($current>$shiftStart1 && $current<$shiftEnd2){
                        
                            $updateQuery = "UPDATE samu_staff
                                            SET status='available' 
                                            WHERE id='$Sid' AND status='offduty'";
                            $result = mysqli_query($db, $updateQuery);
                        }else{
                            
                            $updateQuery = "UPDATE samu_staff
                                            SET status='offduty' 
                                            WHERE id='$Sid'";
                            $result = mysqli_query($db, $updateQuery);
                        }

                    }
                    else{
                            
                        $updateQuery = "UPDATE samu_staff
                                        SET status='available' 
                                        WHERE id='$Sid' AND status='offduty'";
                        $result = mysqli_query($db, $updateQuery);
                    }
                }else{
                    if($current>$shiftStart1 && $current<$shiftEnd2){
                        
                        $updateQuery = "UPDATE samu_staff
                                        SET status='available' 
                                        WHERE id='$Sid' AND status='offduty'";
                        $result = mysqli_query($db, $updateQuery);
                    }else{
                        
                        $updateQuery = "UPDATE samu_staff
                                        SET status='offduty' 
                                        WHERE id='$Sid'";
                        $result = mysqli_query($db, $updateQuery);
                    }
                }
               
            
            }
            
            else if ($shift==='o'){
                $query = "SELECT * FROM staff_schedule WHERE date='$last' AND staff_id='$Sid' AND (shift='n' OR shift='dn')";
                $r1 = mysqli_query($db, $query);
                $n = mysqli_fetch_assoc($r1);
                if($n){
                    
                        
                    if($current>$shiftEnd2){       
                        $updateQuery = "UPDATE samu_staff
                                        SET status='offduty' 
                                        WHERE id='$Sid'";
                        $result = mysqli_query($db, $updateQuery);

                    }
                    else{
                            
                        $updateQuery = "UPDATE samu_staff
                                        SET status='available' 
                                        WHERE id='$Sid' AND status='offduty'";
                        $result = mysqli_query($db, $updateQuery);
                    }
                }else{
                    $updateQuery = "UPDATE samu_staff
                                    SET status='offduty' 
                                    WHERE id='$Sid'";
                    $result = mysqli_query($db, $updateQuery);
                }
                    

            }else{
                $updateQuery = "UPDATE samu_staff
                                SET status='offduty' 
                                WHERE id='$Sid'";
                $result = mysqli_query($db, $updateQuery);

            }
                

    
            
        }
            

    } else {
    //echo "No records found.";
    }

    header("location: ../php/Uscheduling.php");
}
?>
