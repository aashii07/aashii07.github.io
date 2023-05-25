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
    
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $num=$_POST['num'];
    $gender=$_POST['gender'];
    $dob=$_POST['dob'];
    $psw=$_POST['psw'];
    $psw2=$_POST['psw2'];

    include 'message.php';

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        //check if already has an account
        $check="SELECT * FROM public WHERE email='$email' LIMIT 1";
        $result=mysqli_query($db, $check);
        $user=mysqli_fetch_assoc($result);

        if($user){
            $pw=$user['password'];
            
            if($pw==""){
                $query="UPDATE public
                        SET firstname='$fname', lastname='$lname', phonenum='$num', gender='$gender', dob='$dob', password='$psw', password2='$psw2'
                        WHERE email='$email'";
                mysqli_query($db, $query);

                $_SESSION['email']=$email;
               

                // Set up email parameters
                $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
                $mail->addAddress($email, 'Public');
                $mail->Subject = 'Successful Signup Confirmation for SAMU IMS';
                $mail->Body = 'Dear '.$fname.',

You have successfully signed up for SAMU IMS! 

Our platform streamlines the incident response process and enables real-time communication between team members. Log in to your account to explore our various features and tools. If you have any questions, our support team is always available to assist you.

Thank you for choosing SAMU IMS. We are confident that our platform will help you manage incidents more efficiently.

Best regards,
SAMU IMS Team';
                
                try {
                // Send the email
                        $mail->send();
                        //echo 'Email sent successfully.';
                } catch (Exception $e) {
                        //echo 'An error occurred. Email not sent.';
                        //echo 'Error: ' . $mail->ErrorInfo;
                }
                header("location: ../htmlC/home.html");

            }else{
                //echo "<h2>This email has already been registered.</h2>";
                $msg = '<h2>Error Message<hr></h2>';
                $msg .= '<p>This email has already been registered.</p>';
                $msg .= '<div class="button-container">';
                $msg .= '<button onclick="window.location.href=\'../htmlC/login.html\'">Close</button>';
                $msg .= '</div>';
                generateMessageBox($msg);

            }
            
            
        }
        else{
            if ($psw !== $psw2) {
                /*echo "<h2>Passwords do not match!</h2>";
                $msg = '<h2>Error Message<hr></h2>';
                $msg .= '<p>Passwords do not match!</p>';
                $msg .= '<div class="button-container">';
                $msg .= '<button onclick="window.location.href=\'../htmlC/signup.html\'">Close</button>';
                $msg .= '</div>';
                generateMessageBox($msg);*/
            }
            else{
                
                $query="INSERT INTO public(firstname, lastname, email, phonenum, gender, dob, password, password2) 
                    VALUES('$fname', '$lname', '$email', '$num', '$gender', '$dob', '$psw', '$psw2')";
                mysqli_query($db, $query);
                $_SESSION['email']=$email;
               

                // Set up email parameters
                $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
                $mail->addAddress($email, 'Public');
                $mail->Subject = 'Successful Signup Confirmation for SAMU IMS';
                $mail->Body = 'Dear '.$fname.',

You have successfully signed up for SAMU IMS! 

Our platform streamlines the incident response process and enables real-time communication between team members. Log in to your account to explore our various features and tools. If you have any questions, our support team is always available to assist you.

Thank you for choosing SAMU IMS. We are confident that our platform will help you manage incidents more efficiently.

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
        }
    }
?>