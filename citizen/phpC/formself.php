<?php
    // Start the session
    session_start();
   
    $lat=$_POST['lat'];
    $long=$_POST['long'];
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
        $callerID=$row["id"];

        $caller="SELECT firstname FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);
        $fname=$row["firstname"];

        $caller="SELECT lastname FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);
        $lname=$row["lastname"];

        $caller="SELECT DATEDIFF(CURDATE(), dob)/365.25 FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);
        $age=$row["DATEDIFF(CURDATE(), dob)/365.25"];

        $caller="SELECT gender FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);
        $gender=$row["gender"];

        if($row){
            $check="SELECT id FROM patient WHERE firstname='$fname' AND lastname='$lname' LIMIT 1";
            $result=mysqli_query($db, $check);
            $old=mysqli_fetch_assoc($result);
            
            if($old){
                $patientID=$old["id"];
            }else{
                $query="INSERT INTO patient(firstname, lastname, age, gender) 
                VALUES('$fname', '$lname', '$age', '$gender')";
                mysqli_query($db, $query);
            }
            

            $patient="SELECT id FROM patient ORDER BY id DESC LIMIT 1";
            $result=mysqli_query($db, $patient);
            $id=mysqli_fetch_assoc($result);
            $patientID=$id["id"];

            
            $status="pending";

            $query="INSERT INTO incident(latitude, longitude, description, status, reported_datetime, patient_id, public_id) 
                VALUES('$lat', '$long', '$subject', '$status', '$report', '$patientID', '$callerID')";
            mysqli_query($db, $query);

            echo "<h2>Incident successfully reported!</h2>";
            //header("location: ../htmlC/home.html");
            
        }
        else{
            echo "<h2>Invalid User!</h2>";
            
        }
    }
?>