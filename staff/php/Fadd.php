<?php

    // Start the session
    session_start();

    $type=$_POST['type'];
    $license=$_POST['license'];

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{

        $staff=$_SESSION['email'];
        $user = "SELECT hospital_id
                    FROM samu_staff
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);
        $hos = $staff['hospital_id'];

        $status="available";

        $q="INSERT INTO vehicle (type, license, status, hospital_id)
            VALUES ('$type', '$license', '$status', '$hos')"; 
        $r = mysqli_query($db, $q);
        
        header("location: ../html/Fadd.html");
    }
?>