<?php
    // Start the session
    session_start();
   
    $fnamep=$_POST['fnamep'];
    $lnamep=$_POST['lnamep'];
    $age=$_POST['age'];
    $gender=$_POST['gender'];
    $subject=$_POST['subject'];
    
    date_default_timezone_set("Indian/Mauritius");
    $date=date("Y-m-d");
    $time=date("H:i:s");
    
    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);

    }
    else{
        
        $user=$_SESSION['email'];
        
        $caller="SELECT id FROM signup WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);

        if($row){
            $callerID=$row["id"];

            $query="INSERT INTO patient(firstname, lastname, age, gender, description, date, time, callerid) 
                VALUES('$fnamep', '$lnamep', '$age', '$gender', '$subject', '$date', '$time', '$callerID')";
            mysqli_query($db, $query);

            echo "<h2>Incident successfully reported!</h2>";
            //header("location: ../htmlC/home.html");
            
        }
        else{
            echo "<h2>Invalid User!</h2>";
            
        }
    }
?>