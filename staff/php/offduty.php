<?php

    // Start the session
    session_start();

    $id=$_POST['id'];
    
   

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{

        $query = "UPDATE samu_staff
                    SET status='offduty'
                    WHERE id='$id'";
        $result = mysqli_query($db, $query);

        header("location: ../html/Sstatus.html");
    }
?>