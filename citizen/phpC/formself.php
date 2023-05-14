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
        
        $caller="SELECT id, firstname, lastname, DATEDIFF(CURDATE(), dob)/365.25, gender FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);
        $callerID=$row["id"];
        $fname=$row["firstname"];
        $lname=$row["lastname"];
        $age=$row["DATEDIFF(CURDATE(), dob)/365.25"];
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

            // Find the closest hospital
            $hospitals = "SELECT id, SQRT(POW(69.1 * (latitude - $lat), 2) + POW(69.1 * ($long - longitude) * COS(latitude / 57.3), 2)) AS distance 
                          FROM hospital ORDER BY distance ASC LIMIT 1";
            $result = mysqli_query($db, $hospitals);
            $hospital = mysqli_fetch_assoc($result);
            $hospitalID = $hospital["id"];




        




            $status="pending";

            $query="INSERT INTO incident(latitude, longitude, description, status, reported_datetime, patient_id, public_id, hospital_id) 
                VALUES('$lat', '$long', '$subject', '$status', '$report', '$patientID', '$callerID', '$hospitalID')";
            mysqli_query($db, $query);

          



            echo "<h2>Incident successfully reported!</h2>";
            //header("location: ../htmlC/home.html");
            
        }
        else{
            echo "<h2>Invalid User!</h2>";
            
        }
    }
?>