<?php
    // Start the session
    session_start();
   
    $fnamep=$_POST['fnamep'];
    $lnamep=$_POST['lnamep'];
    $age=$_POST['age'];
    $gender=$_POST['gender'];
    $lat=$_POST['lat'];
    $long=$_POST['long'];
    $subject=$_POST['subject'];

    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $num=$_POST['num'];
    
    
    date_default_timezone_set("Indian/Mauritius");
    $report = date("Y-m-d H:i:s");

    
    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);

    }
    else{
        
        $user=$_SESSION['email'];
        
        
        $caller="SELECT id FROM control_officer WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);

        if($row){
            $query="INSERT INTO patient(firstname, lastname, age, gender) 
                VALUES('$fnamep', '$lnamep', '$age', '$gender')";
            mysqli_query($db, $query);

            
            $status="pending";

            if($fnamep!=""){

                $patient="SELECT id FROM patient ORDER BY id DESC LIMIT 1";
                $result=mysqli_query($db, $patient);
                $id=mysqli_fetch_assoc($result);
                $patientID=$id["id"];

                $query="INSERT INTO incident(latitude, longitude, description, status, reported_datetime, patient_id) 
                VALUES('$lat', '$long', '$subject', '$status', '$report', '$patientID')";
                $r=mysqli_query($db, $query);

                


                
            }else{
                $query="INSERT INTO incident(latitude, longitude, description, status, reported_datetime) 
                VALUES('$lat', '$long', '$subject', '$status', '$report')";
                $r=mysqli_query($db, $query);
            }

            $q="INSERT INTO public(firstname, lastname, phonenum) 
            VALUES('$fname', '$lname', '$num')";
            $res=mysqli_query($db, $q);
            if(!$res){
                echo $db->error;
            }
            

            $caller="SELECT id FROM public ORDER BY id DESC LIMIT 1";
            $result=mysqli_query($db, $caller);
            $row=mysqli_fetch_assoc($result);
            $id=$row['id'];

            $q1="SELECT id FROM incident ORDER BY id DESC LIMIT 1";
            $r1=mysqli_query($db, $q1);
            $row1=mysqli_fetch_assoc($r1);
            $id1=$row1['id'];

            $q1="UPDATE incident
                    SET public_id='$id'
                    WHERE id='$id1'";
            $r1=mysqli_query($db, $q1);

           




            

            


            echo "<h2>Incident successfully reported!</h2>";
            //header("location: ../html/home.html");
            
        }
        else{
            echo "<h2>Invalid User!</h2>";
            
        }
    }
?>