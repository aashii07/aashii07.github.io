<?php

    // Start the session
    session_start();

    $id=$_POST['incident_id'];
    $condition=$_POST['condition'];
    $treatment=$_POST['treatment'];
    
   

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{

        date_default_timezone_set("Indian/Mauritius");
        $onsite = date("Y-m-d H:i:s");
        
    echo $condition, $treatment;

        $query = "UPDATE incident
                    SET status='closed', closed_datetime='$onsite', treatment='$treatment', posttreatment_condition='$condition'
                    WHERE id='$id'";
        $result = mysqli_query($db, $query);

        $query = "UPDATE vehicle AS v
                    INNER JOIN incident AS i ON i.vehicle_id = v.id
                    SET v.status = 'available'
                    WHERE i.id = '$id'";
        $result = mysqli_query($db, $query);

        $query = "UPDATE samu_staff AS s
                    INNER JOIN incident_staff AS i ON i.staff_id = s.id
                    SET s.status = 'available'
                    WHERE i.incident_id = '$id'";
        $result = mysqli_query($db, $query);

        header("location: ../html/Sstatus.html");

        
        
        
          
            
       
    }
?>