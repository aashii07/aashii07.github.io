<?php
    // Start the session
    session_start();
   
    $fnamep=$_POST['fnamep'];
    $lnamep=$_POST['lnamep'];
    $age=$_POST['age'];
    $gender=$_POST['gender'];
    $loc=$_POST['loc'];
    $subject=$_POST['subject'];
    
    date_default_timezone_set("Indian/Mauritius");
    $report = date("Y-m-d H:i:s");

    
    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);

    }
    else{
        
        $user=$_SESSION['email'];
        
        $caller="SELECT id FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);

        if($row){
            $query="INSERT INTO patient(firstname, lastname, age, gender) 
                VALUES('$fnamep', '$lnamep', '$age', '$gender')";
            mysqli_query($db, $query);

            $patient="SELECT id FROM patient ORDER BY id DESC LIMIT 1";
            $result=mysqli_query($db, $patient);
            $id=mysqli_fetch_assoc($result);
            $patientID=$id["id"];


            $callerID=$row["id"];
            $status="pending";

            $query="INSERT INTO incident(location, description, status, reported_datetime, patient_id, public_id) 
                VALUES('$loc', '$subject', '$status', '$report', '$patientID', '$callerID')";
            mysqli_query($db, $query);

            echo "<h2>Incident successfully reported!</h2>";
            //header("location: ../htmlC/home.html");
            
        }
        else{
            echo "<h2>Invalid User!</h2>";
            
        }
    }
?>