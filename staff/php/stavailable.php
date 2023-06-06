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

        $staff=$_SESSION['email'];
        $user = "SELECT *
                    FROM samu_staff
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);
        $rl = $staff['role'];

        $query = "UPDATE samu_staff
                    SET status='available'
                    WHERE id='$id'";
        $result = mysqli_query($db, $query);

        if($rl=="u"){
            header("location: ../html/Uhome.php");
        }else if($rl=="f"){
            header("location: ../html/Fhome.php");
        }else{
            header("location: EPhome.php");
        }

       
    }
?>