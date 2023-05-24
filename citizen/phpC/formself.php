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
        
        $caller="SELECT id, firstname, lastname, DATEDIFF(CURDATE(), dob)/365.25, gender, email FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);
        $callerID=$row["id"];
        $fname=$row["firstname"];
        $lname=$row["lastname"];
        $age=$row["DATEDIFF(CURDATE(), dob)/365.25"];
        $gender=$row["gender"];
        $email=$row["email"];

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



          



            echo "<h2>Incident successfully reported!</h2>";
            header("location: home.php");
            
        }
        else{
            echo "<h2>Invalid User!</h2>";
            
        }
    }
?>