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
   
    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);

    }
    else{
        $id = $_GET['id'];

        $email=$_SESSION['email'];
        $q="SELECT * FROM public WHERE email='$email'";
        $r=mysqli_query($db, $q);
        $row=mysqli_fetch_assoc($r);
        $fname=$row['firstname'];

        $q="SELECT * FROM incident WHERE id='$id'";
        $r=mysqli_query($db, $q);
        $row=mysqli_fetch_assoc($r);
        $des=$row['description'];

        
        $caller="UPDATE incident 
                    SET status='cancelled' 
                    WHERE id='$id'";
        $result=mysqli_query($db, $caller);

        // Set up email parameters
        $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
        $mail->addAddress($email, 'Public');
        $mail->Subject = 'Cancellation of Incident Report';
        $mail->Body = 'Dear '.$fname.',

You have requested to cancel the incident report with the following description: '.$des.'

Your request has been received and processed accordingly. 
Thank you for your collaboration.

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



        header("location: home.php");

        
    }
?>