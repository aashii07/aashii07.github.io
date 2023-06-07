<?php
    // Start the session
    session_start();

    // Include the Composer autoloader
    require 'PHPMailer-master/vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Set up SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
    $mail->Port = 587;  // Specify the SMTP port
    // Enable SMTP encryption
    $mail->SMTPSecure = 'tls'; // or 'ssl' for SSL encryption
    $mail->SMTPAuth = true;
    $mail->Username = 'aashi.jaulim@gmail.com';  // Your SMTP username
    $mail->Password = 'hhjqbxsjjwrqbpee';  // Your SMTP password
   
    $fnamep=$_POST['fnamep'];
    $lnamep=$_POST['lnamep'];
    $age=$_POST['age'];
    $gender=$_POST['gender'];
    $lat=$_POST['lat'];
    $long=$_POST['long'];
    $subject=$_POST['subject'];

    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
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

            if($fnamep!="" && $lnamep!="" && $age!=""){

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

            if($email !=""){

                /*$p2="SELECT * FROM public WHERE email='$email'";
                $r2=mysqli_query($db, $p2);
                $res=mysqli_fetch_assoc($r2);
                if(!$res){

                    $q="INSERT INTO public(firstname, lastname, email, phonenum) 
                        VALUES('$fname', '$lname', '$email', '$num')";
                    $res=mysqli_query($db, $q);
                    if(!$res){
                        echo $db->error;
                    }

                }*/

                $caller="SELECT * FROM public WHERE email='$email'";
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

                $q1="UPDATE public
                        SET firstname='$fname', lastname='$lname', phonenum='$num'
                        WHERE id='$id'";
                $r1=mysqli_query($db, $q1);

                $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
                $mail->addAddress($email, 'Public');
                $mail->Subject = 'Incident Reporting';
                $mail->Body = 'Dear '.$fname.',

You have successfully reported an incident.

We will be at your service as soon as possible.

Thank you for choosing SAMU IMS.

Best regards,
SAMU IMS Team';

                try {
                // Send the email
                        $mail->send();
                        echo 'Email sent successfully.';
                } catch (Exception $e) {
                        echo 'An error occurred. Email not sent.';
                        echo 'Error: ' . $mail->ErrorInfo;
                }
            }

            
                

           



            // PHP code
            $pythonScript = 'severity.py';
            $command = 'C:\Users\aashi\AppData\Local\Programs\Python\Python311\python.exe ' . $pythonScript . ' 2>&1';

            // Execute the command and capture output and error streams
            exec($command, $outputLines, $returnStatus);

            if ($returnStatus === 0) {
                // Execution was successful
                echo "Output:<br>";
                foreach ($outputLines as $line) {
                    echo $line . "<br>";
                }
            } else {
                // Execution encountered an error
                echo "Error occurred:<br>";
                foreach ($outputLines as $line) {
                    echo $line . "<br>";
                }
                echo "Return status: " . $returnStatus;
            }


            


            echo "<h2>Incident successfully reported!</h2>";
            header("location: ../html/home.php");
            
        }
        else{
            echo "<h2>Invalid User!</h2>";
            
        }
    }
?>