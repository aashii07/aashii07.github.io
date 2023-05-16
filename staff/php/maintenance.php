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

        $query = "UPDATE vehicle
                    SET status='maintenance'
                    WHERE id='$id'";
        $result = mysqli_query($db, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($db);
        }
        

        header("location: ../html/Sstatus.html");
    }
?>